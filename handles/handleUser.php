    <?php
    require_once("../TKModel.php");
    $response = [
        'success' => false,
        'message' => '',
        'redirect' => ''
    ];
    if (isset($_POST["them"])) {
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
            throw new Exception('Thêm tài khoản không thành công');
        }
    } elseif (isset($_POST["sua"])) {
        $userId = $_GET['uid'] ?? null;
        $userId = (int)$userId;
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
            throw new Exception('Cập nhật không thành công');
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
    ?>