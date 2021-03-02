<?php
include "functions.php";

if (!checkDB(DB_NAME)) {
    createDB();
} else echo "DB exists";

if (!checkTable(TABLE_NAME)) {
    createTable();
} else echo "Table exists";

if (isset($_POST['submit'])) {
    echo "hello";
    $name = test_input($_POST['login']);
    $email = test_input($_POST['email']);
    //if (!checkUser($name, $email, TABLE_NAME)) {
        saveUser($name, $email, TABLE_NAME);
        echo $email;
        //$id = getId($email);
        echo sendEmail($email);
//        header("Location: registration.php");
    //}
}
/*$numb_users = countUsers(TABLE_NAME);

$numb_users >= 3? header("Location: master_login.php"): */
