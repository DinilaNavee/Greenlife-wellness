<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'client') {
    header("Location: login.php");
    exit();
}

$status = "";

if (isset($_POST['submit_query'])) {
    $client_id = $_SESSION['user_id'];  
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO queries (client_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $client_id, $message);

    if ($stmt->execute()) {
        $status = "Your query has been sent to a therapist.";
    } else {
        $status = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Query</title>
    <link rel="stylesheet" href="wellness.css" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('clientdash.gif') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        header {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        nav ul li a.active {
            border-bottom: 2px solid #4caf50;
        }

        .container {
            width: 450px;
            margin: 80px auto;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(6px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
        }

        h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #81c784;
            background-color: rgba(255, 255, 255, 0.85);
            color: #333;
        }

        input[type="submit"] {
            background-color:rgb(190, 202, 19);
            color: white;
            padding: 10px;
            width: 100%;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #43a047;
        }

        .status {
            margin-top: 15px;
            text-align: center;
            color: #c8e6c9;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">GreenLife Wellness</div>
    <nav>
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="service.html">Services</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="client_dashboard.php">Book Appointment</a></li>
            <li><a href="client_query.php" class="active">Queries</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Submit a Query</h2>
    <form method="POST">
        <textarea name="message" placeholder="Type your question..." required></textarea>
        <input type="submit" name="submit_query" value="Send">
    </form>
    <div class="status"><?= $status ?></div>
</div>

</body>
</html>
