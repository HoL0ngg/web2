    <?php
    session_start();
    include(__DIR__ . '/../database/connect.php');

    $response = ["success" => false, "message" => ""];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $currentPass = $_POST["currentpass"];
        $newPass = $_POST["newpass"];
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
        }
        if (!empty($currentPass)) {
            $sql = "SELECT password FROM user_table WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
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
            $sql = "UPDATE user_table SET password = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashed_password, $username);

            if ($stmt->execute()) {
                session_destroy();
                $response["success"] = true;
                $response["message"] = "Đổi mật khẩu thành công!";
            }
            $stmt->close();
            echo json_encode($response);
        }
    }
    ?>