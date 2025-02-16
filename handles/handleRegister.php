    <?php
    session_start();
    header('Content-Type: application/json');
    include(__DIR__ . '/../database/connect.php');

    $response = ["success" => false, "message" => ""];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $phone = trim($_POST["reg-phone"]);
        $username = trim($_POST["reg-username"]);
        $password = $_POST["reg-password"]; // No trimming here to prevent character loss
        // var_dump($password);
        if (!empty($phone)) {
            $sql_phonenum = "SELECT * FROM user_table WHERE phone = ?";
            $stmt_check = $conn->prepare($sql_phonenum);
            $stmt_check->bind_param("s", $phone);
            $stmt_check->execute();
            $result = $stmt_check->get_result();
            if (mysqli_num_rows($result) > 0) {
                $response["message"] = "Số điện thoại đã được sử dụng";
                echo json_encode($response);
                exit();
            }
            $stmt_check->close();
        }
        if (!empty($username) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Using Prepared Statements to prevent SQL Injection
            $sql = "INSERT INTO `user_table` (`phone`, `username`, `password`) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sss", $phone, $username, $hashed_password);
                if ($stmt->execute()) {
                    // echo "Lưu dữ liệu thành công";
                    $response["success"] = true;
                    $response["message"] = "Đăng ký thành công";
                } else {
                    echo "Lỗi: " . $stmt->error;
                }
            } else {
                echo "Lỗi chuẩn bị câu lệnh SQL";
            }
        }
        $stmt->close();
        echo json_encode($response);
        exit();
    }
    ?>
