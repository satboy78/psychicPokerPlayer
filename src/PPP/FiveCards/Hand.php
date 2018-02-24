<?php
namespace PPP\FiveCards;

class Hand implements HandRankings, \PPP\Interfaces\HandInterface
{
    public $cards;

    public function __construct()
    {
        $this->cards = array();
    }

    public function addCard(\PPP\Interfaces\CardInterface $card)
    {
        $this->cards[$card->getHash()] = $card;
    }

    public function removeCard(\PPP\Interfaces\CardInterface $card)
    {
        unset($this->cards[$card->getHash()]);
    }

    public function getRanking()
    {
        $handRanking = 0;
        $flush = false;
        $straight = false;

        $ranks = array();
        $suits = array();
        foreach ($this->cards as $card) {
            $cardHash = $card->getHash();
            $mod = $cardHash % 13;
            $quot = intval($cardHash / 13);
            if ($mod === 0) {
                $ranks[] = 13;
                $suits[$quot - 1] += 1;
            } else {
                $ranks[] = $mod;
                $suits[$quot] += 1;
            }
        }
        ksort($ranks);
        $uniqueRanks = array_count_values($ranks);
        $arraySumRanks = array_sum($ranks);
        $minRank = min($ranks);
        $maxRank = max($ranks);
        $numUniqueRanks = count($uniqueRanks);
        $numUniqueSuits = count($suits);

        // five cards of sequential rank
        // max – min + 1 = n, where n is the number of items in array
        // all numbers have to be distinct
        $sequenceCheck = $maxRank - $minRank + 1;
        if ($sequenceCheck === 5 && $numUniqueRanks == 5) {
            $straight = true;
            $handRanking = Hand::STRAIGHT;
        }

        // special condition for the A T J Q K sequence
        if ($sequenceCheck === 13 && empty(array_diff(array(1, 10, 11, 12, 13), $ranks))) {
            $straight = true;
            $handRanking = Hand::STRAIGHT;
        }

        // five cards of the same suit
        if ($numUniqueSuits === 1) {
            $flush = true;
            $handRanking = Hand::FLUSH;
        }

        if (($straight === true && $flush === true)) {
            return Hand::STRAIGHT_FLUSH;
        }

        // early exit for flush or straight
        if (($straight === true || $flush === true)) {
            return $handRanking;
        }

        // 2 ranks
        if ($numUniqueRanks === 2) {
            // four cards of the same rank and one card of another rank
            if (in_array(4, $uniqueRanks)) {
                return Hand::FOUR_OF_A_KIND;
            } else {
                return Hand::FULL_HOUSE;
            }
        }

        // 3 ranks
        if ($numUniqueRanks === 3) {
            // three cards of the same rank and two cards of two other ranks
            if (in_array(3, $uniqueRanks)) {
                return Hand::THREE_OF_A_KIND;
            }
            // two cards of the same rank, two cards of another rank and one card of a third rank
            if (in_array(2, $uniqueRanks)) {
                return Hand::TWO_PAIRS;
            }
        }

        // 4 ranks
        if ($numUniqueRanks === 4) {
            // two cards of the same rank and three cards of three other ranks
            if (in_array(2, $uniqueRanks)) {
                return Hand::ONE_PAIR;
            }
        }

        // 5 ranks
        if ($numUniqueRanks === 5) {
            return Hand::HIGHEST_CARD;
        }
    }

    public function toString()
    {
        foreach ($this->cards as $card) {
            $str[] = $card->toString();
        }
        return implode(' ', $str);
    }
}
