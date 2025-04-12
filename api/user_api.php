    <?php
    header('Content-Type: application/json');
    require_once __DIR__ . '/../handles/TKController.php';
    // require_once("../handles/TKController.php");
    $action = $_POST['action'] ?? '';
    $userId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $tkController = new TKController();
    switch ($action) {
        case 'add':
            $tkController->addUser();
            break;

        default:
            # code...
            break;
    }
    // if ($action === 'add') {
    //     $username = $_POST['username'] ?? '';
    //     $phone = $_POST['phone'] ?? '';
    //     $fullname = $_POST['fullname'];
    //     $email = $_POST['email'] ?? '';
    //     $password = $_POST['password'] ?? '';
    //     $status = $_POST['status'] ?? '1';
    //     $role = $_POST['role'] ?? '1';

    //     $userModel = new TKModel();
    //     $result = $userModel->them($username, $fullename, $phone, $email, $password, $status, $role);
    //     if ($result) {
    //         $response = [
    //             'success' => true,
    //             'message' => 'Thêm tài khoản thành công',
    //             'redirect' => '/admin.php?page=user'
    //         ];
    //     } else {
    //         $response = [
    //             'success' => false,
    //             'message' => 'Thêm tài khoản không thành công!',
    //             'redirect' => ''
    //         ];
    //     }
    // } elseif ($action === 'update') {
    //     // $userId = $_POST['id'];
    //     // $userId = (int)$userId;
    //     if ($userId <= 0) {
    //         throw new Exception("Id nho hon khong");
    //     }
    //     $username = $_POST['username'] ?? '';
    //     $phone = $_POST['phone'] ?? '';
    //     $email = $_POST['email'] ?? '';
    //     $password = $_POST['password'] ?? '';
    //     $status = $_POST['status'] ?? '1';
    //     $role = $_POST['role'] ?? '1';

    //     $userModel = new TKModel();
    //     $result = $userModel->sua($userId, $username, $phone, $email, $password, $status, $role);

    //     if ($result) {
    //         $response = [
    //             'success' => true,
    //             'message' => 'Cập nhật tài khoản thành công',
    //             'redirect' => 'admin.php?page=user'
    //         ];
    //     } else {
    //         $response = [
    //             'success' => false,
    //             'message' => 'Cập nhật tài khoản không thành công',
    //             // 'redirect' => 'admin.php?page=user&act=update&uid=' . $userid
    //             'redirect' => ''
    //         ];
    //         // throw new Exception('Cập nhật không thành công');
    //     }
    // } elseif ($action === 'xoa') {
    //     $userModel = new TKModel();
    //     $result = $userModel->xoa($userId);
    //     $response = [
    //         'success' => $result,
    //         'message' => $result ? 'Xóa tài khoản thành công!' : 'Xóa tài khoản không thành công!',
    //         'redirect' => $result ? 'admin.php?page=user' : ''
    //     ];
    // }

    // echo json_encode($response);
    // exit();
    ?>