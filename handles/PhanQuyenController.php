    <?php
    class PhanQuyenController
    {
        public function __construct() {}

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
            require_once(__DIR__ . '/../Model/NhomQuyenModel.php');

            $rolename = $_POST['role_name'] ?? '';
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
            require_once(__DIR__ . '/../Model/PhanQuyenModel.php');
            $function_id = $_POST['function_id'];
            $function_name = $_POST['function_name'];

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

        public function luu()
        {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $permissions = $_POST['permissions'] ?? [];
                $role_id = $_POST['role_id'] ?? 1;
                require_once(__DIR__ . '/../Model/PhanQuyenModel.php');
                $phanquyenModel = new PhanQuyenModel();

                $xoa = $phanquyenModel->xoaChiTietNhomQuyen($role_id);
                if ($permissions == null) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật quyền thành công']);
                    return;
                }
                foreach ($permissions as $function_id => $actions) {
                    foreach ($actions as $action => $value) {
                        $them = $phanquyenModel->themChiTietNhomQuyen($role_id, $function_id, $action);
                    }
                }
                if ($them) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật quyền thành công.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Cập nhật quyền thất bại.']);
                }
            }
        }

        public function getAllowedFunctions($roleId)
        {
            require_once('Model/PhanQuyenModel.php');
            $phanquyenModel = new PhanQuyenModel();
            $allowedFunctions = $phanquyenModel->getAllowedFunctions($roleId);
            return $allowedFunctions;
        }

        public function hasPermission($function_id, $action, $allowedFunctions)
        {
            foreach ($allowedFunctions as $func) {
                if ($func['function_id'] == $function_id && in_array($action, explode(',', $func['action']))) {
                    return true;
                }
            }
            return false;
        }
        public function getChiTietNhomQuyen($role_id)
        {
            require_once('Model/PhanQuyenModel.php');
            $phanquyenModel = new PhanQuyenModel();
            $allFunctions = $phanquyenModel->getChiTietNhomQuyen($role_id);
            return $allFunctions;
        }
    }
    ?>