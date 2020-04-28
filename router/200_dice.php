<?php
/**
 * Create routes using $app programming style.
 */

/**
 * Inint the game and redirect to play game
 */
$app->router->get("dice/init", function () use ($app) {
    // init session for game start

    $_SESSION["game"] = new GB\Dice\DiceGame();

    return $app->response->redirect("dice/play");
});

/**
* play game - game status
*/

$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["game"];
    $data = [
        "hand" => $hand ?? null,
        "lastRoll" => $game->getLastRoll(),
        "playerScore" => $game->getPlayerScore(),
        "cpuScore" => $game->getCpuScore(),
        "sum" => $game->getLastRollSum ?? 0,
        "turn" => $game->getTurn(),
        "pot" => $game->getPot(),
        "cpuMessage" => $game->getCpuMessage() ?? null
    ];

    $app->page->add("dice/play", $data);


    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * play game
 */

$app->router->post("dice/play", function () use ($app) {
    $title = "Play the game";
    $roll = $_POST["roll"] ?? null;
    $saveSum = $_POST["saveSum"] ?? null;
    $doInit = $_POST["doInit"] ?? null;

    if ($roll) {
        $_SESSION["game"]->diceRoll();
    }
    //
    if ($saveSum) {
        $_SESSION["game"]->saveSum();
    }
    //
    if ($doInit) {
        return $app->response->redirect("dice/init");
    }

    return $app->response->redirect("dice/play");
});
