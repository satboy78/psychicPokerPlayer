<?php
namespace PPP\Interfaces;

interface HandInterface
{
    /**
     * @param \PPP\Interfaces\CardInterface $card
     */
    public function addCard(\PPP\Interfaces\CardInterface $card);

    /**
     * @param \PPP\Interfaces\CardInterface $card
     */
    public function removeCard(\PPP\Interfaces\CardInterface $card);

    /**
     * @return int
     */
    public function getRanking();

    /**
     * @return string
     */
    public function toString();
}
