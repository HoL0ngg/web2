    <?php
    session_start();
    header('Content-Type: application/json');

    $response = ["success" => false, "username" => ""];
    if (isset($_SESSION["username"])) {
        $response["success"] = true;
        $response["username"] = $_SESSION["username"];
    }
    echo json_encode($response);
    ?>