<?php
require_once("database/connect.php");

class OrderModel
{
    private $conn;

    public function __construct()
    {
        $db = new database();
        $this->conn = $db->getConnection();
    }

    public function getAllOrder()
    {
        $sql = "SELECT  * FROM DonHang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();

        return $orders;
    }

    public function getAllOrderHistoryByCustomerId($id)
    {
        $sql = "SELECT  * FROM DonHang WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();

        return $orders;
    }

    public function getOrderHistoryByStatus($status)
    {
        $sql = "SELECT  * FROM DonHang WHERE status = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return $order;
    }

    public function changeStatusById($orderId, $newStatus)
    {
        $sql = "UPDATE DonHang SET status = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newStatus, $orderId);
        $stmt->execute();
    }
    public function getOrdersByDateRange($from, $to) {
        $sql = "SELECT * FROM DonHang WHERE orderDate BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
        return $orders;
    }

    public function getOrdersWithFilters($from = "", $to = "", $customerId = 0, $status = "") {
        // 👉 Nếu không có bất kỳ điều kiện nào → gọi luôn getAllOrder()
        if (empty($from) && empty($to) && $customerId == 0 && empty($status)) {
            return $this->getAllOrder();
        }
    
        $sql = "SELECT * FROM DonHang WHERE 1=1";
        $params = [];
        $types = "";
    
        if ($from && $to) {
            $sql .= " AND orderDate BETWEEN ? AND ?";
            $types .= "ss";
            $params[] = $from;
            $params[] = $to;
        } else if ($from) {
            $sql .= " AND orderDate >= ?";
            $types .= "s";
            $params[] = $from;
        } else if ($to) {
            $sql .= " AND orderDate <= ?";
            $types .= "s";
            $params[] = $to;
        }
    
        if ($customerId != 0) {
            $sql .= " AND customer_id = ?";
            $types .= "i";
            $params[] = $customerId;
        }
    
        if ($status != "") {
            $sql .= " AND status = ?";
            $types .= "s";
            $params[] = $status;
        }
    
        $stmt = $this->conn->prepare($sql);
    
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    
        $stmt->close();
        return $orders;
    }
    
    

    public function addOrder($customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt)
    {
        $sql = "INSERT INTO DonHang (customer_id, orderDate, total, status, address_id, note, pttt) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isisiss", $customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Trả về ID của đơn hàng vừa thêm
        } else {
            return false;
        }
    }

    public function addDetailOrder($order_id, $product_id, $quantity, $price)
    {
        $sql = "INSERT INTO ChiTietDonHang (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $order_id, $product_id, $quantity, $price);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAutoIncrementId()
    {
        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'webbanhang' AND TABLE_NAME = 'DonHang'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['AUTO_INCREMENT'];
    }
}
