<?php
require_once("../connect.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = $_POST['status'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, phone, email, password, status, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $username, $phone, $email, $password, $status, $role);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Thêm tài khoản thành công!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Thêm tài khoản thất bại!"]);
    }
    $stmt->close();
    $conn->close();
}
