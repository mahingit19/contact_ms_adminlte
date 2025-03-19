<?php

// app config file
require_once("config.php");

session_start();

// Get the protocol (HTTP or HTTPS)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Get the host (domain name)
$host = $_SERVER['HTTP_HOST'];

// Get the request URI (path and query string)
$requestUri = $_SERVER['REQUEST_URI'];

// Combine them to form the full URL
$fullUrl = $protocol . $host . $requestUri;

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

function response($status, $message, $data = []) {
    header('Content-Type: application/json');
    $response = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );

    echo json_encode($response);
    exit;
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
            response("success", APP_URI . "/");
            exit;
        } else {
            response("error","Invalid email or password");
        }
    } else {
        response("error","Invalid email or password");
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
    response("success", "contact found", $data);
}

function getContact($id) {

    global $conn;

    $sql = "SELECT * FROM contacts WHERE id = $id";
    $result = $conn->query($sql);
    $contact = $result->fetch_assoc();
    
    response("success","", $contact);
}

function genderCount($genderName)
{
    global $conn;

    $sql = "SELECT * FROM contacts WHERE gender='$genderName'";
    $result = $conn->query($sql);
    $genderCount = $result->num_rows;

    return $genderCount;
}

function normalizePhoneNumber($phoneNumber) {
    // Trim any whitespace around the input
    $phoneNumber = trim($phoneNumber);

    // If the number starts with "+880"
    if (strpos($phoneNumber, "+880") === 0) {
        return "880" . substr($phoneNumber, 4); // Remove "+" and store as "880"
    }
    
    // If the number starts with "880"
    if (strpos($phoneNumber, "880") === 0) {
        return $phoneNumber; // Already in correct format
    }
    
    // If the number starts with "0"
    if (strpos($phoneNumber, "0") === 0) {
        return "88" . $phoneNumber; // Add "88" in front of "0"
    }
    
    // If the number is 10 digits (local format)
    if (preg_match('/^\d{10}$/', $phoneNumber)) {
        return "880" . $phoneNumber; // Add "880" at the beginning
    }
    
    // If it doesn't match any case, return false (invalid number)
    return false;
}

if (isset($_POST["phone"])) {
    $phoneNumber = $conn->real_escape_string($_POST['phone']);
    $phone = normalizePhoneNumber($phoneNumber);
}

function addContact()
{
    global $conn;
    global $phone;

    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $country = $conn->real_escape_string($_POST['country']);

    $sql = "SELECT * FROM contacts WHERE phone = '$phone'";
    $result = $conn->query($sql);
    $contact_num = $result->num_rows;
    if ($contact_num > 0) {
        response("error","Contact with phone number $phone already exists");
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

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            response("error","JPG, JPEG, PNG & GIF files are allowed.");
            exit;
        }


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
        response("success","New record created successfully.");
    } else {
        response("error","Error: " . $sql . "<br>" . $conn->error);
    }

}

function editContact()
{
    global $conn;
    global $phone;

    $id = $_POST['id'];
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $country = $conn->real_escape_string($_POST['country']);

    $sql = "SELECT photo FROM contacts WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $oldPhoto = $row['photo'];

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

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            response("error","JPG, JPEG, PNG & GIF files are allowed.");
            exit;
        }

        if (!empty($_FILES['fileToUpload']['name'])) {
            unlink($oldPhoto);
        }

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
                WHERE id=$id AND NOT EXISTS (
    SELECT 1 FROM contacts WHERE phone = '$phone' AND id != $id
)";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_affected_rows($conn) == 0) {
            response("error","Contact with phone number $phone already exists");
            exit;
        }
        response("success","Record updated successfully for id: $id");
    } else {
        response("error","Error updating record: " . mysqli_error($conn));
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
            response("success","Record deleted successfully for id: $id");
        } else {
            response("error","Error deleting record: ". mysqli_error($conn));
        }
    }
}

function logout() 
{
    session_destroy();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'addContact':
            addContact();
            break;

        case 'readContacts':
            readContacts();
            break;

        case 'getContact':
            getContact($_POST['id']);
            break;

        case 'editContact':
            editContact();
            break;

        case 'deleteContact':
            deleteContact();
            break;

        case 'logout':
            logout();
            break;

        default:
            // Handle invalid actions
            response('error','Invalid action');
            break;
    }
    exit;
}
