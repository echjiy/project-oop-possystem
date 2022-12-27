<?php
include('config/pdoconfig.php');

if (!empty($_POST["custName"])) {
    $id = $_POST['custName'];

    // Check if $DB_con is defined before using it
    if (isset($DB_con)) {
        $stmt = $DB_con->prepare("SELECT * FROM  rpos_customers WHERE customer_name = :id");
        $stmt->execute(array(':id' => $id));

        // Move the while loop inside the if block
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo htmlentities($row['customer_id']);
        }
    }
}