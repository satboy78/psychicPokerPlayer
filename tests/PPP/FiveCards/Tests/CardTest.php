<?php

namespace PPP\FiveCards\Tests;

use PPP\FiveCards\Card;

class CardTest extends \PHPUnit\Framework\TestCase
{
    public function testTryValidCard()
    {
        $card = new Card('TH');

        $this->assertEquals(
            49, 
            $card->getHash()
        );

        $this->assertNotEquals(
            50, 
            $card->getHash()
        );
    }

    public function testTryUnacceptableCard()
    {
        $card = new Card('TT');
        $this->assertLessThan(14, $card->getHash());

        $card = new Card('1T');
        $this->assertLessThan(14, $card->getHash());
    }
}
