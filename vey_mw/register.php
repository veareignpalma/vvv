<?php
// Database connection
$servername = "localhost";
$username = "root";       // Replace with your MySQL username
$password = "";           // Replace with your MySQL password
$dbname = "donate_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_name = mysqli_real_escape_string($conn, $_POST['donor_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $donation_amount = (float) $_POST['donation_amount'];
    $donation_date = mysqli_real_escape_string($conn, $_POST['donation_date']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // SQL query to insert data into donations table
    $sql = "INSERT INTO donations (donor_name, email, phone_number, donation_amount, donation_date, message) 
            VALUES ('$donor_name', '$email', '$phone_number', $donation_amount, '$donation_date', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Thank you for your donation! <a href='login.php'>Make another donation</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* Reset and Font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 130vh;
            background: linear-gradient(135deg, #d7e7f6, #b3d4f0); /* Pastel blue gradient */
        }
        
        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        
        h2 {
            color: #333;
            font-weight: 500;
            margin-bottom: 20px;
        }

        /* Form Fields */
        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            margin-bottom: 5px;
            border-radius: 8px;
            border: 1px solid #d1e3f0;
            font-size: 13px;
            color: #333;
            background-color: #f0f8ff;
            transition: all 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #90caf9;
            background-color: #e3f2fd;
        }

        /* Submit Button */
        .btn {
            width: 100%;
            padding: 10px;
            background: #90caf9;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn:hover {
            background: #64b5f6;
            transform: translateY(-2px);
        }

        /* Extra styling */
        .info {
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register Your Donation</h2>
        <form action="login.php" method="POST">
            <label for="donor_name">Name:</label>
            <input type="text" id="donor_name" name="donor_name" placeholder="Your full name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your email address" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Your phone number (optional)">

            <label for="donation_amount">Donation Amount (P):</label>
            <input type="number" id="donation_amount" name="donation_amount" placeholder="Amount in PHP" required>

            <label for="donation_date">Date:</label>
            <input type="date" id="donation_date" name="donation_date" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="3" placeholder="Write a message (optional)"></textarea>

            <button type="submit" class="btn">Register</button>
        </form>
        <div class="info">
            <p>Your generosity helps us make a difference!</p>
        </div>
    </div>
   
</body>
</html>
