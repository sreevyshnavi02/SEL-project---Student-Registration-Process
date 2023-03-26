<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include 'header.php'; 
            //check if the regno is valid
            $get_stud_name = mysqli_query($conn, "select sname from u_student where regno = '$_POST[regno]'");
            $stud_name = mysqli_fetch_assoc($get_stud_name);

            if(mysqli_num_rows($get_stud_name) == 0){
                echo("<script>
                            alert('Enter the correct regno');
                            window.location.href = 'student_login.php';
                    </script>");
                    // header('Location: student_login.php');
            }
            else{
                $_SESSION['regno'] = $_POST['regno'];
        ?>

        <!-- check for any updates from admin, display in scroll if any -->

        <div class="provision">
            <!-- show the student's details -->
            
            <!-- show this btn only to students belonging to 4th to 7th sem -->
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <a href = './OEC_allotment/get_session.php'><button class = 'btnn'>Pre-Registration for OEC</button></a>
            
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <!-- show this btn only to students belonging to 3rd sem (or 4th sem for lateral entry students) -->
            <a href = #><button class = 'btnn'>Pre-Registration for Honor/Minor</button></a>
            
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <a href = #><button class = 'btnn'>Course Registration</button></a>
            
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <a href="exam_regn/stu_page.php"><button class = 'btnn'>Exam Registration</button></a>
        </div>

        <?php
            }
        ?>
    </body>
</html>