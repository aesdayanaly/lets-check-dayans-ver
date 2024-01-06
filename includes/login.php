<?php

if(isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $score = 0;

    include "./database.php";
    include "./entry.php";
    include "./loginform.php";
    include "./ingame.php";

    $login = new Loginform($username, $score, $password);

    $login->verifyPlayer();

    $ingame = new Ingame();

    $ingame->getPlayer($username);

    header("location: ../home.php?error=none");
}