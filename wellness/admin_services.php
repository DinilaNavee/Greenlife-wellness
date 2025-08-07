<?php
include("db.php");

if (isset($_POST['add_service'])) {
    $name = $_POST['service_name'];
    $desc = $_POST['description'];

    $query = "INSERT INTO services (service_name, description) VALUES ('$name', '$desc')";
    mysqli_query($conn, $query);
    header("Location: admin_services.php");
    exit();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM services WHERE id=$id");
    header("Location: admin_services.php");
    exit();
}


$services = mysqli_query($conn, "SELECT * FROM services ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Services</title>
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
      max-width: 500px;
      margin: 20px auto;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }

    form h3 {
      text-align: center;
      color: #c8e6c9;
      margin-bottom: 20px;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.8);
    }

    input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #66bb6a;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #388e3c;
    }

    .table-container {
      width: 90%;
      margin: 40px auto;
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
      margin-top: 10px;
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

    .delete {
      background-color: #d32f2f;
    }

    .delete:hover {
      background-color: #b71c1c;
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
        <li><a href="admin_appointments.php">Appointments</a></li>
        <li><a href="admin_users.php">Manage Users</a></li>
        <li><a href="admin_services.php" class="active">Service Manage</a></li>
      </ul>
    </nav>
  </header>

  <h2>Manage Wellness Services</h2>

  <form method="post">
    <h3>Add New Service</h3>
    <input type="text" name="service_name" placeholder="Service Name" required />
    <textarea name="description" placeholder="Service Description" required></textarea>
    <input type="submit" name="add_service" value="Add Service" />
  </form>

  <div class="table-container">
    <table>
      <tr>
        <th>ID</th>
        <th>Service Name</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($services)) { ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['service_name']) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>
          <a class="btn delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this service?')">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>

</body>
</html>
