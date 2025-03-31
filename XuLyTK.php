<?php
require_once("TKModel.php");
if (isset($_GET["submit"])) {
    $username = $_GET['username'] ?? '';
    $phone = $_GET['phone'] ?? '';
    $email = $_GET['email'] ?? '';
    $password = $_GET['password'] ?? '';
    $status = $_GET['status'] ?? '';
    $role = $_GET['role'] ?? '';

    $user = new TKModel();
    $user->them($username, $phone, $email, $password, $status, $role);
    if ($user == true) {
        header("Location: admin.php?page=user&act=add");
    }
}
