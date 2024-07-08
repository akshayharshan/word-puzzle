<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'Game.php';
$remainWords = NULL;
$result = $_SESSION['result'];
if (!empty($result)) {
    $game = new Game();
    $remainWords = $game->remainWords($_SESSION['result']);
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
<div>
<div>
        <h4>Remaining words:</h4>
        <p><?php echo $remainWords; ?></p>
    </div>




    <a href="../index.php">Return</a>

</body>

</html>