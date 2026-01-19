<?php
    include('../config/conn_db.php');

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    $query = "SELECT a_id, a_username, a_firstname, a_lastname FROM admin WHERE
    a_username = '$username' AND a_pwd = '$pwd' AND a_status = 1 LIMIT 0,1";

    $result = $mysqli -> query($query);
    if($result -> num_rows == 1){
        $row = $result -> fetch_array();
        session_start();
        $_SESSION["aid"] = $row["a_id"];
        $_SESSION["firstname"] = $row["a_firstname"];
        $_SESSION["lastname"] = $row["a_lastname"];
        // Use 'ADMIN' to match other admin pages and Auth.php
        $_SESSION["utype"] = "ADMIN";

        header("location: admin_home.php");
        exit(1);
    }else{
        ?>
        <script>
            alert("You entered wrong username and/or password!");
            history.back();
        </script>
        <?php
    }
?>