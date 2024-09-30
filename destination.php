<!-- destinations.php -->
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Destinations</title>
</head>
<body>
    <h1>Destinations</h1>
    <a href="dashboard.php">Dashboard</a>
    <ul>
        <?php
        $sql = "SELECT * FROM destinations";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li><a href='booking.php?destination={$row['destination']}&price={$row['price']}'>{$row['destination']} - ${$row['price']}</a></li>";
            }
        } else {
            echo "<ul>";
            echo "<li>Adamawa</li>";
            echo "<li>Centre</li>";
            echo "<li>East</li>";
            echo "<li>Far North</li>";
            echo "<li>North</li>";
            echo "<li>North West</li>";
            echo "<li>South</li>";
            echo "<li>South West</li>";
            echo "<li>West</li>";
            echo "<li>Littoral</li>";
            echo "</ul>";
        }
        ?>
    </ul>
</body>
</html>