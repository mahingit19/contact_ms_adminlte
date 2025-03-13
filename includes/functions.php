<?php

if (isset($_POST['email']) && isset($_POST['password'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        exit;
    }
    // Send JSON response
    header('Content-Type: application/json');
    $email = $_POST["email"];
    $password = $_POST["password"];
    login($email, $password);
}

function login($email, $password)
{
    require("config.php");

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            $_SESSION["username"] = $row["username"];
            echo json_encode(['status' => 'success']);
        } else {

            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        }
        exit;
    } else {

        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['action']) && $_GET['action'] === 'readContacts') {
    header('Content-Type: application/json');
    readContacts();
}

function readContacts()
{
    require("config.php");
    $sql = "SELECT * FROM contacts";
    $result = mysqli_query($conn, $sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action']) && $_POST['action'] === 'addContact') {
    addContact();
}

function addContact()
{
    require('config.php');

    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $country = $conn->real_escape_string($_POST['country']);

    if (isset($_FILES['fileToUpload'])) {
        $image = $_FILES['fileToUpload'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageError = $image['error'];

        // Define the upload directory
        $uploadDirectory = "uploads/";

        // Generate a unique filename to prevent overwriting
        $uniqueFileName = uniqid('', true) . "_" . basename($imageName);
        $uploadPath = $uploadDirectory . $uniqueFileName;

        // Check for upload errors
        if ($imageError === 0) {
            // Create the uploads directory if it doesn't exist
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Move the file to the upload directory
            move_uploaded_file($imageTmpName, $uploadPath);
        }
    } else {
        $uploadPath = "";
    }


    // SQL insert query
    $sql = "INSERT INTO contacts (first_name, last_name, email, phone, address, city, state, zip, country, photo)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$address', '$city', '$state', '$zip', '$country', '$uploadPath')";

    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'deleteContact') {
    deleteContact();
}

function deleteContact()
{
    require("config.php");
    if (isset($_POST["id"])) {
        $id = $_POST["id"];

        $sql = "SELECT photo FROM contacts WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $photoPath = $row["photo"];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $sql = "DELETE FROM contacts WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "ID: $id deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === 'editContact') {
    editContact();
}

function editContact()
{
    require('config.php');
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];

    if (isset($_FILES['fileToUpload'])) {

        if (!empty($_FILES['fileToUpload']['name'])) {
            $sql = "SELECT photo FROM contacts WHERE id=$id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $oldPhoto = $row['photo'];
                if ($oldPhoto) {
                    unlink($oldPhoto);
                }
            }
        }

        $image = $_FILES['fileToUpload'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageError = $image['error'];

        // Define the upload directory
        $uploadDirectory = "uploads/";

        // Generate a unique filename to prevent overwriting
        $uniqueFileName = uniqid('', true) . "_" . basename($imageName);
        $uploadPath = $uploadDirectory . $uniqueFileName;

        // Check for upload errors
        if ($imageError === 0) {
            // Create the uploads directory if it doesn't exist
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            // Move the file to the upload directory
            move_uploaded_file($imageTmpName, $uploadPath);

            $sql = "UPDATE contacts SET photo='$uploadPath' WHERE id=$id";
            $result = mysqli_query($conn, $sql);
        }
    }

    // Update query
    $sql = "UPDATE contacts SET 
                    first_name='$firstName', last_name='$lastName', email='$email', phone='$phone',
                    address='$address', city='$city', state='$state', zip='$zip', country='$country'
                WHERE id=$id";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Record updated successfully for id: $id";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
