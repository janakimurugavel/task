<?php
include 'db_connection.php';
    // Retrieve form data
    $username = $_POST['username'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $dob = $_POST['dob'];
    $phoneNumber = $_POST['phoneNumber'];
    $zip = $_POST['zip'];

    // Perform any additional server-side validation or processing here

    // Insert data into the database
    $sql = "INSERT INTO user (username, lastname, email, address, city, state, dob, phoneNumber, zip) VALUES ('$username', '$lastname', '$email', '$address', '$city', '$state', '$dob', '$phoneNumber', '$zip')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>
