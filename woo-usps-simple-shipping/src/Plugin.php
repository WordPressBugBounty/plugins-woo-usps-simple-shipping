<?php
namespace Dgm\UspsSimple;

use Automattic\WooCommerce\Utilities\FeaturesUtil;


class Plugin {

    public const WOO_ID = 'usps_simple';

    public static function init(string $pluginFile): void {

        if (isset(self::$instance)) {
            if (self::$instance->pluginFile !== $pluginFile) {
                throw new \LogicException('plugin initialized more than one with different parameters');
            }
            return;
        }

        self::$instance = new self($pluginFile);
    }

    public static function instance(): self {
        if (!isset(self::$instance)) {
            throw new \LogicException('plugin is not initialized yet');
        }
        return self::$instance;
    }

    public function createDebug(): Debug
    {
        return Debug::default($this->pluginFile);
    }


    /** @var string */
    private $pluginFile;

    private function __construct(string $pluginFile) {
        $this->pluginFile = $pluginFile;
        self::declareHposCompat($pluginFile);
        self::registerShippingMethod();
        ShippingMethod::handleStorePostcodeChange();
        self::registerPluginActionLink($pluginFile);
        self::displayRetirementNotice();
    }

    /**
     * @var self
     */
    private static $instance;

    private static function displayRetirementNotice(): void
    {
        $noticeId = 'uspssimple-retirement-notice';

        if (!ShippingMethod::hasSettingsStatic()) {
            set_site_transient($noticeId, true, 86400*365);
            return;
        }

        DismissibleNotices::init();

        add_action('admin_notices', function() use($noticeId) {

            if (DismissibleNotices::dismissed($noticeId)) {
                return;
            }

            $contentKey = 'uspssimple-retirement-notice-content';
            $content = get_transient($contentKey);
            if (!$content) {
                $content = file_get_contents('https://uspsapi.aikinomi.io/retirement');
                if (!$content) {
                    $content = defaultRetirementNotice;
                }
                set_transient($contentKey, $content, 3*3600);
            }

            echo $content;
        });
    }

    /** @noinspection PhpSameParameterValueInspection */
    private static function shippingUrl(string $section = null): string
    {
        $query = array(
            "page" => "wc-settings",
            "tab" => "shipping",
        );

        if (isset($section)) {
            $query['section'] = $section;
        }

        $query = http_build_query($query, '', '&');

        return admin_url("admin.php?$query");
    }

    private static function prependPluginActions(array $current, array $new): array {

        foreach ($new as $url => &$label) {
            $label = '<a href="'.esc_html($url).'">'.esc_html($label).'</a>';
        }
        unset($label);

        array_splice($current, 0, 0, $new);

        return $current;
    }

    private static function registerShippingMethod(): void {
        add_filter('woocommerce_shipping_methods', static function(array $methods) {
            $methods[] = ShippingMethod::class;
            return $methods;
        });
    }

    private static function declareHposCompat(string $pluginFile): void {
        add_action('before_woocommerce_init', static function() use($pluginFile) {
            if (class_exists(FeaturesUtil::class)) {
                FeaturesUtil::declare_compatibility('custom_order_tables', $pluginFile, true);
            }
        });
    }

    private static function registerPluginActionLink(string $pluginFile): void {
        add_filter('plugin_action_links_' . plugin_basename($pluginFile), static function(array $links) {
            return self::prependPluginActions($links, [
                self::shippingUrl(Plugin::WOO_ID) => __('Settings', 'woo-usps-simple-shipping')
            ]);
        });
    }
}

const defaultRetirementNotice = '
	<div class="notice notice-error is-dismissible" data-dismissible="uspssimple-retirement-notice"  style="max-width: 40em">
		<h2>USPS WebTools API Retirement — 25 January 2026</h2>
		<p>
			USPS Simple calculated online shipping rates using the USPS WebTools API,
			which was <b>shut down</b> on 25 January 2026. For more information, please refer to the
			official announcement on usps.com.
		</p>
		<p>
			As of this date, USPS Simple stopped providing
			Priority Mail Express and Retail Ground options to your customers.
		</p>
		<p>
			Priority Mail, First-Class Mail, Ground Advantage, Media Mail, and Library Mail switched to
			<b>retail rates</b>, but otherwise continued working as usual.
		</p>
		<p>
			No action is required if you didn\'t use commercial rates, Priority Mail Express, or Retail Ground. Otherwise,
			please consider replacing them with custom shipping rules (see
            <a target="_blank" href="https://wordpress.org/plugins/weight-based-shipping-for-woocommerce/">Weight Based Shipping</a> or
			<a target="_blank" href="https://tablerateshipping.com/">Tree Table Rate Shipping</a>),
			using a custom code snippet, or switching to a different plugin that provides live USPS rates.
		</p>
	</div>
';