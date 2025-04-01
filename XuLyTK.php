<?php
require_once("TKModel.php");
if (isset($_POST["them"])) {
    $username = $_POST['username'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $status = $_POST['status'] ?? '';
    $role = $_POST['role'] ?? '';

    $user = new TKModel();
    $user->them($username, $phone, $email, $password, $status, $role);
    if ($user == true) {
        header("Location: admin.php?page=user&act=add");
    }
}
