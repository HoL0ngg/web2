    <?php
    // require_once './Model/FormProductModel.php';
    require_once __DIR__ . '/../Model/FormProductModel.php';
    // session_start();
    class FormProductController
    {
        private $model;

        public function __construct()
        {
            // $db = new database();
            $this->model = new FormProductModel();
        }

        public function addForm()
        {
            require_once './Model/TheLoaiModel.php';
            require_once './Model/BrandModel.php';
            $theloaiModel = new TheLoaiModel();
            $brandModel = new BrandModel();

            $theloai = $theloaiModel->getAll();
            $brands = $brandModel->getAll();
            include('view/addProductView.php');
        }

        public function updateForm($id)
        {
            require_once './Model/TheLoaiModel.php';
            require_once './Model/BrandModel.php';
            $id = (int)$id;
            $product = $this->model->getProductById($id);

            $theloaiModel = new TheLoaiModel();
            $brandModel = new BrandModel();

            $theloai = $theloaiModel->getAll();
            $brands = $brandModel->getAll();
            include('view/updateProductView.php');
        }

        public function addProduct()
        {
            header('Content-Type: application/json');
            $response = ["success" => false, "message" => "", "redirect" => ""];

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                $response["message"] = "Phương thức không hợp lệ";
                echo json_encode($response);
                return;
            }

            // Lấy dữ liệu từ form
            $productName = $_POST['productname'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $price = $_POST['price'] ?? 0;
            $theloai = $_POST['theloai'] ?? '';
            $thuonghieu = $_POST['thuonghieu'] ?? '';
            $status = $_POST['status'] ?? 1;
            $mota = $_POST['mota'] ?? '';

            // Kiểm tra hình ảnh
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = dirname(__DIR__) . '/imgs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = basename($_FILES['image']['name']);
                $targetFile = $uploadDir . uniqid() . '_' . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // Lưu đường dẫn tương đối để lưu database
                    $imagePath = 'imgs/' . basename($targetFile);
                } else {
                    $response["message"] = "Không thể lưu ảnh.";
                    echo json_encode($response);
                    return;
                }
            }

            // Gọi model
            $result = $this->model->them($imagePath, $productName, $quantity, $price, $theloai, $thuonghieu, $status, $mota);

            // Xử lý kết quả trả về từ model
            switch ($result) {
                case 'name_exists':
                    $response["message"] = "Tên sản phẩm đã tồn tại!";
                    break;
                case 'insert_failed':
                    $response["message"] = "Không thể thêm sản phẩm!";
                    break;
                case 'insertImg_failed':
                    $response["message"] = "Thêm ảnh sản phẩm thất bại!";
                    break;
                case 'exception':
                    $response["message"] = "Lỗi hệ thống. Vui lòng thử lại!";
                    break;
                case 'success':
                    $response["success"] = true;
                    $response["message"] = "Thêm sản phẩm thành công!";
                    $response["redirect"] = "admin.php?page=product";
                    break;
                default:
                    $response["message"] = "Lỗi không xác định!";
                    break;
            }

            echo json_encode($response);
            exit;
        }

        public function editProduct($product_id)
        {
            header('Content-Type: application/json');
            $response = ["success" => false, "message" => "", "redirect" => ""];

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                $response["message"] = "Phương thức không hợp lệ";
                echo json_encode($response);
                return;
            }
            $productName = $_POST['productname'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $price = $_POST['price'] ?? 0;
            $theloai = $_POST['theloai'] ?? '';
            $thuonghieu = $_POST['thuonghieu'] ?? '';
            $status = $_POST['status'] ?? 1;
            $mota = $_POST['mota'] ?? '';

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = dirname(__DIR__) . '/imgs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = basename($_FILES['image']['name']);
                $targetFile = $uploadDir . uniqid() . '_' . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // Lưu đường dẫn tương đối để lưu database
                    $imagePath = 'imgs/' . basename($targetFile);
                } else {
                    $response["message"] = "Không thể lưu ảnh.";
                    echo json_encode($response);
                    return;
                }
            }

            $result = $this->model->sua($imagePath, $product_id, $productName, $quantity, $price, $theloai, $thuonghieu, $status, $mota);

            switch ($result) {
                case 'name_exists':
                    $response["message"] = "Tên sản phẩm đã tồn tại.";
                    break;
                case 'update_failed':
                    $response["message"] = "Không thể cập nhật sản phẩm.";
                    break;
                case 'updateImg_failed':
                    $response["message"] = "Cập nhật ảnh sản phẩm thất bại.";
                    break;
                case 'exception':
                    $response["message"] = "Có lỗi xảy ra trong quá trình cập nhật.";
                    break;
                case 'success':
                    $response["success"] = true;
                    $response["message"] = "Cập nhật sản phẩm thành công!";
                    $response["redirect"] = "admin.php?page=product";
                    break;
                default:
                    $response["message"] = "Không xác định.";
            }

            echo json_encode($response);
            exit;
        }

        public function getAllProducts()
        {
            $products = $this->model->getAllProducts();
            include('view/product.php');
        }

        public function checkProductIsSold($product_id)
        {
            header('Content-Type: application/json');
            $result = $this->model->checkProductIsSold($product_id);
            echo json_encode(['success' => $result]);
            exit;
        }
        public function checkProductIsImported($product_id)
        {
            header('Content-Type: application/json');
            $result = $this->model->checkProductIsImported($product_id);
            echo json_encode(['success' => $result]);
            exit;
        }
        public function deleteProduct($product_id)
        {
            header('Content-Type: application/json');
            $response = ["success" => false, "message" => ""];

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                $response["message"] = "Phương thức không hợp lệ";
                echo json_encode($response);
                return;
            }
            $result = $this->model->xoa($product_id);
            switch ($result) {
                case 'delete_failed':
                    $response["message"] = "Không thể xóa sản phẩm.";
                    break;
                case 'product_sold':
                    $response["message"] = "Sản phẩm đã được bán, không thể xóa.";
                    break;
                case 'exception':
                    $response["message"] = "Có lỗi xảy ra trong quá trình xóa.";
                    break;
                case 'success':
                    $response["success"] = true;
                    $response["message"] = "Xóa sản phẩm thành công!";
                    break;
                default:
                    $response["message"] = "Không xác định.";
            }
            echo json_encode($response);
            exit;
        }

        public function hideProduct($product_id)
        {
            header('Content-Type: application/json');
            $response = ["success" => false, "message" => ""];
            $result = $this->model->hideProduct($product_id);
            switch ($result) {
                case 'success':
                    echo json_encode(["success" => true, "message" => "Ẩn sản phẩm thành công!"]);
                    break;
                default:
                    echo json_encode(["success" => false, "message" => "Có lỗi xảy ra trong quá trình ẩn sản phẩm."]);
                    break;
            }
            exit;
        }
        public function search($keyword, $type)
        {
            header('Content-Type: application/json');
            $response = ["products" => [], "actions" => []];
            require_once __DIR__ . '/../handles/PhanQuyenController.php';
            $phanquyenController = new PhanQuyenController();
            $canUpdate = $phanquyenController->hasPermission('sanpham', 'update', $_SESSION['permissions']);
            $canDelete = $phanquyenController->hasPermission('sanpham', 'delete', $_SESSION['permissions']);
            $products = $this->model->searchProducts($keyword, $type);
            $response["products"] = $products;
            $response["actions"]["canUpdate"] = $canUpdate;
            $response["actions"]["canDelete"] = $canDelete;
            echo json_encode($response);
            exit;
        }
    }
    ?>