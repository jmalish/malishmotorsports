<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // make sure we're getting info from a POST form
    /* start of mySQL */
    if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database
        if (mysql_select_db('malishmotorsports', $dbc)) {

            /* start of write to database */
            if (!empty($_POST['fname']) && ($_POST['lname']) && (!empty($_POST['email'])) && (!empty($_POST['username'])) && (!empty($_POST['password']))) {

                $fname = mysql_real_escape_string(trim(strip_tags($_POST['fname'])));
                $lname = mysql_real_escape_string(trim(strip_tags($_POST['lname'])));
                $email = mysql_real_escape_string(trim(strip_tags($_POST['email'])));
                $username = mysql_real_escape_string(trim(strip_tags($_POST['username'])));
                $password = mysql_real_escape_string(trim(strip_tags($_POST['password'])));



                $query = "SELECT email FROM users WHERE email = '$email'";

                if ($r = mysql_query($query, $dbc)) {

                    if (mysql_num_rows($r) == 0) { // make sure email isn't already being used
                        $query = "INSERT INTO users (email, username, password, role, first_name, last_name) VALUES ('$email', '$username', '$password', 3, '$fname', '$lname');";

                        if (@mysql_query($query,$dbc)) {

                            session_start();

                            $_SESSION['email'] = $email;
                            $_SESSION['password'] = $password;
                            $_SESSION['loggedintime'] = time();
                            $_SESSION['cart'][] = NULL;

                            include("templates/header.php");

                            echo "Thank you for registering " . $_POST['fname'];
                        } else {
                            include("templates/header.php");

                            echo mysql_error();
                        }
                    } else {
                        include("templates/header.php");

                        echo "An account already exists with that email, please login.";
                    }
                } else {
                    echo mysql_error();
                }

            } else {
                include("templates/header.php");

                echo "One of the fields was not filled out on the previous page.<br/>Please <a href='register.php'>go back</a> and try again.";
            }
            /* end of write to database */

        }
    } else {
        include("templates/header.php");

        print "Unable to connect to mySQL: " . mysql_error(); // unable to connect to database or table
    } /* end of mySQL */
} else {
    include("templates/header.php");

    echo "An error occurred, please <a href='register.php'>go back</a> and try again."; // didn't come from POST form
}


include("templates/footer.php");