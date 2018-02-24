<?php
namespace PPP\Interfaces;

interface DeckInterface
{
    /**
     * @param \PPP\Interfaces\CardInterface $card
     */
    public function addCard(\PPP\Interfaces\CardInterface $card);

    public function removeCard();

    /**
     * @return string
     */
    public function toString();
}
