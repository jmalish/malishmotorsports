<?php
include("templates/header.php");

if ($_SESSION['role'] < 2) { // if user has a publisher or higher account, let them edit the items.
    echo "You are not authorized to view this page.";
} else {

    if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database
        if (mysql_select_db('malishmotorsports', $dbc)) {


            if (isset($_POST['deleteItem'])) { // deleting item

                $itemToDelete = $_POST['deleteItem'];

                $queryDelete = "DELETE FROM store_items WHERE shortCode = '$itemToDelete' LIMIT 1";

                if ($rDelete = mysql_query($queryDelete, $dbc)) {
                    echo $itemToDelete . " has been deleted.<br/><br/>";
                }

            } elseif (isset($_POST['createNewItem'])) { // creating new item

                echo "<form action='editItem.php' method='post'>
                            <table>
                                <input type='hidden' name='shortCode' value='newItem'/>
                                <tr><td>Item Code:</td><td><input type='text' name='newCode' style='width:200px'/></td></tr>
                                <tr><td>Name:</td><td><input type='text' name='newName' style='width:200px'/></td></tr>
                                <tr><td>Short Description:</td><td><input type='text' name='newShortDesc' style='width:200px'/></td></tr>
                                <tr><td>Long Description:</td><td><textarea name='newLongDesc' rows='4' cols='50'></textarea></td></tr>
                                <tr><td>Price:</td><td><input type='text' name='newPrice' style='width:60px'/></td></tr>
                                <tr><td></td><td><button name='editItemSubmit'>Submit</button></td></tr>
                            </table>
                        </form>";
            } elseif (isset($_POST['editItemSubmit'])) { // coming from this page to submit an edit

                if ($_POST['shortCode'] == 'newItem') {

                    $newCode = $_POST['newCode'];
                    $newName = $_POST['newName'];
                    $newShortDesc = $_POST['newShortDesc'];
                    $newLongDesc = $_POST['newLongDesc'];
                    $newPrice = $_POST['price'];

                    $updateQuery = "INSERT INTO store_items SET shortCode='$newCode', name='$newName', description_short='$newShortDesc', description_long='$newLongDesc', price='$newPrice'";

                } else {
                    $itemToEdit = $_POST['shortCode'];

                    $newCode = $_POST['newCode'];
                    $newName = $_POST['newName'];
                    $newShortDesc = $_POST['newShortDesc'];
                    $newLongDesc = $_POST['newLongDesc'];
                    $newPrice = $_POST['price'];

                    $updateQuery = "UPDATE store_items SET shortCode='$newCode', name='$newName', description_short='$newShortDesc', description_long='$newLongDesc', price='$newPrice' WHERE shortCode='$itemToEdit'";
                }

                if ($r = mysql_query($updateQuery, $dbc)) {
                    echo $newName . " updated.<br/><a href='editStore.php'>Go back</a>";
                } else {
                    mysql_error();
                }
            } elseif (isset($_POST['editItem'])) { // if we're coming from editStore.php
                $itemToEdit = $_POST['editItem'];

                $query = "SELECT * FROM store_items WHERE shortCode = '$itemToEdit'";

                if ($r = mysql_query($query, $dbc)) {
                    while ($row = mysql_fetch_array($r)) {
                        echo "<form action='editItem.php' method='post'>
                            <table>
                                <input type='hidden' name='shortCode' value='" . $row['shortCode'] . "'/>
                                <tr><td>Item Code:</td><td><input type='text' name='newCode' value='" . $row['shortCode'] . "'  style='width:200px'/></td></tr>
                                <tr><td>Name:</td><td><input type='text' name='newName' value='" . $row['name'] . "' style='width:200px'/></td></tr>
                                <tr><td>Short Description:</td><td><input type='text' name='newShortDesc' value='" . $row['description_short'] . "' style='width:200px'/></td></tr>
                                <tr><td>Long Description:</td><td><textarea name='newLongDesc' rows='4' cols='50'>" . $row['description_long'] . "</textarea></td></tr>
                                <tr><td>Price:</td><td><input type='text' name='newPrice' value='" . $row['price'] . "'  style='width:60px'/></td></tr>
                                <tr><td></td><td><button name='editItemSubmit'>Submit</button></td></tr>
                            </table>
                        </form>";

                        echo '<form action="editItem.php" method="post">
                                <br/><br/><br/>
                                <table>
                                    <tr><td style="color: red;">Deleted items are unrecoverable.</td></tr>
                                    <tr><td><button name="deleteItem" value="' . $itemToEdit . '">Delete Item</button></td></tr>
                                </table>
                        </form>';
                    }
                }
            }


        }
    } else {
        print "Unable to connect to mySQL: " . mysql_error();
    } /* end of mySQL */
}

include("templates/footer.php");