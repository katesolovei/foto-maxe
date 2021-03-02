<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="title">
    <form name="regForm" action="action.php" method="post" id="regForm">
        <h2><p>Melden ihnen an!</p>
            <p>Hier bitte eintragen!</p></h2>
        <div>
            <div>
                <input class="form_class input_field" type="text" placeholder="Name" name="login">
            </div>
            <div>
                <input class="form_class input_field" type="email" placeholder="Email" name="email">
            </div>
            <div>
                <input class="form_class submit_btn" type="submit" name="submit" value="Absenden">
            </div>
        </div>
    </form>
    <?php
    include "functions.php";

    $numb_users = countUsers(TABLE_NAME);

    if($numb_users >= 3) echo '<a class="master_login" href="master_login.php">Show all users</a>';
    ?>
</div>
</body>
</html>

<?php
