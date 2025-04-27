<?php
require_once __DIR__ . '/../database/connect.php';

class ImportModel {
    private $conn;

    public function __construct() {
        $db = new database();
        $this->conn = $db->getConnection();
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }

    public function getImportData() {
        // Truy vấn để lấy tất cả nhà cung cấp, bao gồm cả những nhà cung cấp không có sản phẩm
        $sql = "
            SELECT 
                pn.*, ncc.supplier_id, ncc.supplier_name, nv.employee_id, nv.name
            FROM phieunhap AS pn
            JOIN nhacungcap AS ncc ON pn.supplier_id = ncc.supplier_id
            JOIN nhanvien AS nv ON pn.employee_id = nv.employee_id
        ";
        $result = $this->conn->query($sql);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Log the data to debug
        file_put_contents(__DIR__ . "/debug_import_model.log", "Fetched data from DB: " . print_r($data, true) . "\n", FILE_APPEND);

        return $data;
    }
    public function getSuppliers() {
        $sql = "SELECT * FROM nhacungcap";
        $result = $this->conn->query($sql);

        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
        return $suppliers;
    }
    public function getEmployees() {
        $sql = "SELECT * FROM nhanvien";
        $result = $this->conn->query($sql);

        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        return $employees;
    }
    public function addPhieuNhap($supplier_id, $employee_id) {
        // Lấy ngày hiện tại
        $current_date = date('Y-m-d H:i:s');
        // Trạng thái ban đầu luôn là: 'processing'
        $status = 'processing';
        $sql = "INSERT INTO phieunhap (supplier_id, employee_id, create_time, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiss", $supplier_id, $employee_id, $current_date, $status);
        
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        } else {
            $error = $stmt->error;
            $stmt->close();
            return ['success' => false, 'error' => "Lỗi khi thêm phiếu nhập: $error"];
        }
    }

    public function getChiTietPhieuNhapDataPopup($receipt_id) {
        $sql = "
            SELECT 
                pn.receipt_id, pn.supplier_id, pn.employee_id, pn.create_time, pn.confirm_time, pn.total, pn.status,
                ncc.supplier_name, ncc.address,
                nv.name AS employee_name,
                ctpn.product_id, ctpn.quantity, ctpn.price, ctpn.percent,
                sp.product_name,
                (ctpn.price * ctpn.quantity) AS total_product
            FROM phieunhap pn
            JOIN nhacungcap ncc ON pn.supplier_id = ncc.supplier_id
            JOIN nhanvien nv ON pn.employee_id = nv.employee_id
            LEFT JOIN chitietphieunhap ctpn ON pn.receipt_id = ctpn.receipt_id
            LEFT JOIN sanpham sp ON ctpn.product_id = sp.product_id
            WHERE pn.receipt_id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $receipt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [
            'info' => null,
            'products' => []
        ];

        while ($row = $result->fetch_assoc()) {
            if (!$data['info']) {
                $data['info'] = [
                    'receipt_id' => $row['receipt_id'],
                    'supplier_id' => $row['supplier_id'],
                    'supplier_name' => $row['supplier_name'],
                    'address' => $row['address'],
                    'employee_id' => $row['employee_id'],
                    'employee_name' => $row['employee_name'],
                    'status' => $row['status'],
                    'total' => $row['total']
                ];
            }
            if ($row['product_id']) {
                $data['products'][] = [
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'percent' => $row['percent'],
                    'sell_price' => $row['price'] * (1 + $row['percent'] / 100),
                    'total_product' => $row['total_product']
                ];
            }
        }
        $stmt->close();
        return ['success' => true, 'data' => $data];
    }

    // public function updatePhieuNhap($receipt_id, $status, $products) {
    //     $this->conn->begin_transaction();
        
    //     try {
    //         // Kiểm tra receipt_id tồn tại
    //         $sql = "SELECT receipt_id FROM phieunhap WHERE receipt_id = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         if (!$stmt) {
    //             throw new Exception("Lỗi chuẩn bị kiểm tra receipt_id: " . $this->conn->error);
    //         }
    //         $stmt->bind_param("i", $receipt_id);
    //         $stmt->execute();
    //         $result = $stmt->get_result();
    //         if ($result->num_rows === 0) {
    //             throw new Exception("Mã phiếu nhập $receipt_id không tồn tại");
    //         }
    //         $stmt->close();
    
    //         // Cập nhật trạng thái phiếu nhập
    //         $sql = "UPDATE phieunhap SET status = ?, confirm_time = IF(status IN ('confirmed', 'cancelled'), NOW(), confirm_time) WHERE receipt_id = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         if (!$stmt) {
    //             throw new Exception("Lỗi chuẩn bị câu lệnh UPDATE phieunhap: " . $this->conn->error);
    //         }
    //         $stmt->bind_param("si", $status, $receipt_id);
    //         if (!$stmt->execute()) {
    //             throw new Exception("Lỗi thực thi UPDATE phieunhap: " . $stmt->error);
    //         }
    //         if ($stmt->affected_rows === 0) {
    //             file_put_contents(__DIR__ . "/debug_update_phieunhap.log", 
    //                 "Cảnh báo: Không có hàng nào được cập nhật trong phieunhap cho receipt_id=$receipt_id\n", 
    //                 FILE_APPEND
    //             );
    //         }
    //         $stmt->close();
    
    //         // Xóa chi tiết phiếu nhập cũ
    //         $sql = "DELETE FROM chitietphieunhap WHERE receipt_id = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         if (!$stmt) {
    //             throw new Exception("Lỗi chuẩn bị câu lệnh DELETE chitietphieunhap: " . $this->conn->error);
    //         }
    //         $stmt->bind_param("i", $receipt_id);
    //         if (!$stmt->execute()) {
    //             throw new Exception("Lỗi thực thi DELETE chitietphieunhap: " . $stmt->error);
    //         }
    //         $stmt->close();
    
    //         // Thêm chi tiết phiếu nhập mới và tính tổng tiền
    //         $total = 0;
    //         if (!empty($products)) {
    //             foreach ($products as $product) {
    //                 // Chuyển đổi dữ liệu thành số nguyên
    //                 $product_id = intval($product['product_id']);
    //                 $quantity = intval($product['quantity']);
    //                 $price = intval($product['price']);
    //                 $percent = intval($product['percent']);
    
    //                 // Kiểm tra dữ liệu hợp lệ
    //                 if ($product_id <= 0 || $quantity <= 0 || $price < 0 || $percent < 0) {
    //                     throw new Exception("Dữ liệu sản phẩm không hợp lệ: " . json_encode($product));
    //                 }
    
    //                 // Chèn chi tiết phiếu nhập
    //                 $sql = "INSERT INTO chitietphieunhap (receipt_id, product_id, quantity, price, percent) VALUES (?, ?, ?, ?, ?)";
    //                 $stmt = $this->conn->prepare($sql);
    //                 if (!$stmt) {
    //                     throw new Exception("Lỗi chuẩn bị câu lệnh INSERT chitietphieunhap: " . $this->conn->error);
    //                 }
    //                 $stmt->bind_param("iiiii", $receipt_id, $product_id, $quantity, $price, $percent);
    //                 if (!$stmt->execute()) {
    //                     throw new Exception("Lỗi thực thi INSERT chitietphieunhap: " . $stmt->error);
    //                 }
    //                 $total += $price * $quantity;
    //                 $stmt->close();
    //             }
    //         }
            
    //         // Cập nhật tổng tiền (ngay cả khi $products rỗng)
    //         $sql = "UPDATE phieunhap SET total = ? WHERE receipt_id = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         if (!$stmt) {
    //             throw new Exception("Lỗi chuẩn bị câu lệnh UPDATE total: " . $this->conn->error);
    //         }
    //         $stmt->bind_param("ii", $total, $receipt_id);
    //         if (!$stmt->execute()) {
    //             throw new Exception("Lỗi thực thi UPDATE total: " . $stmt->error);
    //         }
    //         if ($stmt->affected_rows === 0) {
    //             file_put_contents(__DIR__ . "/debug_update_phieunhap.log", 
    //                 "Cảnh báo: Không có hàng nào được cập nhật total cho receipt_id=$receipt_id\n", 
    //                 FILE_APPEND
    //             );
    //         }
    //         $stmt->close();
    
    //         // Commit giao dịch
    //         $this->conn->commit();
    //         return ['success' => true];
    //     } catch (Exception $e) {
    //         // Rollback giao dịch
    //         $this->conn->rollback();
    //         return ['success' => false, 'error' => $e->getMessage()];
    //     }
    // }
    public function updatePhieuNhap($receipt_id, $status, $products) {
        $this->conn->begin_transaction();
        
        try {
            // Kiểm tra receipt_id tồn tại
            $sql = "SELECT receipt_id, status FROM phieunhap WHERE receipt_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị kiểm tra receipt_id: " . $this->conn->error);
            }
            $stmt->bind_param("i", $receipt_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                throw new Exception("Mã phiếu nhập $receipt_id không tồn tại");
            }
            $current_status = $result->fetch_assoc()['status'];
            $stmt->close();
    
            // Cập nhật trạng thái phiếu nhập
            $sql = "UPDATE phieunhap SET status = ?, confirm_time = IF(status IN ('confirmed', 'cancelled'), NOW(), confirm_time) WHERE receipt_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị câu lệnh UPDATE phieunhap: " . $this->conn->error);
            }
            $stmt->bind_param("si", $status, $receipt_id);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi thực thi UPDATE phieunhap: " . $stmt->error);
            }
            if ($stmt->affected_rows === 0) {
                file_put_contents(__DIR__ . "/debug_update_phieunhap.log", 
                    "Cảnh báo: Không có hàng nào được cập nhật trong phieunhap cho receipt_id=$receipt_id\n", 
                    FILE_APPEND
                );
            }
            $stmt->close();
    
            // Xóa chi tiết phiếu nhập cũ
            $sql = "DELETE FROM chitietphieunhap WHERE receipt_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị câu lệnh DELETE chitietphieunhap: " . $this->conn->error);
            }
            $stmt->bind_param("i", $receipt_id);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi thực thi DELETE chitietphieunhap: " . $stmt->error);
            }
            $stmt->close();
    
            // Thêm chi tiết phiếu nhập mới và tính tổng tiền
            $total = 0;
            if (!empty($products)) {
                foreach ($products as $product) {
                    // Chuyển đổi dữ liệu thành số nguyên
                    $product_id = intval($product['product_id']);
                    $quantity = intval($product['quantity']);
                    $price = intval($product['price']);
                    $percent = intval($product['percent']);
    
                    // Kiểm tra dữ liệu hợp lệ
                    if ($product_id <= 0 || $quantity <= 0 || $price < 0 || $percent < 0) {
                        throw new Exception("Dữ liệu sản phẩm không hợp lệ: " . json_encode($product));
                    }
    
                    // Chèn chi tiết phiếu nhập
                    $sql = "INSERT INTO chitietphieunhap (receipt_id, product_id, quantity, price, percent) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    if (!$stmt) {
                        throw new Exception("Lỗi chuẩn bị câu lệnh INSERT chitietphieunhap: " . $this->conn->error);
                    }
                    $stmt->bind_param("iiiii", $receipt_id, $product_id, $quantity, $price, $percent);
                    if (!$stmt->execute()) {
                        throw new Exception("Lỗi thực thi INSERT chitietphieunhap: " . $stmt->error);
                    }
                    $total += $price * $quantity;
                    $stmt->close();
                }
            }
    
            // Cập nhật tổng tiền
            $sql = "UPDATE phieunhap SET total = ? WHERE receipt_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị câu lệnh UPDATE total: " . $this->conn->error);
            }
            $stmt->bind_param("ii", $total, $receipt_id);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi thực thi UPDATE total: " . $stmt->error);
            }
            if ($stmt->affected_rows === 0) {
                file_put_contents(__DIR__ . "/debug_update_phieunhap.log", 
                    "Cảnh báo: Không có hàng nào được cập nhật total cho receipt_id=$receipt_id\n", 
                    FILE_APPEND
                );
            }
            $stmt->close();
    
            // Nếu trạng thái thay đổi từ processing sang confirmed, cập nhật số lượng và giá sản phẩm
            if ($current_status === 'processing' && $status === 'confirmed' && !empty($products)) {
                foreach ($products as $product) {
                    $product_id = intval($product['product_id']);
                    $quantity = intval($product['quantity']);
                    $price = intval($product['price']);
                    $percent = intval($product['percent']);
                    $sell_price = $price * (1 + $percent / 100); // Giá bán
    
                    // Lấy thông tin sản phẩm hiện tại
                    $sql = "SELECT quantity, price FROM sanpham WHERE product_id = ?";
                    $stmt = $this->conn->prepare($sql);
                    if (!$stmt) {
                        throw new Exception("Lỗi chuẩn bị câu lệnh SELECT sanpham: " . $this->conn->error);
                    }
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows === 0) {
                        throw new Exception("Sản phẩm $product_id không tồn tại");
                    }
                    $product_data = $result->fetch_assoc();
                    $current_quantity = intval($product_data['quantity']);
                    $current_price = $product_data['price'] !== null ? intval($product_data['price']) : null;
                    $stmt->close();
    
                    // Tính số lượng mới
                    $new_quantity = $current_quantity + $quantity;
    
                    // Xác định giá mới
                    $new_price = $sell_price;
                    if ($current_price !== null) {
                        // Nếu sản phẩm đã có giá, chỉ cập nhật nếu giá mới lớn hơn
                        $new_price = max($current_price, $sell_price);
                    }
    
                    // Cập nhật số lượng và giá sản phẩm
                    $sql = "UPDATE sanpham SET quantity = ?, price = ? WHERE product_id = ?";
                    $stmt = $this->conn->prepare($sql);
                    if (!$stmt) {
                        throw new Exception("Lỗi chuẩn bị câu lệnh UPDATE sanpham: " . $this->conn->error);
                    }
                    $stmt->bind_param("iii", $new_quantity, $new_price, $product_id);
                    if (!$stmt->execute()) {
                        throw new Exception("Lỗi thực thi UPDATE sanpham: " . $stmt->error);
                    }
                    $stmt->close();
                }
            }
    
            // Commit giao dịch
            $this->conn->commit();
            return ['success' => true];
        } catch (Exception $e) {
            // Rollback giao dịch
            $this->conn->rollback();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getAvailableProducts($supplier_id, $current_products) {
        $sql = "
            SELECT sp.product_id, sp.product_name
            FROM nhacungcapsanpham ncsp
            JOIN sanpham sp ON ncsp.product_id = sp.product_id
            WHERE ncsp.supplier_id = ?
            AND sp.product_id NOT IN (" . (!empty($current_products) ? implode(',', array_fill(0, count($current_products), '?')) : '0') . ")
        ";
        $stmt = $this->conn->prepare($sql);
        $types = "i" . str_repeat("i", count($current_products));
        $params = array_merge([$supplier_id], $current_products);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return ['success' => true, 'data' => $products];
    }

}
?>