<?php
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

// Example usage
$rawPhoneNumber = "01712345678"; // Change this to test other cases
$normalizedNumber = normalizePhoneNumber($rawPhoneNumber);

if ($normalizedNumber !== false) {
    // Store the normalized number in MySQL
    $mysqli = new mysqli("localhost", "root", "", "");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $mysqli->prepare("INSERT INTO phone_numbers (phone_number) VALUES (?)");
    $stmt->bind_param("s", $normalizedNumber);

    if ($stmt->execute()) {
        echo "Phone number stored successfully: " . $normalizedNumber;
    } else {
        echo "Error storing phone number: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "Invalid phone number format. Please check the input.";
}
?>
