<?php
include("templates/header.php");

echo "<form action='cart.php' method='post'>";

if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database

    if (mysql_select_db('malishmotorsports', $dbc)) {
        $query = "SELECT * FROM store_items WHERE shortcode = '" . $_GET['view'] . "'";

        if ($r = mysql_query($query, $dbc)) {
            while ($row = mysql_fetch_array($r)) {
                echo "<form action='cart.php' method='post'>
                            <img class='itemImage' src='images/store/" . $row['image'] . "' alt='" . $row['name'] . "' />
                            <p class='itemName'>" . $row['name'] . "</p>
                            <p class='itemDescriptionShort'>" . $row['description_long'] . "</p>
                            <p class='itemPrice'>$" . $row['price'] . "</p>
                            <button name='add' value='" . $row['shortCode'] . "'>Add to Cart</button>
                        </form>";
            }
        } else {
            echo mysql_error();
        }
    } else {
        echo mysql_error();
    }
} else {
    print "Unable to connect to mySQL: " . mysql_error();
} /* end of mySQL */

echo "</form>";


include("templates/footer.php");
/* end of page render */