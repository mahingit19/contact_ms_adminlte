<?php

$app_url = "http://localhost/adminlte_practice01"; // URL of the application

$conn = mysqli_connect("localhost", "root","","contact_management_system");
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}