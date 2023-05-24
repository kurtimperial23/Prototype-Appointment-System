<?php

//check if  submit button is clicked
if (isset($_POST["submit"])) {

    //prepare database connection
            $hostNAME = "localhost";
            $hostUsername = "root";
            $hostPassword = "";
            $hostDB = "dbdentalclinic";
    
    //connect to database
            $con = mysqli_connect($hostNAME, $hostUsername, $hostPassword, $hostDB) or die("Error in Database Connection...");
                
    //get value from textfield
            $fname = $_POST['txtfname'];
            $last_name = $_POST['txtlastname'];
            $pnumber = $_POST['txtnumber'];
            $email = $_POST['txtemail'];
            $new_patient = $_POST['choice'];
            $gender = $_POST['gender'];
            $appoint_date = $_POST['txtdate'];
            $appoint_time = $_POST['txttime'];
            $service = $_POST['txtservice'];
            $comment = $_POST['txtcomment'];

    //validate the date and time format
if (!strtotime($appoint_date) || !strtotime($appoint_time)) {
        //date or time format is not valid
        echo "Invalid date or time format";
    } else {
        //date and time format is valid, convert it to the desired format
        $ap_date = date("Y-m-d", strtotime($appoint_date));
        $ap_time = date("H:i:s", strtotime($appoint_time));
    
        //prepare SQL statements to check if date and time combination exists in the database
        $check_query = "SELECT * FROM tblpatient WHERE ap_date = '$ap_date' AND ap_time = '$ap_time'";
        $check_result = mysqli_query($con, $check_query);
        
        //if the date and time combination exists, output an error message
        if (mysqli_num_rows($check_result) > 0) {
            echo "The selected date and time is already taken, please choose another time slot";
        } else {
            //prepare SQL statements to add record
            $sql = "INSERT INTO tblpatient (f_name, last_name, contact_number, email, new_patient, gender, ap_date, ap_time, service_req, comments) VALUES('$fname', '$last_name',  $pnumber, '$email', '$new_patient', '$gender', '$ap_date', '$ap_time', '$service', '$comment')";
            
            //execute insertion of records
            $result = mysqli_query($con, $sql) or die("Error in insert statement and query execution");
    
            if ($result) {
                echo "New Contact has been successfully added. Click <a href='/exampleDentalClinic'>HERE</a> to go back to the homepage.";
            }
        }
    }
}
?>