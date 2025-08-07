<?php
include("db.php");

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = ($_GET['action'] === 'approve') ? 'approved' : 'cancelled';
    mysqli_query($conn, "UPDATE appointments SET status='$status' WHERE id=$id");
    header("Location: admin_appointments.php");
    exit();
}

$query = "SELECT * FROM appointments ORDER BY date DESC, time DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Appointments</title>
    <link rel="stylesheet" href="wellness.css" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('bac.gif') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        header {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #fff;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        nav ul li a.active {
            border-bottom: 2px solid #aeea00;
        }

        h2 {
            text-align: center;
            margin: 30px 0 10px;
            font-size: 32px;
            color: #c5e1a5;
        }

        .table-container {
            width: 95%;
            margin: auto;
            background: rgba(255, 255, 255, 0.08);
            padding: 20px;
            border-radius: 12px;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: white;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        th {
            background-color: #388e3c;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.12);
        }

        .btn {
            padding: 6px 14px;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .approve {
            background-color: #43a047;
        }

        .approve:hover {
            background-color: #2e7d32;
        }

        .cancel {
            background-color: #e53935;
        }

        .cancel:hover {
            background-color: #b71c1c;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        .no-action {
            color: #ccc;
            font-style: italic;
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
            <li><a href="admin_appointments.php" class="active">Appointment Manage</a></li>
            <li><a href="admin_users.php">Manage Users</a></li>
            <li><a href="admin_services.php">Service Manage</a></li>
        </ul>
    </nav>
</header>

<h2>Manage Appointments</h2>

<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Client Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Service</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['time'] ?></td>
            <td><?= htmlspecialchars($row['service']) ?></td>
            <td class="status"><?= $row['status'] ? ucfirst($row['status']) : 'Pending' ?></td>
            <td>
                <?php if (!isset($row['status']) || $row['status'] == 'pending') { ?>
                    <a class="btn approve" href="?action=approve&id=<?= $row['id'] ?>">Approve</a>
                    <a class="btn cancel" href="?action=cancel&id=<?= $row['id'] ?>" onclick="return confirm('Cancel this appointment?')">Cancel</a>
                <?php } else { ?>
                    <span class="no-action">No Actions</span>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
