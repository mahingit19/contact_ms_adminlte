<?php

$APP_NAME = "adminlte_practice01";
$APP_URL = $_SERVER['DOCUMENT_ROOT'] . "/$APP_NAME";

session_start();

session_unset();

session_destroy();

header("Location: /$APP_NAME/");