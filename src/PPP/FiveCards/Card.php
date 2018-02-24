<?php
namespace PPP\FiveCards;

class Card implements \PPP\Interfaces\CardInterface
{
    public $rank;
    public $suit;
    public $text;

    /**
     * Map each card and each suit with a corresponding value
     */
    public function __construct($str)
    {
        $this->text = $str;
        $this->rank = $str[0];
        $this->suit = $str[1];

        switch ($this->rank) {
            case 'A':
                $this->rank = 1;
                break;
            case 'T':
                $this->rank = 10;
                break;
            case 'J':
                $this->rank = 11;
                break;
            case 'Q':
                $this->rank = 12;
                break;
            case 'K':
                $this->rank = 13;
                break;
        }

        switch ($this->suit) {
            case 'C':
                $this->suit = 1;
                break;
            case 'D':
                $this->suit = 2;
                break;
            case 'H':
                $this->suit = 3;
                break;
            case 'S':
                $this->suit = 4;
                break;
        }
    }

    /**
     * A simple hash function, for having a unique value for each poker card
     * With this numeric representation of cards the algorithm for picking
     * the best hand is quite simple.
     */
    public function getHash()
    {
        return $this->suit * 13 + $this->rank;
    }

    public function toString()
    {
        return $this->text;
    }
}
