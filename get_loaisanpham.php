<?php
if (isset($_GET['maChungloai'])) {
    include('connect.php');
    $maChungloai = $_GET['maChungloai'];
    $maChungloai = (int)$maChungloai;
    // Truy vấn cơ sở dữ liệu để lấy các thể loại con (subcategories) theo maChungloai
    $sql = "SELECT matheloai , tentheloai FROM theloai WHERE machungloai = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $maChungloai);
    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $id = $row['matheloai'];
        $ten = htmlspecialchars($row['tentheloai']);
        echo "<li>";
        echo "<input type='checkbox' id='theloai_$id' value='$id'>";
        echo "<span>$ten</span>";
        echo "</li>";
    }
} else {
    echo "Không có chủng loại được chọn.";
}
