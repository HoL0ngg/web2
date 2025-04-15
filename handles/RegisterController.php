    <?php
    require_once(__DIR__ . '/../Model/TKModel.php');
    class RegisterController
    {
        private $model;

        public function __construct()
        {
            $this->model = new TKModel();
        }

        public function register()
        {
            header('Content-Type: application/json');
            $response = ["success" => false, "message" => ""];

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $username = trim($_POST["reg-username"] ?? '');
                $phone = trim($_POST['reg-phone'] ?? '');
                $password = $_POST['reg-password'] ?? '';
                $repassword = $_POST['reg-repassword'] ?? '';

                $tinh = $_POST['thanhpho'] ?? '';
                $quan = $_POST['quan'] ?? '';
                $phuong = $_POST['phuong'] ?? '';
                $sonha = trim($_POST['diachi'] ?? '');
                // Mã hóa mật khẩu
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                // Kiểm tra username hoặc phone đã tồn tại
                if ($this->model->isUsernameExists($username)) {
                    $response["message"] = "Tên đăng nhập đã tồn tại.";
                    echo json_encode($response);
                    return;
                }

                if ($this->model->isPhoneExists($phone)) {
                    $response["message"] = "Số điện thoại đã được sử dụng.";
                    echo json_encode($response);
                    return;
                }


                $user_id = $this->model->insertUser($username, $hashedPassword);

                $customer_id = $this->model->insertKhachHang($user_id, $phone);

                $address_id = $this->model->insertDiaChi($tinh, $quan, $phuong, $sonha);

                $this->model->insertKhachHangDiaChi($customer_id, $address_id, true);

                $response["success"] = true;
                $response["message"] = "Đăng ký thành công!";
            } else {
                $response["message"] = "Đã xảy ra lỗi trong quá trình đăng ký.";
            }
            echo json_encode($response);
        }
    }
    $registerController = new RegisterController();
    $registerController->register();
    ?>