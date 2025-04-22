    <?php
    // require_once './Model/FormProductModel.php';
    require_once __DIR__ . '/../Model/FormProductModel.php';

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
                $uploadDir = '../imgs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = basename($_FILES['image']['name']);
                $targetFile = $uploadDir . uniqid() . '_' . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
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
                $uploadDir = '../imgs/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = basename($_FILES['image']['name']);
                $targetFile = $uploadDir . uniqid() . '_' . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
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
        }

        public function getAllProducts()
        {
            $products = $this->model->getAllProducts();
            include('view/product.php');
        }
    }
    ?>