<?php
include "functions.php";
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>master_login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
    <h2 class="title"><p>master_login</p></h2>
    <form method="post" action="registration.php">
        <div>
            <table class="table">
                <?php
                $users = getUsers(TABLE_NAME);
                foreach ($users as $us) {
                    echo '<tr><td class="master_login">' . $us['login'] . '</td>' . '<td class="master_login">' . $us['email'] . '</td>';
                    if ($us['activation'] == '0') {
                        echo '<td><input class="inp_image" type="image" src="img/not.png"> </td></tr>';
                    } else {
                        echo '<td><input class="inp_image" type="image" src="img/ok.png"> </td></tr>';
                    }
                }
                ?>
            </table>
                <input class="form_class submit_btn" type="submit" name="submit" value="Absenden">
        </div>
    </form>
    </body>
    </html>

<?php
