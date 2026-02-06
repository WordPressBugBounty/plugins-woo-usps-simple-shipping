<?php declare(strict_types=1);
namespace Dgm\UspsSimple;


class DismissibleNotices
{
    public static function init(): void
    {
        add_action('admin_enqueue_scripts', array(__CLASS__, '_enqueueScripts'));
        add_action('wp_ajax_dgm_dismiss_admin_notice', array(__CLASS__, '_dismissNotice'));
    }

    public static function dismissed($noticeId): bool
    {
        return (bool)get_site_transient($noticeId);
    }

    public static function _enqueueScripts(): void
    {
        wp_enqueue_script(
            'dgm-dismissible-notices',
            plugins_url('dismiss-notice.js', __FILE__),
            array('jquery', 'common'),
            false,
            true
        );

        wp_localize_script(
            'dgm-dismissible-notices',
            'dgm_dismissible_notice',
            array(
                'nonce' => wp_create_nonce('dgm-dismissible-notice'),
            )
        );
    }

    public static function _dismissNotice(): void
    {
        $id = sanitize_text_field($_POST['id']);
        check_ajax_referer('dgm-dismissible-notice', 'nonce');

        $parts = explode("|", $id, 2);
        $id = $parts[0];
        $exp = isset($parts[1]) ? (int)$parts[1] : 0;

        set_site_transient($id, true, $exp);

        /** @noinspection ForgottenDebugOutputInspection */
        wp_die();
    }
}

