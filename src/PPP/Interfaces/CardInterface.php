<?php
namespace PPP\Interfaces;

interface CardInterface
{
    /**
     * @return int
     */
    public function getHash();

    /**
     * @return string
     */
    public function toString();
}
