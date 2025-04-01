    <?php
    $host = "localhost";
    $usernamedb = "root";
    $password = "";
    $dbname = "web2_test";

    $conn = new mysqli($host, $usernamedb, $password, $dbname);
    if ($conn->connect_error) {
        die("ket noi khong thanh cong: " . $conn->connect_error);
    }
    ?>
