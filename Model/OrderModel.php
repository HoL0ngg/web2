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
        $sql = "SELECT  * FROM donhang";
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
        $sql = "SELECT  * FROM donhang WHERE customer_id = ?";
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
        $sql = "SELECT  * FROM donhang WHERE status = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return $order;
    }

    public function changeStatusByEmployeeId($orderId, $newStatus, $employee_id)
    {
        $sql = "UPDATE donhang SET status = ?, employee_id = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $newStatus, $employee_id, $orderId);
        $stmt->execute();
    }

    public function changeStatusByCustomerId($orderId, $newStatus, $customer_id)
    {
        $sql = "UPDATE donhang SET status = ?, customer_id = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $newStatus, $customer_id, $orderId);
        $stmt->execute();
    }


    public function getOrdersByDateRange($from, $to)
    {
        $sql = "SELECT * FROM donhang WHERE orderDate BETWEEN ? AND ?";
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

    public function getOrdersWithFilters($from = "", $to = "", $keyword = "", $status = "", $thanhpho = "", $quan = "", $phuong = "")
    {
        if (empty($from) && empty($to) && empty($keyword) && empty($status) && empty($thanhpho) && empty($quan) && empty($phuong)) {
            return $this->getAllOrder();
        }

        $sql = "SELECT dh.* FROM donhang dh 
            JOIN diachi dc ON dh.address_id = dc.address_id 
            WHERE 1=1";
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

        if ($keyword != 0) {
            $keyword = "%$keyword%";
            $sql .= " AND customer_recipient_name LIKE ?";
            $types .= "s";
            $params[] = $keyword;
        }

        if ($status != "") {
            $sql .= " AND status = ?";
            $types .= "s";
            $params[] = $status;
        }

        if ($thanhpho != "") {
            $sql .= " AND dc.thanhpho = ?";
            $types .= "s";
            $params[] = $thanhpho;

            if ($quan != "") {
                $sql .= " AND dc.quan = ?";
                $types .= "s";
                $params[] = $quan;

                if ($phuong != "") {
                    $sql .= " AND dc.phuong = ?";
                    $types .= "s";
                    $params[] = $phuong;
                }
            }
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


    public function getOrderHistoriesWithFilters($from = "", $to = "", $customer_id = "", $status = "")
{
    // Nếu không có bộ lọc, trả về tất cả đơn hàng
    if (empty($from) && empty($to) && empty($customer_id) && empty($status)) {
        return $this->getAllOrder();
    }

    $sql = "SELECT dh.* FROM donhang dh WHERE 1=1";
    $params = [];
    $types = "";

    // Gán luôn customer_id
    $sql .= " AND customer_id = ?";
    $types .= "s";
    $params[] = $customer_id;

    if (!empty($from) && !empty($to)) {
        $sql .= " AND orderDate BETWEEN ? AND ?";
        $types .= "ss";
        $params[] = $from;
        $params[] = $to;
    } elseif (!empty($from)) {
        $sql .= " AND orderDate >= ?";
        $types .= "s";
        $params[] = $from;
    } elseif (!empty($to)) {
        $sql .= " AND orderDate <= ?";
        $types .= "s";
        $params[] = $to;
    }

    if (!empty($status)) {
        $sql .= " AND status = ?";
        $types .= "s";
        $params[] = $status;
    }

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();
    return $orders;
}



    public function addOrder($customer_recipient_name, $phone, $email, $customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt)
    {
        $sql = "INSERT INTO donhang (customer_id, orderDate, total, status, address_id, note, pttt, customer_recipient_name, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isisisssss", $customer_id, $order_date, $total_price, $status, $address_id, $note, $pttt, $customer_recipient_name, $phone, $email);
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Trả về ID của đơn hàng vừa thêm
        } else {
            return false;
        }
    }

    public function addDetailOrder($order_id, $product_id, $quantity, $price)
    {
        $sql = "INSERT INTO chitietdonhang (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
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
        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'webbanhang' AND TABLE_NAME = 'donhang'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['AUTO_INCREMENT'];
    }

    public function getOrderCount()
    {
        $sql = "SELECT COUNT(*) AS total_orders FROM donhang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_orders'];
    }

    public function getTotalCount()
    {
        $sql = "SELECT SUM(total) AS total_amount FROM donhang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_amount'] ?? 0; // Trả về 0 nếu không có đơn hàng nào
    }
}
