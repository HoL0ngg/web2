    <?php
    require_once('Model/TKModel.php');
    require_once('view/chucnangAccount.php');
    require_once('Model/NhomQuyenModel.php');
    header('Content-Type: apllication/json');
    class TKController
    {
        private $tkmodel;
        public function __construct()
        {
            $this->tkmodel = new TKModel();
        }

        public function addForm()
        {
            $addUserForm = new AccountFunction();
            $roleModel = new NhomQuyenModel();
            $roles = $roleModel->getNhomQuyen();
            $addUserForm->accountForm("THÊM TÀI KHOẢN", "addUserForm", $roles);
        }

        public function updateForm($id)
        {
            $addUserForm = new AccountFunction();
            $user = $this->tkmodel->getUserById($id);
            $roleModel = new NhomQuyenModel();
            $roles = $roleModel->getNhomQuyen();
            $addUserForm->accountForm("CẬP NHẬT TÀI KHOẢN", "updateUserForm", $roles, $user);
        }

        public function userList()
        {
            $users = $this->tkmodel->getAllUsers();
            $roleModel = new NhomQuyenModel();
            $roles = $roleModel->getNhomQuyen();
            include('view/UserList.php');
        }

        // public function addUser()
        // {
        //     $response = ["success" => false, "message" => ""];

        //     if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        //         $response["message"] = "Phương thức không hợp lệ";
        //         echo json_encode($response);
        //         return;
        //     }

        //     $username = $_POST['username'] ?? '';
        //     $fullname = $_POST['fullname'] ?? '';
        //     $phone = $_POST['phone'] ?? '';
        //     $email = $_POST['email'] ?? '';
        //     $password = $_POST['password'] ?? '';
        //     $status = $_POST['status'] ?? '';
        //     $role = $_POST['role'] ?? '';

        //     if (empty($username) || empty($fullname) || empty($phone) || empty($email) || empty($password)) {
        //         $response["message"] = "Vui lòng nhập đầy đủ thông tin";
        //         echo json_encode($response);
        //         return;
        //     }

        //     $result = $this->tkmodel->them($username, $fullname, $phone, $email, $password, $status, $role);

        //     switch ($result) {
        //         case 'success':
        //             $response = ["success" => true, "message" => "Thêm tài khoản thành công"];
        //             break;
        //         case 'username_exists':
        //             $response["message"] = "Tên đăng nhập đã tồn tại";
        //             break;
        //         case 'email_exists':
        //             $response["message"] = "Email đã tồn tại";
        //             break;
        //         case 'phone_exists':
        //             $response["message"] = "Số điện thoại đã tồn tại";
        //             break;
        //         case 'insert_failed':
        //             $response["message"] = "Lỗi khi tạo tài khoản";
        //             break;
        //         case 'exception':
        //             $response["message"] = "Có lỗi xảy ra";
        //             break;
        //         default:
        //             $response["message"] = "Lỗi không xác định";
        //             break;
        //     }

        //     echo json_encode($response);
        // }

        public function updateUser() {}
    }

    ?>