<?php
include 'db.php';

$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];

    $stmt = $conn->prepare("INSERT INTO appointments (full_name, date, time, service) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $date, $time, $service);

    if ($stmt->execute()) {
        $status = "Appointment booked successfully!";
    } else {
        $status = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard - Book Appointment</title>
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

        .form-container {
            background-color: rgba(255, 255, 255, 0.1);
            width: 400px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(6px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #e0ffe0;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #9ccc65;
            background-color: rgba(255,255,255,0.8);
        }

        input[type="submit"] {
            background-color: rgb(236, 223, 41);
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #43a047;
        }

        .status {
            text-align: center;
            color: #c8e6c9;
            margin-top: 15px;
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
      <li><a href="client_dashboard.php" class="active">Book Appointment</a></li>
      <li><a href="client_query.php">Queries</a></li>
    </ul>
  </nav>
</header>

<div class="form-container">
    <h2>Book Appointment</h2>
    <form method="POST">
        <label for="full_name">Full Name</label>
        <input type="text" name="full_name" required>

        <label for="date">Date</label>
        <input type="date" name="date" required>

        <label for="time">Time</label>
        <input type="time" name="time" required>

        <label for="service">Service</label>
        <select name="service" required>
            <option value="">-- Select a Service --</option>
            <option value="Yoga & Meditation">Yoga & Meditation</option>
            <option value="Ayurvedic Therapy">Ayurvedic Therapy</option>
            <option value="Massage Therapy">Massage Therapy</option>
            <option value="Nutrition & Diet Consultation">Nutrition & Diet Consultation</option>
            <option value="Physiotherapy">Physiotherapy</option>
            <option value="Acupuncture">Acupuncture</option>
        </select>

        <input type="submit" value="Book Now">
    </form>

    <div class="status"><?= $status ?></div>
</div>

</body>
</html>
