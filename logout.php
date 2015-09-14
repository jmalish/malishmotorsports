<?php

session_start();
session_destroy();

header('Location: index.php');

include("templates/header.php");

echo "<p id='loginInfo'>You have been logged out.</p>";

include("templates/footer.php");