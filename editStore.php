<?php
include("templates/header.php");

if ($_SESSION['role'] < 2) { // if user has a publisher or higher account, let them edit the items.
    echo "You are not authorized to view this page.";
} else {


    if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database
        if (mysql_select_db('malishmotorsports', $dbc)) {

            $query = 'SELECT * FROM store_items';

            if ($r = mysql_query($query, $dbc)) {

                echo "<form action='editItem.php' method='post'>
                        <button name='createNewItem'>Add New Item</button><br/>
                        <table class='storeEdit'>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Short Description</th>
                                <th>Long Description</th>
                                <th>Price</th>
                            </tr>";


                while ($row = mysql_fetch_array($r)) {
                    echo "<tr>
                        <td class='col1'><img src='images/store/" . $row['image'] . "' alt='" . $row['name'] . "'/></td>
                        <td class='col2'>" . $row['name'] . "</td>
                        <td class='col3'>" . $row['description_short'] . "</td>
                        <td class='col4'>" . $row['description_long'] . "</td>
                        <td class='col5'>$" . $row['price'] . "</td>
                        <td class='col6'><button name='editItem' value='" . $row['shortCode'] . "'>Edit Item</button></td>
                    </tr>";
                }
                echo "</table></form>";
            }

        }
    } else {
        print "Unable to connect to mySQL: " . mysql_error();
    } /* end of mySQL */
}

include("templates/footer.php");