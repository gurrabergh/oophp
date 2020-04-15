<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Inint the game and redirect to play game
 */
$app->router->get("guess/init", function () use ($app) {
    // init session for game start

    $_SESSION["guess"] = new GB\Guess\Guess();

    return $app->response->redirect("guess/play");
});

/**
* play game - game status
*/

$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["guess"];
    $res = $_SESSION["res"] ?? null;
    $tries = $game->tries();
    $_SESSION["res"] = null;
    $number = $_SESSION["number"] ?? null;
    $_SESSION["number"] = null;

    $data = [
        "guess" => $guess ?? null,
        "number" => $number ?? null,
        "res" => $res,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
        "tries" => $tries,
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * play game
 */

$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";
    $game = $_SESSION["guess"];

    // Incoming variables
    $guess = $_POST["guess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $res = null;
    $tries = $game->tries();

    if ($doGuess) {
        try {
            $res = $game->makeGuess($guess);
            $_SESSION["res"] = $res;
        } catch (GB\Guess\GuessException $e) {
            $res = "The guessed number is out of bounds!";
            $_SESSION["res"] = $res;
        }
    }
    //
    if ($doCheat) {
        $_SESSION["number"] = $game->number();
    }
    //
    if ($doInit) {
        return $app->response->redirect("guess/init");
    }

    return $app->response->redirect("guess/play");
});
