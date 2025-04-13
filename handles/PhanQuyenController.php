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
            include('view/PhanQuyenView.php');
        }
    }
    ?>