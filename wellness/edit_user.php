<?php
include("db.php");
$uid = $_GET['id'];


$result = mysqli_query($conn, "SELECT * FROM users WHERE Uid = $uid");
$user = mysqli_fetch_assoc($result);


if (isset($_POST['update'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];

    $updateQuery = "UPDATE users SET full_name='$full_name', email='$email', user_type='$user_type' WHERE Uid=$uid";
    mysqli_query($conn, $updateQuery);

    header("Location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f0f5f1;
            padding: 40px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 128, 0, 0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #2e7d32;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1b5e20;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #2e7d32;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit User</h2>
        <form method="post">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>User Type:</label>
            <select name="user_type" required>
                <option value="client" <?= $user['user_type'] == 'client' ? 'selected' : '' ?>>Client</option>
                <option value="therapist" <?= $user['user_type'] == 'therapist' ? 'selected' : '' ?>>Therapist</option>
                <option value="admin" <?= $user['user_type'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>

            <input type="submit" name="update" value="Update User">
        </form>

        <a class="back-link" href="admin_users.php">← Back to Manage Users</a>
    </div>

</body>
</html>
