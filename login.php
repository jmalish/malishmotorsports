<?php

//$correctEmail = "test@jordanmalish.com";
//$correctPassword = "thisisonlyatest";

if (!($_SERVER['REQUEST_METHOD'] == 'POST') || ($_POST["email"] == NULL) || (($_POST['password']) == NULL)) { // email or password missing

    include("templates/header.php");

    echo "<p id='loginInfo'>No email/password entered</p>";
} else {

    $email = $_POST['email'];

    if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database

        if (mysql_select_db('malishmotorsports', $dbc)) {
            $query = "SELECT * FROM users WHERE email = '" . $email . "'";

            if ($r = mysql_query($query, $dbc)) {

                while ($row = mysql_fetch_array($r)) {

                    if ($_POST['password'] != $row['password']) { // wrong username/password

                        include("templates/header.php");

                        echo "<p id='loginInfo'>Incorrect email/password</p>";

                    } elseif ($_POST['password'] == $row['password']) { // if everything is good, log the user in and create a session

                        session_start();

                        $_SESSION['email'] = $_POST['email'];
                        $_SESSION['password'] = $_POST['password'];
                        $_SESSION['loggedintime'] = time();
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['cart'] = array();

                        header('Location: index.php');

                        include('templates/header.php');

                        echo "<p id='loginInfo'>Thank you for logging in " . $_SESSION['email'] . "</p>"; // probably not needed, but just in case the header line doesn't work, give the user something to look at.

                    }
                }

                // if we've gotten here, the user has entered an email that does not exist in the database, so give them the option to register.
                include('templates/header.php');
                echo "Email not found, please try again or <a href='register.php'>register a new account</a>.";


            } else {
                echo mysql_error();
            }
        }
    } else {
        print "Unable to connect to mySQL: " . mysql_error();
    } /* end of mySQL */
}

include("templates/footer.php");



/*
if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database

    if (mysql_select_db('cms', $dbc)) {
        $query = 'SELECT * FROM users';



        if ($r = mysql_query($query, $dbc)) {
            while ($row = mysql_fetch_array($r)) {
                echo "<div class='storeItem'>
                            <img class='itemImage' src='images/store/" . $row['image'] . "' alt='" . $row['name'] . "' />
                            <p class='itemName'>" . $row['name'] . "</p>
                            <p class='itemDescriptionShort'>" . $row['description_short'] . "</p>
                            <p class='itemPrice'>$" . $row['price'] . "</p>
                            <button name='view' value='" . $row['shortCode'] . "'>View</button>
                        </div>";
            }
        }

    }
} else {
    print "Unable to connect to mySQL: " . mysql_error();
} /* end of mySQL */