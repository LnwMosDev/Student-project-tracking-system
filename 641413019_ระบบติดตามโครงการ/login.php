<?php
/*******************************************************************************
 * Invoice Management System                                               *
 *                                                                              *
 * Version: 1.0                                                                   *
 * Developer:  Abhishek Raj                                                       *
 *******************************************************************************/

include 'header.php';

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// Output any connection error
if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    $fetch = $mysqli->query("SELECT * FROM `employee` WHERE email='$email'");

    if ($fetch && $fetch->num_rows > 0) {
        $row = $fetch->fetch_assoc();
        $hashedPassword = $row['password']; // แน่ใจว่าชื่อคอลัมน์ที่เก็บรหัสผ่านถูกต้อง

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['login_email'] = $row['email'];
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    header("Location: index.php");
}


?>

<?php include 'footer.php';?>