<?php

namespace Tests\Unit;

use App\Helpers\Parser\PriceOlx;
use App\Models\Price;
use Tests\TestCase;

class ParserTest extends TestCase
{
    /**
     * @var OlxPrice
     */
    protected $olx;

    /**
     * Setting up test.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->olx = new PriceOlx(null);
    }

    /**
     * Parse url test.
     *
     * @return void
     */
    public function testParsing(): void
    {
        $this->assertEmpty($this->olx->parse('https://google.com'));
    }

    /**
     * Get amount test.
     * 
     * @return void
     */
    public function testAmount(): void
    {
        $a = [(object)[
            'textContent' => '99.99 UAH',
        ]];
        $this->assertEquals(99.99, $this->olx->getAmount($a));
    }
}
