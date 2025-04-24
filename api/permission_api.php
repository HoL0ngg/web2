    <?php
    require_once(__DIR__ . '/../handles/PhanQuyenController.php');
    header('Content-Type: application/json');
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $action = $_POST['action'] ?? '';
        $phanQuyenController = new PhanQuyenController();
        switch ($action) {
            case 'addRole':
                $phanQuyenController->addRole();
                break;
            case 'addChucNang':
                $phanQuyenController->addChucNang();
                break;
            case 'updatePermission':
                $phanQuyenController->luu();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ.']);
                break;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
    }
    ?>