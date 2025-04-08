    <?php
    require_once("../database/connect.php");
    $db = new database();
    $conn = $db->getConnection();
    $sql = "SELECT * FROM users ORDER BY user_id DESC";
    $result = $conn->query($sql);

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
    $db->closeConnection();
    ?>