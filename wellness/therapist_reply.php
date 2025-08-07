<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'therapist') {
    header("Location: login.php");
    exit();
}

$therapist_id = $_SESSION['user_id'];

if (isset($_POST['send_reply'])) {
    $query_id = $_POST['query_id'];
    $reply_text = $_POST['reply_text'];

    $stmt = $conn->prepare("UPDATE queries SET reply = ?, therapist_id = ?, status = 'responded' WHERE id = ?");
    $stmt->bind_param("sii", $reply_text, $therapist_id, $query_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Therapist Reply Panel</title>
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
            border-bottom: 2px solid #4caf50;
        }

        .container {
            width: 90%;
            margin: 40px auto;
            background-color: rgba(255, 255, 255, 0.1);
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        th, td {
            border: 1px solid #81c784;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #66bb6a;
            color: white;
        }

        td {
            background-color: rgba(255, 255, 255, 0.05);
        }

        textarea {
            width: 100%;
            height: 60px;
            margin-top: 8px;
            border-radius: 5px;
            border: 1px solid #a5d6a7;
            padding: 10px;
        }

        input[type="submit"] {
            background-color: #388e3c;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            margin-top: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2e7d32;
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
            <li><a href="therapist_view.php">Booking Details</a></li>
            <li><a href="therapist_reply.php" class="active">Client Query</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Client Queries</h2>

    <table>
        <tr>
            <th>Client</th>
            <th>Message</th>
            <th>Reply</th>
            <th>Action</th>
        </tr>

        <?php
        $query = "SELECT q.id, q.message, q.reply, u.full_name
                  FROM queries q
                  JOIN users u ON q.client_id = u.Uid
                  WHERE q.status = 'pending' OR q.therapist_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $therapist_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['message']) ?></td>
                <td><?= htmlspecialchars($row['reply'] ?? '-') ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="query_id" value="<?= $row['id'] ?>">
                        <textarea name="reply_text" required placeholder="Type your reply..."></textarea>
                        <input type="submit" name="send_reply" value="Send Reply">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
