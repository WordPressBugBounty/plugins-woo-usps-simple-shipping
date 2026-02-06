<?php declare(strict_types=1);

namespace Dgm\UspsSimple\Calc;

/**
 * @immutable
 */
class Product
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $price;

    /**
     * Weight in lbs
     * @var int|float >=0
     */
    public $weight;

    /**
     * Dimensions in inches
     * @var Dim
     */
    public $dim;


    public static function fromWcProduct(\WC_Product $p): self
    {
        $name = $p->get_name();
        $price = $p->get_price();

        $weight = Number::intOrFloat(wc_get_weight($p->get_weight(), 'lbs'));

        $dim = new Dim(
            wc_get_dimension(Number::intOrFloat($p->get_length()), 'in'),
            wc_get_dimension(Number::intOrFloat($p->get_width()), 'in'),
            wc_get_dimension(Number::intOrFloat($p->get_height()), 'in')
        );

        return new self($name, $price, $weight, $dim);
    }

    public function __construct($name, $price, $weight, Dim $dim)
    {
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight;
        $this->dim = $dim;
    }
}