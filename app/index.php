<?php
$host = "startrek-payroll-mysql";
$db_name = $_SERVER["MYSQL_DATABASE"];
$db_username = $_SERVER["MYSQL_USER"];
$db_password = $_SERVER["MYSQL_PASSWORD"];

$conn = new mysqli($host, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
if (!isset($_POST['s'])) {
?>
    <center>
        <form action="" method="post">
            <h2>Payroll Login</h2>
            <table style="border-radius: 25px; border: 2px solid black; padding: 20px;">
                <tr>
                    <td>User</td>
                    <td><input type="text" name="user"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="OK" name="s">
                </tr>
            </table>
        </form>
    </center>
<?php
}
?>

<?php
if ($_POST) {
    $user = $_POST['user'];
    $pass = $_POST['password'];
    
    error_log("USERNAME:" . $user);
    error_log("PASSWORD:" . $pass);
    
    $sql = "SELECT username, salary FROM users WHERE username = '$user' AND password = '$pass'";
    error_log("QUERY:" . $sql);

    if ($conn->multi_query($sql)) {
        if ($result = $conn->store_result()) {
            if ($result->num_rows > 0) {
                // Si l'utilisateur existe, afficher les résultats
                echo "<center>";
                echo "<h2>Welcome, " . $user . "</h2><br>";
                echo "<table style='border-radius: 25px; border: 2px solid black;' cellspacing=30>";
                echo "<tr><th>Username</th><th>Salary</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['username'] . "</td><td>" . $row['salary'] . "</td></tr>";
                }
                echo "</table></center>";
            } else {
                // Si les identifiants sont incorrects, afficher un message d'erreur
                echo "<center><h2>Invalid username or password</h2></center>";
            }
            $result->free();
        }
    }
}
?>
