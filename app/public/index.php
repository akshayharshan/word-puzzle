<?php

include 'DbConnect.php';
include 'Game.php';


$game = new Game();
// $game->CheckWord("hello");

if (isset($_POST['text']) && !empty($_POST['text'])) {
    $game->processInput($_POST['text']);
    unset($_POST['text']);
}

if (isset($_POST['end'])) {
    $game->endGame();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h3>Letters Left : <?php echo isset($_SESSION['letters']) ? $_SESSION['letters'] : ''; ?></h3>
    <h3>Your Score : <?php echo isset($_SESSION['score']) ? $_SESSION['score'] : 0; ?></h3>
    <form method="post">
        <div>
            Enter a word: <input type="text" name="text">
            <input type="submit" value="Submit">
        </div>
    </form>

    <form method="post">
        <div style="margin-top:20px">
            <button name='end' value="TRUE">End Game</button>
        </div>
    </form>

    <p><b><a href="/GetScore.php" >Click Here To See The Top Scores</a></b></p>

</body>

</html>