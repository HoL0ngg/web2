    <?php
    $servername = "localhost";
    $usernamedb = "root";
    $password = "";
    $dbname = "webbanhang";

    // Create connection
    $conn = new mysqli($servername, $usernamedb, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
