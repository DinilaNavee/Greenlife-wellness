<?php
include("db.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = mysqli_real_escape_string($conn, $search); 

$query = "SELECT Uid, full_name, email, user_type FROM users
          WHERE full_name LIKE '%$search%' OR email LIKE '%$search%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Users | GreenLife Wellness</title>
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
      border-bottom: 2px solid #cddc39;
    }

    h2 {
      text-align: center;
      margin: 30px 0 10px;
      font-size: 32px;
      color: #c5e1a5;
    }

    form {
      text-align: center;
      margin-bottom: 20px;
    }

    input[type="text"] {
      padding: 10px;
      width: 250px;
      border-radius: 8px;
      border: none;
      outline: none;
      font-size: 14px;
    }

    input[type="submit"] {
      padding: 10px 20px;
      background-color: #66bb6a;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-left: 10px;
    }

    input[type="submit"]:hover {
      background-color: #388e3c;
    }

    .table-container {
      width: 95%;
      margin: auto;
      background: rgba(255, 255, 255, 0.05);
      padding: 20px;
      border-radius: 12px;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      color: white;
      margin-top: 20px;
    }

    th, td {
      padding: 14px 12px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      text-align: center;
    }

    th {
      background-color: #388e3c;
      text-transform: uppercase;
    }

    tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.03);
    }

    tr:hover {
      background-color: rgba(255, 255, 255, 0.08);
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

    .edit {
      background-color: #1976d2;
    }

    .edit:hover {
      background-color: #1565c0;
    }

    .delete {
      background-color: #d32f2f;
    }

    .delete:hover {
      background-color: #b71c1c;
    }

    .add-btn {
      background-color: #43a047;
      margin: 10px auto;
      display: inline-block;
    }

    .add-btn:hover {
      background-color: #2e7d32;
    }

    .btn-container {
      text-align: center;
      margin-top: 10px;
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
      <li><a href="admin_appointments.php">Appointment Manage</a></li>
      <li><a href="admin_users.php" class="active">Manage Users</a></li>
      <li><a href="admin_services.php">Service Manage</a></li>
    </ul>
  </nav>
</header>

<h2>Manage Users</h2>

<form method="get">
  <input type="text" name="search" placeholder="Search by name or email"
         value="<?= htmlspecialchars($search) ?>" />
  <input type="submit" value="Search" />
</form>

<div class="btn-container">
  <a href="add_user.php" class="btn add-btn">➕ Add New User</a>
</div>

<div class="table-container">
  <table>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>User Type</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['user_type']) ?></td>
        <td>
          <a class="btn edit" href="edit_user.php?id=<?= $row['Uid'] ?>">Edit</a>
          <a class="btn delete" href="delete_user.php?id=<?= $row['Uid'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

</body>
</html>
