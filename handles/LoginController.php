    <?php
    session_start();
    require_once(__DIR__ . '/../Model/LoginModel.php');

    class LoginController
    {
        private $loginModel;

        public function __construct()
        {
            $this->loginModel = new LoginModel();
        }

        public function login()
        {
            $response = ["success" => false, "message" => ""];

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $username = trim($_POST["username"] ?? '');
                $password = $_POST["password"] ?? '';

                if (empty($username) || empty($password)) {
                    $response["message"] = "Vui lòng nhập đầy đủ thông tin đăng nhập.";
                    echo json_encode($response);
                    exit();
                }

                $user = $this->loginModel->getUserByUsername($username);
                // echo json_encode($user);
                // exit();
                if ($user) {
                    if ($user['status'] == 0) {
                        $response['message'] = "Tài khoản của bạn đã bị khóa!";
                        echo json_encode($response);
                        exit();
                    }
                    if ($password == $user['password']) {
                        $_SESSION['username'] = $username;
                        $response['success'] = true;
                        $response['message'] = "Đăng nhập thành công";
                    } else {
                        $response['message'] = "Tài khoản hoặc mật khẩu không đúng!";
                    }
                } else {
                    $response["message"] = "Tài khoản không tồn tại!";
                }
                echo json_encode($response);
            }
        }
    }
    $loginController = new LoginController();
    $loginController->login();
    ?>
    