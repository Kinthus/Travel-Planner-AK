<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($email) && !empty($password)) {
        
        $conn = new mysqli("localhost", "root", "", "phps");

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $sql = "SELECT * FROM signup WHERE username = ? AND email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();

        $result = $stmt->get_result();

        
        if ($result->num_rows > 0) {
            echo "Login successful. Welcome, " . htmlspecialchars($username) . "!";
        } else {
            echo "❌ Invalid login credentials.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "⚠️ All fields are required.";
    }
} else {
    echo "Please submit the form.";
}
?>
