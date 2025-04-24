<?php
require_once __DIR__ . '/../database/connect.php';

class SupplierModel {
    private $conn;

    public function __construct() {
        $db = new database();
        $this->conn = $db->getConnection();
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }

    public function getSuppliersAndProducts() {
        // Truy vấn để lấy tất cả nhà cung cấp, bao gồm cả những nhà cung cấp không có sản phẩm
        $sql = "
            SELECT 
                ncc.supplier_id,
                ncc.supplier_name,
                ncc.address,
                sp.product_id,
                sp.product_name
            FROM nhacungcap AS ncc
            LEFT JOIN nhacungcapsanpham AS nccsp ON ncc.supplier_id = nccsp.supplier_id
            LEFT JOIN sanpham AS sp ON nccsp.product_id = sp.product_id
            ORDER BY ncc.supplier_id
        ";
        $result = $this->conn->query($sql);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Log the data to debug
        file_put_contents(__DIR__ . "/debug_supplier_model.log", "Fetched data from DB: " . print_r($data, true) . "\n", FILE_APPEND);

        return $data;
    }

    public function addSupplier($supplier_name, $supplier_address) {
        $sql = "INSERT INTO nhacungcap (supplier_name, address) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $supplier_name, $supplier_address);
        
        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        } else {
            $error = $stmt->error;
            $stmt->close();
            return ['success' => false, 'error' => "Lỗi khi thêm nhà cung cấp: $error"];
        }
    }

    public function getProductsBySupplier($supplier_id) {
        $sql = "
            SELECT 
                sp.product_id,
                sp.product_name
            FROM nhacungcapsanpham AS nccsp
            JOIN sanpham AS sp ON nccsp.product_id = sp.product_id
            WHERE nccsp.supplier_id = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $supplier_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function updateSupplier($supplier_id, $supplier_name, $supplier_address, $products) {
        $this->conn->begin_transaction();

        try {
            $sql = "UPDATE nhacungcap SET supplier_name = ?, address = ? WHERE supplier_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $supplier_name, $supplier_address, $supplier_id);
            $stmt->execute();
            $stmt->close();

            $sql = "DELETE FROM nhacungcapsanpham WHERE supplier_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $supplier_id);
            $stmt->execute();
            $stmt->close();

            foreach ($products as $product_id) {
                $sql = "INSERT INTO nhacungcapsanpham (supplier_id, product_id) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $supplier_id, $product_id);
                $stmt->execute();
                $stmt->close();
            }

            $this->conn->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $this->conn->rollback();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getAvailableProducts($supplier_id, $current_products = []) {
        $existing_products = [];
        $sql = "SELECT product_id FROM nhacungcapsanpham WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $supplier_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $existing_products[] = $row['product_id'];
        }
        $stmt->close();

        $exclude_products = array_unique(array_merge($existing_products, $current_products));

        if (empty($exclude_products)) {
            $sql = "SELECT product_id, product_name FROM sanpham";
            $stmt = $this->conn->prepare($sql);
        } else {
            $placeholders = implode(',', array_fill(0, count($exclude_products), '?'));
            $sql = "SELECT product_id, product_name FROM sanpham WHERE product_id NOT IN ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            $types = str_repeat('i', count($exclude_products));
            $stmt->bind_param($types, ...$exclude_products);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function deleteSupplier($supplier_id) {
        $sql = "SELECT COUNT(*) as count FROM nhacungcapsanpham WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $supplier_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row['count'] > 0) {
            return ['success' => false, 'error' => 'Nhà cung cấp vẫn còn sản phẩm, không thể xóa'];
        }

        $sql = "DELETE FROM nhacungcap WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $supplier_id);
        $stmt->execute();
        $stmt->close();

        return ['success' => true];
    }
}
?>