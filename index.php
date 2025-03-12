<?php

session_start();

require("config.php");

include("includes/header.php");

if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
    include("wrapper.php");
} else {
    include("login-page.php");
}

include("includes/footer.php");
