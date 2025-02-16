<?php
// Database configuration
$db_host = 'sql207.infinityfree.com';
$db_user = 'if0_38325152';
$db_pass = 'Red6hat6002';
$db_name = 'if0_38325152_business_hub'; // Updated database name

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $business_info = $conn->real_escape_string($_POST['business-idea']);

    // Prepare SQL statement
    $sql = "INSERT INTO business_submissions (name, email, phone, business_info) VALUES (?, ?, ?, ?)";
    
    // Create prepared statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $name, $email, $phone, $business_info);

        // Execute statement and handle response
        if ($stmt->execute()) {
            echo "<script>
                    alert('Thank you for submitting your business proposal! Our team will review and contact you soon.');
                    window.location.href = 'index.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: Submission failed. Please try again.');
                    window.location.href = 'index.html';
                  </script>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<script>
                alert('Error: Unable to process your submission.');
                window.location.href = 'index.html';
              </script>";
    }

    // Close connection
    $conn->close();
}
?>