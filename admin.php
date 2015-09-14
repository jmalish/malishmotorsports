<?php
include("templates/header.php");

if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database
    if (mysql_select_db('malishmotorsports', $dbc)) {

        $loggedInEmail = $_SESSION['email'];

        $query = "SELECT * FROM users WHERE email = '$loggedInEmail'";

        if ($r = mysql_query($query, $dbc)) {
            while ($row = mysql_fetch_array($r)) {
                if ($row['role'] == 3) { // make sure user has admin status


                    if (isset($_POST['deleteUser'])) {

                        $emailToDelete = $_POST['deleteUser'];

                        $queryDelete = "DELETE FROM users WHERE email = '$emailToDelete' LIMIT 1";

                        if ($rDelete = mysql_query($queryDelete, $dbc)) {
                            echo $emailToDelete . " has been deleted.<br/><br/>";
                        }
                    }

                    $query = "SELECT * FROM users INNER JOIN roles ON users.role = roles.id";


                    echo "<form action='editUser.php' method='post'>
                            <button name='createNewUser' value='true'>Create New User</button> <p>To delete a user, click on the 'Edit User' button.</p>
                        </form><br/>";

                    echo "<form action='editUser.php' method='post'>
                            <table class='userList'>
                            <tr>
                                <th>Email</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Role</th>
                                <th>Edit</th>
                            </tr>";
                    if ($r = mysql_query($query, $dbc)) {
                        while ($row = mysql_fetch_array($r)) {
                            echo "<tr>
                                        <td>" . $row['email'] . "</td>
                                        <td>" . $row['username'] . "</td>
                                        <td>" . $row['first_name'] . "</td>
                                        <td>" . $row['last_name'] . "</td>
                                        <td>" . $row['role_name'] . "</td>
                                        <td><button name='editUser' value='" . $row['email'] . "'>Edit User</button></td>
                                    </tr>";
                        }

                        echo "</table></form>";
                    }
                } else { // if not, block access
                    echo "You are not authorized to view this page.";
                }
            }
        } else {
            mysql_error();
        }
    } else {
        mysql_error();
    }
} else {
    print "Unable to connect to mySQL: " . mysql_error();
} /* end of mySQL */

echo "</form>";

include("templates/footer.php");