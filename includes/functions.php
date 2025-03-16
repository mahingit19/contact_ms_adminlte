<?php

// app config file
require_once("config.php");

session_start();

// Redirect to login page if not logged in
switch ($_SERVER['REQUEST_URI']) {
    case "/adminlte_practice01/login.php":
        if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
            header("Location: " . APP_URI . "/");
            exit;
        }
        break;
    default:
        if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
            header("Location: " . APP_URI . "/login.php");
            exit;
        }
        break;
}

// Connect to the database
function db_connect()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

$conn = db_connect();

function login($email, $password)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
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

function readContacts()
{
    global $conn;

    $sql = "SELECT * FROM contacts";
    $result = $conn->query($sql);
    $contact_num = $result->num_rows;

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode($data);
}

function maleCount()
{
    global $conn;

    $sql = "SELECT * FROM contacts WHERE gender='male'";
    $result = $conn->query($sql);
    $maleCount = $result->num_rows;
    echo $maleCount;
}

function femaleCount()
{
    global $conn;

    $sql = "SELECT * FROM contacts WHERE gender='female'";
    $result = $conn->query($sql);
    $femaleCount = $result->num_rows;
    echo $femaleCount;
}

function addContact()
{
    global $conn;

    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $country = $conn->real_escape_string($_POST['country']);

    $sql = "SELECT * FROM contacts WHERE phone = '$phone'";
    $result = $conn->query($sql);
    $contact_num = $result->num_rows;
    if ($contact_num > 0) {
        echo "Contact with phone number +880$phone already exists";
        exit;
    }

    if (isset($_FILES['fileToUpload'])) {
        $image = $_FILES['fileToUpload'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageError = $image['error'];

        // Define the upload directory
        $uploadDirectory = "uploads/";

        // Generate a unique filename to prevent overwriting
        $target_file = $uploadDirectory . basename($imageName);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uniqueFileName = $phone;
        $uploadPath = $uploadDirectory . $uniqueFileName . "." . $imageFileType;


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
    $sql = "INSERT INTO contacts (first_name, last_name, email, gender, phone, address, city, state, zip, country, photo)
            VALUES ('$firstName', '$lastName', '$email', '$gender', '$phone', '$address', '$city', '$state', '$zip', '$country', '$uploadPath')";

    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function deleteContact()
{
    global $conn;

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

function editContact()
{
    global $conn;

    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];

    $sql = "SELECT photo FROM contacts WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $oldPhoto = $row['photo'];
    if (!empty($_FILES['fileToUpload']['name'])) {
        unlink($oldPhoto);
    }

    if (isset($_FILES['fileToUpload'])) {

        $image = $_FILES['fileToUpload'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageError = $image['error'];

        // Define the upload directory
        $uploadDirectory = "uploads/";

        // Generate a unique filename to prevent overwriting
        $target_file = $uploadDirectory . basename($imageName);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uniqueFileName = $phone;
        $uploadPath = $uploadDirectory . $uniqueFileName . "." . $imageFileType;

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
        $uploadPath = $oldPhoto;
    }

    // Update query
    $sql = "UPDATE contacts SET 
                    first_name='$firstName', last_name='$lastName', gender='$gender', email='$email', phone='$phone',
                    address='$address', city='$city', state='$state', zip='$zip', country='$country', photo='$uploadPath'
                WHERE id=$id";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Record updated successfully for id: $id";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

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
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'addContact':
            addContact();
            break;

        case 'readContacts':
            header('Content-Type: application/json');
            readContacts();
            break;

        case 'editContact':
            editContact();
            break;

        case 'deleteContact':
            deleteContact();
            break;

        default:
            // Handle invalid actions
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
    exit;
}
