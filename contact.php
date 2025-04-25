<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    if (isset($_POST["name"], $_POST["email"], $_POST["message"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "phps"; 
        

        $conn = new mysqli($servername, $username, $password, $database);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $stmt = $conn->prepare("INSERT INTO cantact (name, email, message) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "Thank you! Your message has been received.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Missing form data!";
    }
} else {
    echo "Invalid request.";
}
?>
