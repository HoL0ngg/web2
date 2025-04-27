    <?php
    session_start();
    header('Content-Type: application/json');
    require_once __DIR__ . '/../handles/TKController.php';
    $action = $_POST['action'] ?? '';
    $tkController = new TKController();
    switch ($action) {
        case 'add':
            $tkController->addUser();
            break;
        case 'update';
            $tkController->updateUser();
            break;
        case 'searchUser':
            $keyword = $_POST['keyword'] ?? '';
            $type = $_POST['type'] ?? 'all';
            $tkController->searchUser($keyword, $type);
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