    <?php
    class PhanQuyenController
    {

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
    }
    ?>