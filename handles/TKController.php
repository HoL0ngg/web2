    <?php
    require_once('Model/TKModel.php');
    require_once('view/chucnangAccount.php');
    require_once('Model/NhomQuyenModel.php');
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

        public function addUser() {}
        public function updateUser() {}
    }

    ?>