    <?php
    require_once __DIR__ . '/../Model/TKModel.php';



    class TKController
    {
        private $tkmodel;
        public function __construct()
        {
            $this->tkmodel = new TKModel();
        }

        public function addForm()
        {
            require_once('view/chucnangAccount.php');
            require_once('Model/NhomQuyenModel.php');
            $addUserForm = new AccountFunction();
            $roleModel = new NhomQuyenModel();
            $roles = $roleModel->getNhomQuyen();
            $addUserForm->accountForm("THÊM TÀI KHOẢN", "addUserForm", $roles);
        }

        public function updateForm($id)
        {
            require_once('view/chucnangAccount.php');
            require_once('Model/NhomQuyenModel.php');
            $addUserForm = new AccountFunction();
            $user = $this->tkmodel->getUserById($id);
            $roleModel = new NhomQuyenModel();
            $roles = $roleModel->getNhomQuyen();
            $addUserForm->accountForm("CẬP NHẬT TÀI KHOẢN", "updateUserForm", $roles, $user);
        }

        public function userList()
        {
            require_once('Model/NhomQuyenModel.php');
            $users = $this->tkmodel->getAllUsers();
            $roleModel = new NhomQuyenModel();
            $roles = $roleModel->getNhomQuyen();
            include('view/UserList.php');
        }

        public function addUser()
        {
            header('Content-Type: application/json');
            $response = ["success" => false, "message" => "", "redirect"];

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                $response["message"] = "Phương thức không hợp lệ";
                echo json_encode($response);
                return;
            }

            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $status = $_POST['status'] ?? '1';
            $role = $_POST['role'] ?? '1';

            if (empty($username) || empty($fullname) || empty($phone) || empty($email) || empty($password)) {
                $response["message"] = "Vui lòng nhập đầy đủ thông tin";
                echo json_encode($response);
                return;
            }

            $result = $this->tkmodel->them($username, $fullname, $phone, $email, $password, $status, $role);

            switch ($result) {
                case 'success':
                    $response = ["success" => true, "message" => "Thêm tài khoản thành công", "redirect" => "admin.php?page=user"];
                    break;
                case 'username_exists':
                    $response["message"] = "Tên đăng nhập đã tồn tại";
                    break;
                case 'email_exists':
                    $response["message"] = "Email đã tồn tại";
                    break;
                case 'phone_exists':
                    $response["message"] = "Số điện thoại đã tồn tại";
                    break;
                case 'insert_failed':
                    $response["message"] = "Lỗi khi tạo tài khoản";
                    break;
                case 'exception':
                    $response["message"] = "Có lỗi xảy ra";
                    break;
                default:
                    $response["message"] = "Lỗi không xác định";
                    break;
            }

            echo json_encode($response);
        }

        public function updateUser()
        {
            header('Content-Type: application/json');

            $response = ["success" => false, "message" => "", "redirect" => ""];
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                $response["message"] = "Phương thức không hợp lệ";
                echo json_encode($response);
                return;
            }
            $id = (int)$_POST['id'];
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $status = $_POST['status'] ?? '1';
            $role = $_POST['role'] ?? '1';

            if (empty($username) || empty($fullname) || empty($phone) || empty($email)) {
                $response["message"] = "Vui lòng nhập đầy đủ thông tin";
                echo json_encode($response);
                return;
            }
            $id = (int)$id;
            $result = $this->tkmodel->sua($id, $username, $fullname, $phone, $email, $password, $status, $role);

            switch ($result) {
                case 'success':
                    $response = ["success" => true, "message" => "Cập nhật tài khoản thành công", "redirect" => "admin.php?page=user"];
                    break;
                case 'username_exists':
                    $response["message"] = "Tên đăng nhập đã tồn tại";
                    break;
                case 'email_exists':
                    $response["message"] = "Email đã tồn tại";
                    break;
                case 'phone_exists':
                    $response["message"] = "Số điện thoại đã tồn tại";
                    break;
                case 'exception':
                    $response["message"] = "Có lỗi xảy ra";
                    break;
                default:
                    $response["message"] = "Lỗi không xác định";
                    break;
            }

            echo json_encode($response);
        }

        public function getOrderById($id)
        {
            $id = (int)$id;
            $order = $this->tkmodel->getOrderById($id);
            return $order;
        }
    }

    ?>