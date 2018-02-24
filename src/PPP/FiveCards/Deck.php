<?php
namespace PPP\FiveCards;

class Deck implements \PPP\Interfaces\DeckInterface
{
    public $cards;

    public function __construct()
    {
        $this->cards = array();
    }

    public function addCard(\PPP\Interfaces\CardInterface $card)
    {
        array_push($this->cards, $card);
    }

    public function removeCard()
    {
        return array_shift($this->cards);
    }

    public function toString()
    {
        foreach ($this->cards as $card) {
            $str[] = $card->toString();
        }
        return implode(' ', $str);
    }
}
