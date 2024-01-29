<?php
function initializeDoubleElimination($teams) {
    sort($teams);
    
    $winnersBracket = $teams;
    $losersBracket = [];
    return array($winnersBracket, $losersBracket);
}

function determineMatchups($bracket) {
    $matchups = [];
    for ($i = 0; $i < count($bracket); $i += 2) {
        if (isset($bracket[$i + 1])) {
            $matchups[] = [$bracket[$i], $bracket[$i + 1]];
        } else {
            // Handle 'bye' situation
            $matchups[] = [$bracket[$i], null];
        }
    }
    return $matchups;

}

function printBrackets($winnersBracket, $losersBracket, $round) {
    echo "<br> Round " . $round . " - Current State of the Tournament: <br>";

    echo "Winners Bracket: <br>";
    foreach ($winnersBracket as $team) {
        echo "  " . $team . " <br>";
    }

    echo "\nLosers Bracket: <br>";
    foreach ($losersBracket as $team) {
        echo "  " . $team . " <br>";
    }

    echo "\n";
}


function progressTournament($winnersBracket, $losersBracket) {
    // Determine matchups for the current round in both brackets
    $winnersMatchups = determineMatchups($winnersBracket);
    $losersMatchups = determineMatchups($losersBracket);

    $newWinnersBracket = [];
    $newLosersBracket = [];

    // Process winners bracket matchups
    foreach ($winnersMatchups as $match) {
        // If there's a 'bye', the single team automatically advances
        if ($match[1] === null) {
            $newWinnersBracket[] = $match[0];
            continue;
        }

        // Randomly select winner and loser
        $randomIndex = rand(0, 1);
        $winner = $match[$randomIndex];
        $loser = $match[1 - $randomIndex];

        echo '<br> Match: ' . $match[0] . ' vs ' . $match[1];
        echo '<br> Winner: ' . $winner . '<br> Loser: ' . $loser;

        $newWinnersBracket[] = $winner;
        $newLosersBracket[] = $loser; // Loser goes to losers bracket
    }

    // Process losers bracket matchups
    foreach ($losersMatchups as $match) {
        if ($match[1] !== null) {
            // Randomly select winner
            $randomIndex = rand(0, 1);
            $winner = $match[$randomIndex];

            echo '<br> Losers Bracket Match: ' . $match[0] . ' vs ' . $match[1];
            echo '<br> Winner: ' . $winner;

            $newLosersBracket[] = $winner; // Winner advances in losers bracket
        }
    }

    return array($newWinnersBracket, $newLosersBracket);
}


$teams = ["Team A", "Team B", "Team C", "Team D", "Team E", "Team F", "Team G", "Team H", "Team I"];
list($winnersBracket, $losersBracket) = initializeDoubleElimination($teams);

$round = 1;
while (count($winnersBracket) > 1 || count($losersBracket) > 1) {
    list($winnersBracket, $losersBracket) = progressTournament($winnersBracket, $losersBracket);

    // Print the current state of the brackets
    printBrackets($winnersBracket, $losersBracket, $round);
    $round++;
}

$champion = $winnersBracket[0]; // The last team in winners bracket is the champion
echo "Champion: " . $champion . "\n";




?>
