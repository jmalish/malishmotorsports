<?php
include("templates/header.php");

if ($_SESSION['role'] > 1) { // if user has a publisher or higher account, let them edit the items.
    echo '<form action="editStore.php" method="post"><button name="editStore">Edit Items</button></form>';
}

echo "<p>Our classes work on a bi-weekly schedule, so oval classes are even weeks of the month, and road classes are odd weeks. Please contact us for schedule availability.</p>";

echo "<form action='viewItem.php' method='get' class='storeItems'>";

if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database

    if (mysql_select_db('malishmotorsports', $dbc)) {
        $query = 'SELECT * FROM store_items';

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

echo "</form>";

include("templates/footer.php");