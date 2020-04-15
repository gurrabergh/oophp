<h1>Guess my number!</h1>
<p>Guess a number between 1 and 100. You have <?= $game->tries() ?> tries left.</p>

<form method="post">
    <input type="text" name="guess">
    <?php if (!($res == "Correct! Well done." or $game->tries() <= 0)) : ?>
    <input type="submit" name="doGuess" value="Guess">
    <input type="submit" name="doCheat" value="Cheat">
    <?php endif; ?>
    <input type="submit" name="doInit" value="Restart Game">
</form>

<?php if ($res) : ?>
    <p><?= $res ?></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>Cheat: The current number is: <?= $number ?></p>
<?php endif; ?>
