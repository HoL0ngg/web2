    <?php
    class PhanQuyenController
    {
        public function __construct()
        {
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['action'])) {
                if ($_GET['action'] == 'addRole') {
                    $this->addRole();
                }
                if ($_GET['action'] == 'addChucNang') {
                    $this->addChucNang();
                }
            }
        }

        public function roleList()
        {
            require_once('Model/NhomQuyenModel.php');
            require_once('Model/PhanQuyenModel.php');
            $nhomQuyenModel = new NhomQuyenModel();
            $nhomQuyen = $nhomQuyenModel->getNhomQuyen();
            $phanquyenModel = new PhanQuyenModel();
            $chucNang = $phanquyenModel->getDanhMucChucNang();
            $role_id = $_GET['role_id'] ?? 1;
            $chiTietQuyen = $phanquyenModel->getChiTietNhomQuyen($role_id);
            $quyenMap = [];
            foreach ($chiTietQuyen as $quyen) {
                $quyenMap[$quyen['function_id']][] = $quyen['action'];
            }

            include('view/PhanQuyenView.php');
        }
        public function addRole()
        {
            require_once('Model/NhomQuyenModel.php');
            $data = json_decode(file_get_contents('php://input'), true);
            $rolename = $data['role_name'] ?? '';
            if (empty($rolename)) {
                echo json_encode(['success' => false, 'message' => 'Tên nhóm quyền không được để trống.']);
                return;
            }
            $nhomQuyenModel = new NhomQuyenModel();
            $result = $nhomQuyenModel->themNhomQuyen($rolename);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Thêm nhóm quyền thành công.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Thêm nhóm quyền thất bại.']);
            }
        }

        public function addChucNang()
        {
            require_once('Model/PhanQuyenModel.php');
            $data = json_decode(file_get_contents('php://input'), true);
            $function_id = $data['function_id'];
            $function_name = $data['function_name'];

            if (empty($function_id) || empty($function_name)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin!']);
                return;
            }

            $phanquyenModel = new PhanQuyenModel();
            $result = $phanquyenModel->themChucNang($function_id, $function_name);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Thêm chức năng thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Thêm chức năng thất bại']);
            }
        }
    }
    ?>