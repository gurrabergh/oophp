<!doctype html>

<h1>Dice game 100</h1>

<p>Your score is: <?= $playerScore ?></p>
<p>Computer's score is: <?= $cpuScore ?></p>
<hr>
<?php if ($lastRoll) : ?>
<p>The dice roll: <?= $lastRoll ?>, the pot is <?= $pot ?></p>
<?php elseif ($cpuMessage) : ?>
    <p><?= $cpuMessage ?></p>
<?php endif; ?>
<form method="post">
    <?php if (!($playerScore >= 100 or $cpuScore >= 100)) : ?>
        <?php if ($turn == "player") : ?>
        <p>It's your turn.</p>
    <input type="submit" name="roll" value="Roll dices">
        <?php endif; ?>
        <?php if ($turn == "cpu") : ?>
        <p>It's the CPU's turn.</p>
    <input type="submit" name="roll" value="Roll dices for CPU">
        <?php endif; ?>
        <?php if ($lastRoll and $pot > 0) : ?>
    <input type="submit" name="saveSum" value="Save sum">
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($cpuScore >= 100) : ?>
        <p>The computer won!</p>
    <?php elseif ($playerScore >= 100) : ?>
        <p>You won!</p>
    <?php endif; ?>
    <input type="submit" name="doInit" value="Restart Game">
</form>
