<?php

namespace App\Helpers\Parser;

class PriceOlx extends PriceAbstract
{
    /**
     * @var string
     */
    protected $attribute = "/html/body//div[@data-testid='ad-price-container']/h3";

    /**
     * PriceOlx constructor.
     * 
     * @param Collection $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
    }

    /**
     * Format amount from parsed string.
     * 
     * @param mixed $value
     * @return float
     */
    public function getAmount($value): float
    {
        return preg_replace("/[^0-9.]/", "", trim($value[0]->textContent, '.'));
    }
}
