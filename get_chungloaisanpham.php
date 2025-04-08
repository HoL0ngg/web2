<?php
if (isset($_GET['maChungloai'])) {
    include('connect.php');
    $maChungloai = $_GET['maChungloai'];

    $sql = "SELECT machungloai , tenchungloai FROM chungloai WHERE machungloai = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $maChungloai);
    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $ten = htmlspecialchars($row['tenchungloai']);
        echo "<div>";
        echo "$ten";
        echo "</div>";
    }
} else {
    echo "Không có chủng loại được chọn.";
}
