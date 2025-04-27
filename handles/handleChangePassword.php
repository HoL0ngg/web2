    <?php
    session_start();
    include(__DIR__ . '/../database/connect.php');
    $db = new database();
    $conn = $db->getConnection();
    $response = ["success" => false, "message" => ""];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $currentPass = $_POST["currentpass"];
        $newPass = $_POST["newpass"];
        $user_id = $_SESSION["user"]['user_id'] ?? '';
    } else {
        $response["message"] = "Vui lòng đăng nhập để thực hiện chức năng này!";
        echo json_encode($response);
        exit();
    }
    if (!empty($currentPass)) {
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $row = $result->fetch_assoc();
            if (!password_verify($currentPass, $row["password"])) {
                $response["message"] = "Mật khẩu hiện tại không đúng!Vui lòng nhập lại";
                $stmt->close();
                echo json_encode($response);
                exit();
            }
        }
    }

    if (!empty($newPass) && !empty($currentPass)) {
        $hashed_password = password_hash($newPass, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id);

        if ($stmt->execute()) {
            session_destroy();
            $response["success"] = true;
            $response["message"] = "Đổi mật khẩu thành công!";
        }
        $stmt->close();
        echo json_encode($response);
        exit();
    }

    ?>