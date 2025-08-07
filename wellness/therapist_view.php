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
    <title>Therapist Dashboard - Booking Details</title>
    <link rel="stylesheet" href="wellness.css" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('therapist.gif') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            color: white;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
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
            border-bottom: 2px solid #4caf50;
        }

        .dashboard {
            width: 90%;
            margin: 50px auto;
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
        }

        th, td {
            padding: 12px;
            border: 1px solid #81c784;
            text-align: center;
            color: white;
        }

        th {
            background-color: #66bb6a;
            color: white;
        }

        td {
            background-color: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .status-approved {
            color: #81c784;
            font-weight: bold;
        }

        .status-cancelled {
            color: #ef9a9a;
            font-weight: bold;
        }

        .status-pending {
            color: #fff59d;
            font-weight: bold;
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
            <li><a href="therapist_dashboard.php">Client Details</a></li>
            <li><a href="therapist_view.php" class="active">Booking Details</a></li>
            <li><a href="therapist_reply.php">Client Query</a></li>
        </ul>
    </nav>
</header>

<div class="dashboard">
    <h2>All Client Appointments</h2>

    <table>
        <tr>
            <th>Appointment ID</th>
            <th>Client Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Service</th>
            <th>Status</th>
        </tr>

        <?php
        $sql = "SELECT * FROM appointments ORDER BY date, time";
        $result = $conn->query($sql);

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $statusClass = 'status-pending';
                if ($row['status'] === 'approved') $statusClass = 'status-approved';
                elseif ($row['status'] === 'cancelled') $statusClass = 'status-cancelled';
        ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars($row['time']) ?></td>
            <td><?= htmlspecialchars($row['service']) ?></td>
            <td class="<?= $statusClass ?>"><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php
            endwhile;
        else:
            echo "<tr><td colspan='6'>No appointments found.</td></tr>";
        endif;

        $conn->close();
        ?>
    </table>
</div>

</body>
</html>
