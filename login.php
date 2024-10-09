<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Kids Bookstore</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f0f8ff;
      font-family: 'Comic Sans MS', cursive, sans-serif;
      background-image: url('images/kids_books_background.jpg');
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .login-card {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
      animation: fadeIn 0.5s forwards;
      width: 100%;
      max-width: 400px;
    }

    .header {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 20px;
      color: #ff6f61;
      text-align: center;
    }

    .input-field {
      margin-bottom: 20px;
    }

    .form-control {
      border: 2px solid #ff6f61;
      border-radius: 10px;
      transition: border-color 0.3s;
    }

    .form-control:focus {
      border-color: #c74a29;
      box-shadow: 0 0 5px rgba(199, 74, 41, 0.5);
    }

    .button {
      background-color: #ff6f61;
      color: white;
      padding: 12px 0;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
      font-size: 1.1rem;
      font-weight: bold;
    }

    .button:hover {
      background-color: #c74a29;
      transform: scale(1.05);
    }

    .link {
      color: #ff6f61;
      text-decoration: none;
      font-weight: bold;
    }

    .link:hover {
      text-decoration: underline;
    }

    .footer-links {
      text-align: center;
      margin-top: 20px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="header">Login</div>

  <?php
  // Include the database connection
  include('connection.php'); // Make sure the path is correct

  // Initialize a variable for error messages
  $error_msg = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get user inputs and sanitize them
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $password = mysqli_real_escape_string($connection, $_POST['password']);

      // Check if the email exists
      $query = "SELECT * FROM users WHERE email='$email'";
      $result = mysqli_query($connection, $query);

      if (mysqli_num_rows($result) > 0) {
          $user = mysqli_fetch_assoc($result);
          // Verify the password
          if (password_verify($password, $user['password'])) {
              // Start session and save user data (if needed)
              session_start();
              $_SESSION['user_id'] = $user['id']; // Save user ID in session
              $_SESSION['username'] = $user['username']; // Save username in session

              // Redirect to the homepage
              header("Location: homepage.php");
              exit(); // Ensure no further code is executed after the redirect
          } else {
              $error_msg = 'Invalid password. Please try again.';
          }
      } else {
          $error_msg = 'No account found with that email address.';
      }
  }

  // Close the connection
  mysqli_close($connection);
  ?>

  <?php if ($error_msg): ?>
      <div class="alert alert-danger"><?php echo $error_msg; ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="form-group input-field">
      <label for="email">Email address</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group input-field">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <button type="submit" class="button btn-block">Login</button>
  </form>
  <div class="footer-links">
    <a href="#" class="link">Forgot Password?</a> | 
    <a href="signup.php" class="link">Sign Up</a>
  </div>
</div>

</body>
</html>
