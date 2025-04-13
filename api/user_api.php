    <?php
    header('Content-Type: application/json');
    require_once __DIR__ . '/../handles/TKController.php';
    // require_once("../handles/TKController.php");
    $action = $_POST['action'] ?? '';
    // $userId = isset($_POST['uid']) ? (int)$_POST['uid'] : 0;
    $tkController = new TKController();
    switch ($action) {
        case 'add':
            $tkController->addUser();
            break;
        case 'update';
            $tkController->updateUser();
            break;
        default:
            # code...
            break;
    }
    // if ($action === 'xoa') {
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