<?php
require __DIR__ . '/vendor/autoload.php';

use PPP\FiveCards\Game;

class FiveCards
{
    public static function execute()
    {
        // we generate all the combinations once and for all at script startup
        // so we can reuse them
        global $combinations;

        $data = array(0, 1, 2, 3, 4);

        $result = array(array());

        foreach ($data as $arr) {
            $new_result = array();
            foreach ($result as $old_element) {
                $new_result[] = array_merge($old_element, (array) $arr);
                $new_result[] = array_merge($old_element, (array) 'null');
            }
            $result = $new_result;
        }

        foreach ($result as $arr) {
            //    removing null values
            $arr = array_diff($arr, array('null'));
            //    adding each array of items to the list of arrays of same length
            $combinations[count($arr)][] = $arr;
        }

        // get contents of a file into a string
        $fileName = 'games.txt';
        $handle = fopen($fileName, "r");

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                //  read until reaching an empty line
                if ($line != '') {
                    $game = new Game($line);
                    //  assuming input is valid, otherwise php doesnt care anyway
                    printf($game->bestHand() . "\r\n");
                    unset($game);
                }
            }
        } else {
            printf("Error loading file.\r\n");
            exit;
        }
        fclose($handle);
    }
}

FiveCards::execute();
