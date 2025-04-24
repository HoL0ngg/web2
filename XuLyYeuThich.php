    <?php
    session_start();
    require_once 'handles/handleLove.php';
    require_once 'Model/TKModel.php';
    header('Content-Type: application/json');

    $action = $_POST['action'] ?? '';
    $productId = intval($_POST['productId'] ?? 0);

    $handleLove = new handleLove();
    $user = new TKModel();

    if ($action === 'toggleLove') {
        if (!isset($_SESSION['username'])) {
            // Chưa đăng nhập -> xử lý bằng session
            if (!isset($_SESSION['wishlist'])) {
                $_SESSION['wishlist'] = [];
            }

            if (in_array($productId, $_SESSION['wishlist'])) {
                $_SESSION['wishlist'] = array_diff($_SESSION['wishlist'], [$productId]);
                echo json_encode(['status' => 'success', 'action' => 'removed', 'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích']);
            } else {
                $_SESSION['wishlist'][] = $productId;
                echo json_encode(['status' => 'success', 'action' => 'added', 'message' => 'Đã thêm sản phẩm vào danh sách yêu thích']);
            }
            exit;
        } else {
            if ($_SESSION['user']['role_id'] !== 3) {
                echo json_encode(['status' => 'error', 'message' => 'Tài khoản bạn không có quyền này.']);
                exit;
            }
            // Đã đăng nhập 
            $userId = $user->getIdByUsername($_SESSION['username']);
            $userId = $user->getCustomerIdByUserId($userId);

            $stmt = $handleLove->checkProductInWishlist($userId, $productId);

            if ($stmt->num_rows > 0) {
                // Sản phẩm đã có trong danh sách yêu thích -> xóa
                $handleLove->removeLove($userId, $productId);
                echo json_encode(['status' => 'success', 'action' => 'removed', 'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích']);
            } else {
                // Thêm sản phẩm vào danh sách yêu thích
                $handleLove->addLove($userId, $productId);
                echo json_encode(['status' => 'success', 'action' => 'added', 'message' => 'Đã thêm sản phẩm vào danh sách yêu thích']);
            }
            exit;
        }
    }

    if ($action === 'getLoveProducts') {
        if (isset($_SESSION['username'])) {
            $userId = $user->getIdByUsername($_SESSION['username']);
            $userId = $user->getCustomerIdByUserId($userId);

            $result = $handleLove->getLoveProducts($userId);

            $data = [];
            foreach ($result as $row) {
                $data[] = [
                    'product_id' => $row['product_id'],
                    'customer_id' => $row['customer_id']
                ];
            }

            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            $wishlist = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];
            $data = array_map(function ($id) {
                return ['product_id' => $id];
            }, $wishlist);
            echo json_encode(['status' => 'success', 'data' => $data]);
        }
        exit;
    }

    if ($action === 'UpdateWishlistSessionToDatabase') {
        if (isset($_SESSION['username'])) {
            $userId = $user->getIdByUsername($_SESSION['username']);
            $userId = $user->getCustomerIdByUserId($userId);

            $wishlist = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];

            // Gộp lại các sản phẩm từ session vào database
            foreach ($wishlist as $productId) {
                $stmt = $handleLove->checkProductInWishlist($userId, $productId);
                if ($stmt->num_rows === 0) {
                    $handleLove->addLove($userId, $productId);
                }
            }

            echo json_encode(['status' => 'success', 'message' => 'Cập nhật danh sách yêu thích thành công']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Bạn chưa đăng nhập']);
        }
        exit;
    }

    if ($action === 'getLoveCount') {
        if (isset($_SESSION['username'])) {
            $userId = $user->getIdByUsername($_SESSION['username']);
            $userId = $user->getCustomerIdByUserId($userId);

            $count = $handleLove->getLoveCount($userId);
            echo json_encode(['status' => 'success', 'count' => $count]);
        } else {
            $count = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
            echo json_encode(['status' => 'success', 'count' => $count]);
        }
        exit;
    }
    ?>