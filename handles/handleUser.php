    <?php
    header('Content-Type: application/json');
    require_once("../TKModel.php");
    $response = [
        'success' => false,
        'message' => '',
        'redirect' => ''
    ];
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $username = $_POST['username'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $status = $_POST['status'] ?? '1';
        $role = $_POST['role'] ?? '1';

        $userModel = new TKModel();
        $result = $userModel->them($username, $phone, $email, $password, $status, $role);
        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Thêm tài khoản thành công',
                'redirect' => '/admin.php?page=user'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Thêm không thành công',
                'redirect' => '/admin.php?page=user&act=add'
            ];
            throw new Exception('Thêm tài khoản không thành công');
        }
    } elseif ($action === 'update') {
        $userId = $_POST['id'];
        $userId = (int)$userId;
        if ($userId <= 0) {
            throw new Exception("Id nho hon khong");
        }
        $username = $_POST['username'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $status = $_POST['status'] ?? '1';
        $role = $_POST['role'] ?? '1';

        $userModel = new TKModel();
        $result = $userModel->sua($userId, $username, $phone, $email, $password, $status, $role);

        if ($result) {
            $response = [
                'success' => true,
                'message' => 'Cập nhật tài khoản thành công',
                'redirect' => '/admin.php?page=user'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Cập nhật tài khoản không thành công',
                // 'redirect' => '/admin.php?page=user&act=update'
            ];
            // throw new Exception('Cập nhật không thành công');
        }
    }

    echo json_encode($response);
    exit();
    ?>