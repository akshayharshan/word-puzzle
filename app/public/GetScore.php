<?php

include 'DbConnect.php';
include 'Game.php';
$game = new Game();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .table {
        margin: 20px;
    }
</style>
    <title>Document</title>
</head>
<body>
<div class="table">
        <h2>TOP SCORES</h2>
        <table>
            <tr>
                <th>Rank</th>
                <th>Score</th>
                <th>Words</th>
            </tr>
            <?php
            $game->getData();
            ?>
        </table>
    </div>
   <a href="../index.php">Return</a>
    
</body>
</html>

