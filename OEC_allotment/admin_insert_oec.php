<?php
include '../header.php';
if (isset($_POST['data'])) {
    // Get the data from the $_POST variable
    $data = $_POST['data'];

    // Looping through each row of data and inserting to the db
    foreach ($data as $row) {
        print_r($row);
        echo "<br>";
        $column1 = $row[0];
        $column2 = $row[1];
        $column3 = $row[2];

        //insert these into the u_prgm_elective_course table
    }
    } else {
        // Handle the error
        echo "No data entered!";
    }
?>
