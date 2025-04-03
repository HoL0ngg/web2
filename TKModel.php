<?php
class TKModel
{

    public function them($username, $phone, $email, $password, $status, $role)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!empty($username) && !empty($email) && !empty($password)) {
                // Hash the password for security
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                require("connect.php");

                // Check connection
                if ($conn->connect_error) {
                    die('Connection failed: ' . $conn->connect_error);
                }

                // Prepare and bind
                $stmt = $conn->prepare("INSERT INTO user (username, phone, email, password, status, role) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssii", $username, $phone, $email, $hashedPassword, $status, $role);
                // Execute the statement
                return $stmt->execute();
                // if ($stmt->execute()) {
                //     // echo "User added successfully!";
                //     header("Location: admin.php?page=user");
                // } else {
                //     echo "Error: " . $stmt->error;
                // }

                // Close connections
                $stmt->close();
                $conn->close();
            } else {
                echo "Please fill in all required fields.";
            }
        }
    }
}
