    <?php
    $servername = "localhost";
    $usernamedb = "root";
    $password = "";
    $dbname = "web2_test";

    // Create connection
    $conn = new mysqli($servername, $usernamedb, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
