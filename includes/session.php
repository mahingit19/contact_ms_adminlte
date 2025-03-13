<?php

session_start();
if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
    header("Location: " . APP_URI ."/login-page.php");
    exit;
}