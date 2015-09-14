<?php
session_start();
ini_set('display_errors', 'On');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Malish Motorsports Driving School</title>
    <meta name="description" content="Assignment 3 for BMIS 410 at Liberty University"/>
    <meta name="author" content="Jordan A Malish"/>
    <meta name="keywords" content="BMIS, 410, Liberty University, Jordan, Malish, CMS, Malish Motorsports Driving School"/>
    <link rel="icon" type="image/ico" href="images/checker_flag.ico"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <div id="loginNav">


            <?php

            if (!isset($_SESSION['email'])) {
                echo '<form action="login.php" method="post">
                <table>
                    <tr>
                        <td><input type="text" name="email" placeholder="Email" /></td>
                        <td><input type="password" name="password" placeholder="Password" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: right;"><a href="register.php" style="text-align: right;">Register</a> <button>Log In</button></td>
                    </tr>
                </table>
            </form>';
            } else {
                echo '<ul>
                        <li>Welcome back ' . $_SESSION["email"] . '</li>
                        <li><a href="logout.php">Log out</a></li>
                    </ul>';
            }

            ?>


        </div> <!-- end of loginNav div -->

        <h1 class="logo">Malish Motorsports Driving School</h1>
        <div id="navBar">
            <ul id="nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="tracks.php">Track Info</a></li>
                <li><a href="cars.php">Car Info</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="store.php">Store</a></li>
                <?php
                if (isset($_SESSION['email'])) {
                    echo '<li><a href="cart.php">Cart</a></li>';
                }
                if (isset($_SESSION['role']) && ($_SESSION['role'] == 3)) {
                    echo '<li><a href="admin.php">Admin Panel</a></li>';
                }
                ?>
            </ul>
        </div> <!-- end of navBar div -->
    </div> <!-- end of header div -->

    <div id="content">