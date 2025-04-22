    <?php
    require_once(__DIR__ . '/../Model/AdminModel.php');

    class AdminController
    {
        private $model;

        public function __construct()
        {
            $this->model = new AdminModel();
        }

        public function submitLogin()
        {
            session_start(); // Đảm bảo có session
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $admin = $this->model->checkLogin($username, $password);
            if ($admin) {
                $_SESSION['admin'] = $admin['username'];
                // header('Location: /admin.php');
                header('Location: /admin.php');
                exit;
            } else {
                header('Location: login.php');
                echo "<script>alert('Sai tài khoản hoặc mật khẩu'); window.location.href='/admin/login';</script>";
                exit;
            }
        }

        public function logout()
        {
            session_start();
            unset($_SESSION['admin']);
            session_destroy();
            header('Location: login.php');
            exit;
        }
        public function showLoginForm()
        {
            require_once(__DIR__ . '/../view/admin/login.php');
        }

        public function changepass()
        {
            echo "In changepass";
            return $this->model->changePass();
        }
    }
    ?>