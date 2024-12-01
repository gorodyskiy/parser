<?php

namespace App\Helpers\Parser;

abstract class PriceAbstract
{
	/**
     * @var Collection
     */
    protected $adverts;

    /**
     * @var string
     */
    protected $attribute;

    /**
     * PriceAbstract constructor.
     * 
     * @param Collection $adverts
     */
    public function __construct($adverts)
    {
        $this->adverts = $adverts;
    }

    /**
     * Format amount from parsed string.
     * 
     * @param mixed $value
     * @return float
     */
    abstract public function getAmount($value): float;

    /**
     * Get new prices and update Collection.
     * 
     * @return void
     */
    public function refresh()
    {
        foreach ($this->adverts as $key => $advert) {
            $price = $this->parse($advert->link);
            if (!preg_match("/^\d+(?:\.\d+)?$/", $price) || $advert->amount == $price) {
                $this->adverts->forget($key);
            } else {
                $advert->amount = $price;
            }
        }
    }

    /**
     * Get new advert price.
     * 
     * @param string $url
     * @return string|false
     */
    private function parse(string $url): ?string
    {
        try {
            libxml_use_internal_errors(true);

            $html = file_get_contents($url);
            $dom = new \DOMDocument();
            $dom->loadHTML($html);
            $xpath = new \DOMXpath($dom);
            $nodes = $xpath->query($this->attribute);

            return $this->getAmount($nodes);
        }
        catch (\Exception $e) {
            // to do: write log $e->getMessage()
            return false;
        }
    }
}
