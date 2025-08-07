<?php
include("db.php");

if (isset($_POST['add'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];

    $query = "INSERT INTO users (full_name, email, password, user_type)
              VALUES ('$full_name', '$email', '$password', '$user_type')";
    mysqli_query($conn, $query);

    header("Location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
    <link rel="stylesheet" href="wellness.css">
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

        .form-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            max-width: 500px;
            margin: 60px auto;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.4);
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #c8e6c9;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #e8f5e9;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: none;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #66bb6a;
            color: white;
            border: none;
            font-weight: bold;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #43a047;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #aed581;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
            color: #c5e1a5;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">GreenLife Wellness</div>
    <nav>
        <ul>
            <li><a href="Home.html">Home</a></li>
            <li><a href="admin_users.php">Manage Users</a></li>
            <li><a href="admin_services.php">Manage Services</a></li>
            <li><a href="admin_appointments.php">Appointments</a></li>
        </ul>
    </nav>
</header>

<div class="form-card">
    <h2>Add New User</h2>
    <form method="post">
        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>User Type</label>
        <select name="user_type" required>
            <option value="">-- Select Role --</option>
            <option value="client">Client</option>
            <option value="therapist">Therapist</option>
            <option value="admin">Admin</option>
        </select>

        <input type="submit" name="add" value="Add User">
    </form>

    <a class="back-link" href="admin_users.php">← Back to Manage Users</a>
</div>

</body>
</html>
