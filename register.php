<?php include("templates/header.php");


if (!isset($_SESSION['email'])) {

    echo '<form action="registered.php" method="post">
                <h1 style="text-align: center;">Register</h1>
                <table class="registerBox">
                    <tr>
                        <td>First Name:</td>
                        <td><input type="text" name="fname" required/></td>
                    </tr>
                    <tr>
                        <td>Last Name:</td>
                        <td><input type="text" name="lname" required/></td>
                    </tr>
                    <tr>
                        <td><label for="email">E-mail:</label></td>
                        <td><input type="email" name="email" required/> </td>
                    </tr>
                    <tr>
                        <td><label for="username">Username:</label></td>
                        <td><input type="text" name="username"/></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td><input type="password" name="password"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button name="submit">Submit</button></td>
                    </tr>
                </table>
            </form>';
} else {
    echo "You are already logged in as " . $_SESSION['email'] . "<br/>" .
        "<a href='logout.php'>Log Out</a>";
}





include("templates/footer.php");