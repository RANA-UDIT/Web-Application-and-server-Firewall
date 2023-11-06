<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to server</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Check Service and Repair Status here</h1>
<style> h1 {color: Black;} </style>
<form method="post">
    TicketNo <input type="text" placeholder="Enter your Ticket no here.." name="search">
    Email <input type="text" placeholder="Enter your email here..." name="search2">
    <br><br>
    <button name="submit">Submit</button>
</form>
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect('localhost', 'udit', 'udit', 'web');

if (!$con) {
    die(mysqli_error($con));
}

if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $search2 = $_POST['search2'];

    // Validate user inputs
    if (empty($search) || empty($search2)) {
        echo "<h2><b>Invalid Entry! Please provide both Ticket No and Email.</b></h2>";
        header("Location: block.html");
        exit();
    } else {
        // Implement whitelisting for inputs
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $search) || !preg_match('/^[a-zA-Z0-9\s@.]+$/', $search2)) {
            echo "Invalid characters detected";
            header("Location: block.html");
        exit();
        } else {
            $search = mysqli_real_escape_string($con, $search);
            $search2 = mysqli_real_escape_string($con, $search2);

            $sql = "SELECT cstatus, device FROM status WHERE ticketno = '$search' AND email = '$search2'";
            $result = mysqli_query($con, $sql);

            if ($result) {
                if ($num = mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo '<h3><b>Current Status:</b></h3>';
                    echo '<b>Device:</b> ' . $row['device'] . '<br>';
                    echo '<b>Status:</b> ' . $row['cstatus'] . '<br>';
                } else {
                    echo "<h2><b>Incorrect Entry! Please check your Ticket No and Email.</b></h2>";
                }
            } else {
                // Redirect to "block.html" using PHP's header function
                header("Location: block.html");
                exit();
            }
        }
    }
}
?>
