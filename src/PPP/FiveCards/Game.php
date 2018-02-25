<?php
namespace PPP\FiveCards;

class Game implements HandRankings, \PPP\Interfaces\GameInterface
{

    public $cards;
    public $hand;
    public $deck;

    public function __construct($input)
    {
        $parts = explode(' ', $input);

        //sanity check: I expect to have 10 parts
        if (count($parts) != 10) {
            return false;
        }

        $this->hand = new \PPP\FiveCards\Hand();
        $this->deck = new \PPP\FiveCards\Deck();

        $i = 0;
        foreach ($parts as $part) {
            $card = new \PPP\FiveCards\Card($part);
            $this->cards[] = $card;
            $i++;
            if ($i <= 5) {
                $this->hand->addCard($card);
            } else {
                $this->deck->addCard($card);
            }
        }
    }

    public function bestHand()
    {
        $result = array(
            Game::STRAIGHT_FLUSH => 'straight-flush',
            Game::FOUR_OF_A_KIND => 'four-of-a-kind',
            Game::FULL_HOUSE => 'full-house',
            Game::FLUSH => 'flush',
            Game::STRAIGHT => 'straight',
            Game::THREE_OF_A_KIND => 'three-of-a-kind',
            Game::TWO_PAIRS => 'two-pairs',
            Game::ONE_PAIR => 'one-pair',
            Game::HIGHEST_CARD => 'highest-card',
        );

        global $combinations;

        $bestValue = Game::HIGHEST_CARD;

        for ($i = 0; $i <= 5; $i++) {
            // take $i cards from hand and the remaining ones (5 - $i) from the deck
            foreach ($combinations[$i] as $comb) {
                $hand = new Hand();
                foreach ($comb as $id) {
                    $hand->addCard($this->cards[$id]);
                }
                for ($j = 5; $j < 10 - $i; $j++) {
                    $hand->addCard($this->cards[$j]);
                }

                $value = $hand->getRanking();
                //echo $hand->toString() . ' ';
                //echo $value . "\r\n";

                if ($value < $bestValue) {
                    $bestValue = $value;
                }

                if ($bestValue == Game::STRAIGHT_FLUSH) {
                    break 2;
                }
            }
        }
        $str = 'Hand: ' . $this->hand->toString() . ' Deck: ' . $this->deck->toString() . ' Best hand: ' . $result[$bestValue];
        return $str;
    }
}
