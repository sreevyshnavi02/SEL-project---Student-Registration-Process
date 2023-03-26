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
        $regno = $_SESSION['regno'];   //entered during login
        //-------temporary--------
        //to get the session as input from the user
        $session = $_POST['session']; 

        $stud_sem = mysqli_query($conn, "select * from u_student where regno = '$regno';");
        $sem = mysqli_fetch_assoc($stud_sem);
        if(1 || $sem['CURR_SEM'] >= 4 && $sem['CURR_SEM'] <= 7){
            //eligible to register for oec
            //display a drop down menu with the available oecs

            //check if the capacity is reached for an oec before displaying it

            $fetch_oec = mysqli_query($conn, "select e.course_code, c.course_name, c.course_type 
            from u_prgm_elective_course e 
            inner join u_course c 
            on e.no_of_students_enrolled < e.capacity 
            and e.session = '$session' 
            and c.course_type = 'OEC';");

            $fetch_stud_details = mysqli_query($conn, "select sname, curr_sem, credits_earned from u_student where regno = '$regno';");
            $n = mysqli_num_rows($fetch_stud_details);
            echo($n);

            $stud_data = mysqli_fetch_assoc($fetch_stud_details);
            print_r($stud_data);

            //display the rows fetched in this query in drop-down menu
        ?>

        <div class="oec_option_div">
            <!-- display student details -->
            <form action="preregister_submit.php" method = "post">
                <label for="sname">Name: </label>
                <input type="text" name="sname" id="sname" value="<?php echo $stud_data['sname']; ?>" readonly>

                <label for="curr_sem">Semester: </label>
                <input type="text" name="curr_sem" id="curr_sem" readonly value="<?php echo $stud_data['curr_sem'] ?>">

                <label for="credits_earned">Credits earned: </label>
                <input type="text" name="credits_earned" id="credits_earned" readonly value="<?php echo $stud_data['credits_earned'] ?>">

                <select name="oec_choose" id="oec_choose">
                    <?php
                    foreach($fetch_oec as $oec){
                        echo("inside foreach");
                        print_r($oec);
                        echo("<option value='".$oec['course_code']."'>".$oec['course_code']." - ".$oec['course_name']."</option>");
                    }
                    ?>
                </select>
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