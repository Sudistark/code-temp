
<?php
require('db.php');

if (isset($_REQUEST['password'])) {

        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $trn_date = date("Y-m-d H:i:s");
        $query = "INSERT into `users` ( password, email, trn_date)
                          VALUES ( '" . md5($password) . "', '$email', '$trn_date')";
        try {
                $result = mysqli_query($con, $query); // here also too many operations on password
        } catch (Exception $e) {
                echo "Error Creating User!";
        }
        if ($result) {
                $last_id = mysqli_insert_id($con);
                echo "Congratulations! , You are the user number " . $last_id . " to join out platform  <br> you can login with your Account ID: " . $last_id;
                echo "<br> <button onclick='history.back()'>Go Back</button>";
        }
} else {
}
?>
          

