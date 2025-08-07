<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
          background-color: #0f0f0f;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      display: flex;
      width: 600px;
      height: 400px;
      background: linear-gradient(135deg,rgb(5, 122, 54) 40%, #0f0f0f 40%);
      border-radius: 15px;
      box-shadow: 0 0 15pxrgb(7, 153, 97);
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

    .right input,
    .right select {
      background-color: #1c1c1c;
      border: none;
      border-bottom: 2px solidrgb(10, 148, 72);
      margin-bottom: 15px;
      padding: 10px;
      color: white;
      outline: none;
      width: 100%;
    }

    .right button {
      background-color:rgb(7, 156, 94);
      border: none;
      padding: 10px;
      color: black;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    .right button:hover {
      background-color:rgb(9, 138, 89);
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
    

<div class="container">
  <div class="left">
    <h2>WELCOME!</h2>
    <p>We're delighted to have you here. If you need any assistance, feel free to reach out.</p>
  </div>
  <div class="right">
    <h2>Sign up</h2>
    <form action="" method="POST">
      <input type="text" name="full_name" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      
      <select name="user_type" required>
        <option value="" disabled selected>Select User Type</option>
        <option value="client">Client</option>
        <option value="therapist">Therapist</option>
         <option value="admin">Admin</option>
      </select>
      
      <button type="submit" name="register">Sign up</button>
    </form>
    <small>Already have an account? <a href="login.php">Login</a></small>
  </div>
</div>

<?php
include 'db.php';

if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
   $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];

    $sql = "INSERT INTO users (full_name, email, password, user_type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $full_name, $email, $password, $user_type);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
