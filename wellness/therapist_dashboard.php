<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'therapist') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Therapist Dashboard</title>
    <link rel="stylesheet" href="wellness.css" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('therapist.gif') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
          body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); 
            z-index: -1;
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
            border-bottom: 2px solidrgb(139, 184, 34);
        }

        .dashboard {
            width: 85%;
            margin: 60px auto;
            background-color: rgba(255, 255, 255, 0.08);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(6px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #81c784;
            text-align: left;
        }

        th {
            background-color: #66bb6a;
            color: white;
        }

        td {
            background-color: rgba(255, 255, 255, 0.08);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
    </style>
</head>
<body>

<header>
    <div class="logo">GreenLife Wellness</div>
    <nav>
        <ul>
            <li><a href="Home.html">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="service.html">Services</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="therapist_dashboard.php" class="active">Client Details</a></li>
            <li><a href="therapist_view.php">Booking Details</a></li>
            <li><a href="therapist_reply.php">Client Query</a></li>
        </ul>
    </nav>
</header>

<div class="dashboard">
    <h2>Client Details</h2>

    <table>
        <tr>
            <th>Client ID</th>
            <th>Full Name</th>
            <th>Email</th>
        </tr>

        <?php
        $sql = "SELECT Uid, full_name, email FROM users WHERE user_type = 'client'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['Uid']) ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
            </tr>
        <?php
            endwhile;
        else:
            echo "<tr><td colspan='3'>No clients found.</td></tr>";
        endif;

        $conn->close();
        ?>
    </table>
</div>

</body>
</html>
