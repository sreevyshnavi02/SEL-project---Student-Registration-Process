<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <!-- check if the student is btwn 4th to 7th sem -->
    <?php 
        include '../header.php'; 
        $year =  $_POST['session_year'];
        $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
        $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];


        $regno = $_SESSION['regno'];   //entered during login
        //-------temporary--------
        //to get the session as input from the user
        $session = $_SESSION['chosen_session']; 

        $stud_sem = $conn -> query ("select * from u_student where regno = '$regno';");
        $sem = $stud_sem -> fetchAll(PDO::FETCH_ASSOC);
        if($sem[0]['CURR_SEM'] >= 4 && $sem[0]['CURR_SEM'] <= 7){
            //eligible to register for oec
            //display a drop down menu with the available oecs

            //check if the capacity is reached for an oec before displaying it

            $fetch_oec_sql = "select e.course_code, c.course_name, c.course_type 
            from u_prgm_elective_course e, u_course c 
            where e.no_of_students_enrolled < e.capacity 
            and e.session = :sess and e.course_code = c.course_code";

            $fetch_oec_query = $conn -> prepare($fetch_oec_sql);
            $fetch_oec_query -> bindParam(':sess', $session);
            $fetch_oec_query -> execute();

            $fetch_oec = $fetch_oec_query -> fetchAll(PDO::FETCH_ASSOC);

            $fetch_stud_details_sql = "select sname, curr_sem, credits_earned from u_student where regno = :regno";
            $fetch_stud_details = $conn -> prepare($fetch_stud_details_sql);
            $fetch_stud_details -> bindParam(':regno', $regno);
            $fetch_stud_details -> execute();
            $n = $fetch_stud_details -> rowCount();

            $fetched_stud_data = $fetch_stud_details -> fetchAll(PDO::FETCH_ASSOC);

            //display the rows fetched in this query in drop-down menu
        ?>

        <div class="oec_option_div">
            <!-- display student details -->
            <form action="preregister_submit.php" method = "post">
                <?php 
                foreach($fetched_stud_data as $stud_data){ 
                    echo '
                        <label for="sname">Name: </label>
                        <input type="text" name="sname" id="sname" value="'.$stud_data['sname'] .'" readonly>

                        <label for="curr_sem">Semester: </label>
                        <input type="text" name="curr_sem" id="curr_sem" readonly value="'.$stud_data['curr_sem'] .'">

                        <label for="credits_earned">Credits earned: </label>
                        <input type="text" name="credits_earned" id="credits_earned" readonly value="'.$stud_data['credits_earned'] .'">
                    ';
                }

                echo '<select name="oec_choose" id="oec_choose">';
                foreach($fetch_oec as $oec){
                    echo('<option value="'.$oec["course_code"].'">'.$oec["course_code"].' - '.$oec["course_name"].'</option>');
                }
                echo '</select>';

                ?>

                <button type="submit">Confirm Option</button>
            </form>
        </div>
    <?php
        }
        else{
            echo("You cannot register for an OEC");
        }
    ?>
</body>
</html>
