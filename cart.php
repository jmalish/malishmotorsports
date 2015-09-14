<?php
include("templates/header.php");

$cartTotal = 0.00;

if (!isset($_SESSION['email'])) { // user is not logged in

    echo "You must be logged in to view your cart.";

} else { // user is logged in
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if we get a request with post, we can assume the user is editing their cart

        if (isset($_POST['add'])) {
            array_push($_SESSION['cart'], $_POST['add']); // add item to cart
        } elseif (isset($_POST['remove'])) {
            unset($_SESSION['cart'][$_POST['remove']]);
        } elseif ((isset($_POST['empty'])) & ($_POST['empty'] == 'true')) {
            unset($_SESSION['cart']);
        }


    } // if no request is attached, user is just checking their cart, but we want to show cart contents anyways

    if (count($_SESSION['cart']) <= 0) { // cart is empty
        echo "Your cart is empty, head on over to the <a href='store.php'>store</a> page to add an item.";
    } else {

        $index = 0;

        echo "<form action='cart.php' method='post'>
                <table class='cartContents'>
                <tr>
                    <th>Item Name</th>
                    <th class='col2'>Price</th>
                </tr>";

        foreach ($_SESSION['cart'] as $item) {
            if ($dbc = mysql_connect("mysql", "jordanmalish", "phpPass94")) { // make sure we connect to the database

                if (mysql_select_db('malishmotorsports', $dbc)) {
                    $query = "SELECT * FROM store_items WHERE shortcode = '" . $item . "'";

                    if ($r = mysql_query($query, $dbc)) {
                        while ($row = mysql_fetch_array($r)) {
                            echo "<tr>
                                        <td class='col1'>" . $row['name'] . "</td>
                                        <td class='col2'>$" . $row['price'] . "</td>
                                        <td><button name='remove' value='" . $index . "'>Remove</button></td>
                                    </tr>";

                            $cartTotal += $row['price'];
                            $index += 1;
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
        } // end of foreach

        echo "<tr class='cartTotal'>
                <td>Total:</td>
                <td>$" . number_format($cartTotal, 2) . "</td>
            </tr>
            <tr><td></td><td><button name='empty' value='true'>Empty Cart</button></td></tr>
        </table>
        </form>";
    } // end of if cart is empty
} // end of login check


include("templates/footer.php");
