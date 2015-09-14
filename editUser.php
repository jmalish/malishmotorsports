<?php
include("templates/header.php");



if ((isset($_POST['createNewUser'])) && ($_POST['createNewUser'] == 'true')) { // create new user
    echo '<form action="editUser.php" method="post">
                                <h1>Creating New User</h1>
                                <p>All fields must be filled.</p>
                                <table class="editUser">
                                    <tr>
                                        <td>Email: </td>
                                        <td><input type="text" name="email"/></td>
                                    </tr>
                                    <tr>
                                        <td>First Name: </td>
                                        <td><input type="text" name="fname"/></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name: </td>
                                        <td><input type="text" name="lname"/></td>
                                    </tr>
                                    <tr>
                                        <td>Username: </td>
                                        <td><input type="text" name="username"/></td>
                                    </tr>
                                    <tr>
                                        <td>Password: </td>
                                        <td><input type="text" name="password"/></td>
                                    </tr>
                                    <tr>
                                        <td>Role: </td>
                                        <td><select name="role">
                                            <option value="1">User</option>
                                            <option value="2">Publisher</option>
                                            <option value="3">Admin</option>
                                        </select></td>
                                    </tr>
                                    <tr><td></td><td><button name="createUserSubmit">Submit</button></td></tr>
                                </table></form>
                                <br/>';
} else {

    if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database


        if (isset($_POST['createUserSubmit'])) {

            $newFname = mysql_real_escape_string(trim(strip_tags($_POST['fname'])));
            $newLname = mysql_real_escape_string(trim(strip_tags($_POST['lname'])));
            $newEmail = mysql_real_escape_string(trim(strip_tags($_POST['email'])));
            $newUsername = mysql_real_escape_string(trim(strip_tags($_POST['username'])));
            $newPassword = mysql_real_escape_string(trim(strip_tags($_POST['password'])));
            $newRole = $_POST['role'];

            $query2 = "INSERT INTO users (email,username,role,first_name,last_name,password) VALUES ('$newEmail','$newUsername','$newRole','$newFname','$newLname','$newPassword')";

            if (mysql_select_db('malishmotorsports', $dbc)) {
                if ($r2 = mysql_query($query2, $dbc)) {
                    echo $newEmail . " created.";
                } else {
                    mysql_error();
                }
            }
        } else {
            if (mysql_select_db('malishmotorsports', $dbc)) {

                $emailToEdit = $_POST['editUser'];


                $query = "SELECT * FROM users INNER JOIN roles ON users.role = roles.id WHERE email='$emailToEdit'";

                if ($r = mysql_query($query, $dbc)) {
                    while ($row = mysql_fetch_array($r)) {

                        if ((isset($_POST['email'])) && (isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['username'])) && (isset($_POST['password']))) {

                            $newFname = mysql_real_escape_string(trim(strip_tags($_POST['fname'])));
                            $newLname = mysql_real_escape_string(trim(strip_tags($_POST['lname'])));
                            $newEmail = mysql_real_escape_string(trim(strip_tags($_POST['email'])));
                            $newUsername = mysql_real_escape_string(trim(strip_tags($_POST['username'])));
                            $newPassword = mysql_real_escape_string(trim(strip_tags($_POST['password'])));
                            $newRole = $_POST['role'];

                            $query2 = "UPDATE users SET email='$newEmail', username='$newUsername', password='$newPassword', role='$newRole', first_name='$newFname', last_name='$newLname' WHERE email='$emailToEdit'";

                            if ($r2 = mysql_query($query2, $dbc)) {
                                echo $emailToEdit . " updated.";
                            } else {
                                mysql_error();
                            }
                        } else { // coming from admin page
                            echo '<form action="editUser.php" method="post">
                                <h1>Editing User: ' . $emailToEdit . '</h1>
                                <input type="hidden" name="editUser" value="' . $emailToEdit . '"/>
                                <p>All fields must be filled.</p>
                                <table class="editUser">
                                    <tr>
                                        <td>Email: </td>
                                        <td><input type="text" name="email" value="' . $row['email'] . '"/></td>
                                    </tr>
                                    <tr>
                                        <td>First Name: </td>
                                        <td><input type="text" name="fname" value="' . $row['first_name'] . '"/></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name: </td>
                                        <td><input type="text" name="lname" value="' . $row['last_name'] . '"/></td>
                                    </tr>
                                    <tr>
                                        <td>Username: </td>
                                        <td><input type="text" name="username" value="' . $row['username'] . '"/></td>
                                    </tr>
                                    <tr>
                                        <td>Password: </td>
                                        <td><input type="text" name="password" value="' . $row['password'] . '"/></td>
                                    </tr>
                                    <tr>
                                        <td>Role: </td>
                                        <td><select name="role">
                                            <option value="' . $row['role'] . '" selected>' . $row['role_name'] . ' - Unchanged</option>
                                            <option value="1">User</option>
                                            <option value="2">Publisher</option>
                                            <option value="3">Admin</option>
                                        </select></td>
                                    </tr>
                                    <tr><td></td><td><button name="submit">Submit</button></td></tr>
                                </table></form>
                                <br/>';

                            echo '<form action="admin.php" method="post">
                                <br/><br/><br/>
                                <table>
                                    <tr><td style="color: red;">Deleted accounts are unrecoverable.</td></tr>
                                    <tr><td><button name="deleteUser" value="' . $emailToEdit . '">Delete User</button></td></tr>
                                </table>
                        </form>';
                        } // end of if else
                    } // end of while
                } // end of if for mysql connection check
            } else {
                mysql_error();
            } // end of other mysql check
        }
        } else {
            mysql_error();
        }
} // end

include("templates/footer.php");