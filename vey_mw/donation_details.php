<?php
session_start(); // Start session

// Database connection
$servername = "localhost";
$username = "root";   // Replace with your DB username
$password = "";       // Replace with your DB password
$dbname = "donate";   // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Fetch user's donation details
$sql = "SELECT * FROM donations WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $donations = $result->fetch_all(MYSQLI_ASSOC); // Fetch all donations for the user
} else {
    $donations = [];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* Basic styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #d7e7f6, #b3d4f0);
            font-family: 'Poppins', sans-serif;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 10px 20px;
            background-color: #90caf9;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #64b5f6;
        }

        .back-link {
            margin-top: 20px;
            display: block;
            text-decoration: none;
            color: #4CAF50;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Donation Details</h2>

    <?php if (count($donations) > 0): ?>
        <table>
            <tr>
                <th>Donation ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php foreach ($donations as $donation): ?>
                <tr>
                    <td><?= isset($donation['donation_id']); ?></td>
                    <td><?= "₱ " . number_format($donation['amount'], 2); ?></td>
                    <td><?= isset($donation['donation_date']); ?></td>
                    <td><?= isset($donation['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No donations found.</p>
    <?php endif; ?>

    <a href="donation_details.php" class="btn"></a>
</div>

</body>
</html>
