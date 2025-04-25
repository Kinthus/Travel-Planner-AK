<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirmPassword)) {
        if ($password !== $confirmPassword) {
            echo "Passwords do not match.";
            die();
        }

        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "phps";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $SELECT = "SELECT email FROM signup WHERE email = ? LIMIT 1";
            $INSERT = "INSERT INTO signup (username, email, password) VALUES (?, ?, ?)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $stmt->close();

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sss", $username, $email, $password);
                $stmt->execute();
                echo "New record added successfully.";
            } else {
                echo "Someone has already signed up with this email.";
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Please submit the form.";
}
?>
