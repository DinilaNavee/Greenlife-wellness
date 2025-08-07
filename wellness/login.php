<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | GreenLife Wellness Center</title>
 <link rel="stylesheet" href="wellness.css" />
 
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #d4f8d4; 
      margin: 0;
    }

    header {
      background-color: #005e3b;
      padding: 15px 30px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-weight: bold;
      font-size: 22px;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 20px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
    }

    nav ul li a:hover,
    nav ul li a.active {
      text-decoration: underline;
    }

    .main {
      display: flex;
      justify-content: center;
      align-items: center;
      height: calc(100vh - 80px); /* full height minus header */
    }

    .container {
      display: flex;
      width: 600px;
      height: 350px;
      background: linear-gradient(135deg,rgb(6, 99, 37) 40%, #0f0f0f 40%);
      border-radius: 15px;
      box-shadow: 0 0 15pxrgb(5, 136, 92);
      overflow: hidden;
    }

    .left {
      flex: 1;
      padding: 40px 30px;
      color: white;
    }

    .left h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .left p {
      font-size: 14px;
      opacity: 0.9;
    }

    .right {
      flex: 1;
      background-color: #111;
      padding: 30px;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .right h2 {
      margin-bottom: 20px;
    }

    .right input {
      background-color: #1c1c1c;
      border: none;
      border-bottom: 2px solidrgb(5, 136, 60);
      margin-bottom: 15px;
      padding: 10px;
      color: white;
      outline: none;
      width: 100%;
    }

    .right button {
      background-color:rgb(4, 124, 40);
      border: none;
      padding: 10px;
      color: black;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    .right button:hover {
      background-color:rgb(6, 139, 77);
    }

    .right small {
      margin-top: 10px;
      display: block;
    }

    .right a {
      color: #0ed5f7;
      text-decoration: none;
    }

    .right a:hover {
      text-decoration: underline;
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
      <li><a href="login.php" class="active">Login</a></li>
      <li><a href="register.php">Register here</a></li>
    </ul>
  </nav>
</header>


<div class="main">
  <div class="container">
    <div class="left">
      <h2>WELCOME BACK!</h2>
      <p>Please login to your account. If you don’t have one, register now and join us!</p>
    </div>
    <div class="right">
      <h2>Login</h2>
      <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
      </form>
      <small>Don't have an account? <a href="register.php">Sign up</a></small>
    </div>
  </div>
</div>

<?php
include 'db.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id']   = $user['Uid'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['user_type'] = $user['user_type'];

            if ($user['user_type'] === 'client') {
                header("Location: client_query.php");
                header("Location: client_dashboard.php");
            } elseif ($user['user_type'] === 'therapist') {
                header("Location: therapist_dashboard.php");
                header("Location: therapist_view.php");
                header("Location: therapist_reply.php");
            }elseif($user['user_type'] === 'admin'){
              header("Location: admin_users.php");
              header("Location: admin_services.php");

            }
             else {
                echo "<script>alert('Unknown user type');</script>";
            }

            exit;
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
