<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor\autoload.php';

include "config.php";

function createDB()
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
    if (mysqli_connect_errno()) {
        echo "Error №" . mysqli_connect_errno() . ' ' . mysqli_connect_error();
        exit();
    }

    $query = "CREATE DATABASE " . DB_NAME;
    if (mysqli_query($link, $query)) {
        return true;
    } else {
        echo "Entschuldigung, etwas ist schief gelaufen " . mysqli_error($link);
    }

    mysqli_close($link);
}

function createTable()
{
    $link = connectToDB();

    if (mysqli_connect_errno()) {
        echo "Error №" . mysqli_connect_errno() . ' ' . mysqli_connect_error();
        exit();
    }

    $query = "CREATE TABLE " . TABLE_NAME . "(
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    activation INT(1) NOT NULL DEFAULT '0'
    )";

    if (mysqli_query($link, $query)) {
        return true;
    } else {
        echo "Entschuldigung, etwas ist schief gelaufen " . mysqli_error($link);
    }

    mysqli_close($link);
}


function checkDB($db_name)
{
    $link = new mysqli(DB_HOST, DB_USER, DB_PASS);

    if (mysqli_connect_errno()) {
        echo "Error №" . mysqli_connect_errno() . ' ' . mysqli_connect_error();
        exit();
    }

    $query = "SHOW DATABASES LIKE '$db_name'";

    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_all($result);

    $result ? $res = true : $res = false;
    return $res;
}

function checkTable($table_name)
{
    $link = connectToDB();

    $query = "SELECT 1 FROM " . $table_name;
    $result = mysqli_query($link, $query);

    $result ? $res = true : $res = false;

    return $res;
}

function saveUser($login, $email, $table_name)
{
    $link = connectToDB();

    $query = "INSERT INTO $table_name(login, email) VALUES ('$login', '$email')";

    $result = mysqli_query($link, $query);

    $result ? $res = "OK" : $res = 'not ok';
    return $res;
}

function countUsers($table_name)
{
    $link = connectToDB();

    $query = "SELECT COUNT(*) FROM $table_name";
    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_all($result);

    return $result[0][0];
}

function getUsers($table_name)
{
    $link = connectToDB();

    $query = "SELECT * from $table_name";

    $result = mysqli_query($link, $query);
    $res = [];

    while ($row = mysqli_fetch_assoc($result)) $res[] = $row;

    return $res;
}

function checkUser($name, $email, $table_name)
{
    $link = connectToDB();

    $query = "SELECT id from $table_name WHERE login = '$name' OR email = '$email'";

    $result = mysqli_query($link, $query);
    $res = [];
    $answ = '';
    while ($row = mysqli_fetch_assoc($result)) $res[] = $row;
    !empty($res) ? $answ = true : $answ = false;
    return $answ;
}

function getId($email)
{
    $link = connectToDB();

    $query = "SELECT id FROM" . TABLE_NAME . " WHERE email = '$email'";

    $result = mysqli_query($link, $query);
    $res = [];
    while ($row = mysqli_fetch_assoc($result)) $res[] = $row;
    return $res;
}

function sendEmail($to)
{
    /*$from       = "test@test.com";
    $mail       = new PHPMailer();
    try {
        //Server settings                    // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'localhost';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'user@example.com';                     // SMTP username
        $mail->Password   = 'secret';                              // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($to, 'Joe User');     // Add a recipient
        $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if ($mail->send())
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }*/
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->setFrom('katesolovey97@gmail.com');
    $mail->addAddress($to);
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the body.';
    if ($mail->send())
        echo 'Message has been sent';
    else echo $mail->ErrorInfo;
//    $headers = "MIME-Version: 1.0" . "\r\n";
//    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//    $headers .= "From: test@gmail.com" . "\r\n";
//    if (mail($to,"test subject","test body"))
//        echo 'Message has been sent';
//    else echo 'no';
}

function updateActivation($id)
{
    $link = connectToDB();

    $query = "UPDATE " . TABLE_NAME . " SET activation =  1 WHERE id = '$id'";

    $result = mysqli_query($link, $query);

    $result ? $res = true : $res = false;

    return $res;
}

function connectToDB()
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
        echo "Error №" . mysqli_connect_errno() . ' ' . mysqli_connect_error();
        exit();
    }
    mysqli_set_charset($link, "utf8");
    return $link;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
