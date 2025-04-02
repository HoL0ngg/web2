    <?php
    require_once("../connect.php");

    $sql = "SELECT * FROM users ORDER BY id DESC";
    $result = $conn->query($sql);

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    $conn->close();
    ?>