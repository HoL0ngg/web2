<?php
require_once(__DIR__ . '/../../handles/AdminController.php');

$adminController = new AdminController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminController->submitLogin();
} else {
    $adminController->showLoginForm();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #admin-login {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        #input-field-wrapper {
            display: flex;
            flex-direction: column;
        }

        #input-field-wrapper input {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #input-field-wrapper button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #input-field-wrapper button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div id="admin-login">
        <h2>Đăng nhập quản trị viên</h2>
        <form method="POST" action="">
            <div id="input-field-wrapper">
                <input type="text" name="username" placeholder="Tên đăng nhập" required><br>
                <input type="password" name="password" placeholder="Mật khẩu" required><br>
                <button type="submit">Đăng nhập</button>
            </div>
        </form>
    </div>
</body>

</html>