<?php /** @noinspection PhpMultipleClassesDeclarationsInOneFile */
declare(strict_types=1);

namespace Dgm\UspsSimple\Model;


class Services
{
    /**
     * @readonly
     * @var array<ServiceFamily>
     */
    public $families;

    /**
     * @var bool
     * @readonly
     */
    public $retailGroundEnabled;

    /**
     * @param ?callable(string $familyId, string $default): string $serviceFamilyTitle
     * @param ?callable(string $familyId, string $serviceId): bool $serviceEnabled
     * @param bool $skipInactive
     */
    public function __construct(?callable $serviceFamilyTitle = null, ?callable $serviceEnabled = null, bool $skipInactive = false)
    {
        $priorityMail = new ServiceFamily(
            'priority_mail',
            __('Priority Mail', 'woo-usps-simple-shipping'),
            [
                new Service(
                    __('Regular — based on weight, size, and zone', 'woo-usps-simple-shipping'),
                    'regular'
                ),
                new Service(
                    __('Flat Rate — Small Box', 'woo-usps-simple-shipping'),
                    'small_flat_rate_box'
                ),
                new Service(
                    __('Flat Rate — Medium Box 1 (top-loading)', 'woo-usps-simple-shipping'),
                    'medium_flat_rate_box_1'
                ),
                new Service(
                    __('Flat Rate — Medium Box 2 (side-loading)', 'woo-usps-simple-shipping'),
                    'medium_flat_rate_box_2'
                ),
                new Service(
                    __('Flat Rate — Large Box', 'woo-usps-simple-shipping'),
                    'large_flat_rate_box'
                ),
            ]
        );

        $firstClass = new ServiceFamily(
            'first_class',
            __('First-Class Mail', 'woo-usps-simple-shipping'),
            [
                new Service(
                    __('Postcard', 'woo-usps-simple-shipping'),
                    '0A'
                ),
                new Service(
                    __('Letter', 'woo-usps-simple-shipping'),
                    '0B'
                ),
                new Service(
                    __('Large Envelope', 'woo-usps-simple-shipping'),
                    '0C'
                ),
            ]
        );

        $groundAdvantage = new ServiceFamily(
            'ground_advantage',
            __('Ground Advantage', 'woo-usps-simple-shipping'),
            [
                new GroundAdvantage(__('Ground Advantage', 'woo-usps-simple-shipping')),
            ]
        );

        $media = new ServiceFamily(
            'media_mail',
            __('Media Mail', 'woo-usps-simple-shipping'),
            [
                new Service(
                    __('Media Mail', 'woo-usps-simple-shipping'),
                    '6'
                ),
            ]
        );

        $library = new ServiceFamily(
            'library_mail',
            __('Library Mail', 'woo-usps-simple-shipping'),
            [
                new Service(
                    __('Library Mail', 'woo-usps-simple-shipping'),
                    '7'
                ),
            ]
        );


        /** @var array<ServiceFamily> $families */
        $families = [$priorityMail, $firstClass, $groundAdvantage, $media, $library];
        foreach ($families as $i => $family) {

            if (isset($serviceFamilyTitle)) {
                $family->title = $serviceFamilyTitle($family->id, $family->title);
            }

            $family->sort = $i;

            foreach ($family->services as $k => $service) {

                $service->family = $family;

                if (isset($serviceEnabled)) {
                    $service->enabled = $serviceEnabled($family->id, $service->id);
                }

                if ($skipInactive && !$service->enabled) {
                    unset($family->services[$k]);
                }
            }

            if (!$family->services) {
                unset($families[$i]);
            }
        }

        $this->families = $families;

        $this->retailGroundEnabled = !empty($retailGround->services) && reset($retailGround->services)->enabled;
    }

    public function empty(): bool
    {
        return empty($this->families);
    }
}


class GroundAdvantage extends Service
{
    public function __construct(string $title)
    {
        parent::__construct($title, 'default');
    }
}