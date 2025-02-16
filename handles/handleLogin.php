    <?php
    session_start();
    header('Content-Type: application/json');
    include(__DIR__ . '/../database/connect.php');

    $response = ["success" => false, "message" => "", "username" => null];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST["username"] ?? '');
        $password = $_POST["password"] ?? '';
        // echo $username . " " . $password;
        if (empty($username) || empty($password)) {
            $response["message"] = "Vui lòng nhập đầy đủ thông tin đăng nhập.";
            echo json_encode($response);
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM user_table WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // echo $password . " " . $row["password"];
            echo $password == $row["password"];
            if (password_verify($password, $row["password"])) {
                $_SESSION["username"] = $username;
                $response["success"] = true;
                $response["message"] = "Đăng nhập thành công!";
                $response["username"] = $username;
            } else {
                $response["message"] = "Tài khoản hoặc mật khẩu không đúng!";
                $response["username"] = $password;
            }
        } else {
            $response["message"] = "Tài khoản không tồn tại!";
        }

        $stmt->close();
        echo json_encode($response);
        exit();
    }
    ?>
