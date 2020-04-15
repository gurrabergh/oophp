<?php

require __DIR__ . '/autoload.php';
require __DIR__ . '/config.php';

$guess = $_POST["guess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;
$res = null;

if ($doGuess) {
    try {
        $res = $game->makeGuess($guess);
    } catch (GuessException $e) {
        $res = "The guessed number is out of bounds!";
    }
}

if ($doCheat) {
    $number = $game->number();
}

if ($doInit) {
    header('Location: session_destroy.php');
}
require __DIR__ . '/view/template.php';
