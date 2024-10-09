<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Kids Bookstore</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f0f8ff; /* Light background for a cheerful look */
      font-family: 'Comic Sans MS', cursive, sans-serif; /* Playful font */
      background-image: url('images/kids_books_background.jpg'); /* Background image */
      background-size: cover; /* Cover the entire background */
      background-position: center; /* Center the background */
      display: flex;
      align-items: center; /* Vertically center the content */
      justify-content: center; /* Horizontally center the content */
      height: 100vh; /* Full height */
      margin: 0; /* Remove default margin */
    }

    .signup-card {
      background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent white */
      border-radius: 20px; 
      padding: 40px; 
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3); 
      animation: fadeIn 0.5s forwards; 
      width: 100%; /* Full width */
      max-width: 400px; /* Max width for larger screens */
    }

    .header {
      font-size: 2.5rem; /* Increased font size */
      font-weight: bold; 
      margin-bottom: 20px; 
      color: #ff6f61; /* Color matching the theme */
      text-align: center; 
    }

    .input-field {
      margin-bottom: 20px; 
    }

    .form-control {
      border: 2px solid #ff6f61; /* Border color matching the theme */
      border-radius: 10px; /* Rounded corners */
      transition: border-color 0.3s; /* Transition for border color */
    }

    .form-control:focus {
      border-color: #c74a29; /* Darker color on focus */
      box-shadow: 0 0 5px rgba(199, 74, 41, 0.5); /* Shadow effect on focus */
    }

    .button {
      background-color: #ff6f61; 
      color: white; 
      padding: 12px 0; 
      border: none; 
      border-radius: 10px; /* Rounded corners */
      cursor: pointer; 
      transition: background-color 0.3s ease, transform 0.3s ease; 
      font-size: 1.1rem; /* Increased font size */
      font-weight: bold; /* Bold text */
    }

    .button:hover {
      background-color: #c74a29; 
      transform: scale(1.05); /* Scale up on hover */
    }

    .link {
      color: #ff6f61; /* Link color matching the theme */
      text-decoration: none; /* Remove underline */
      font-weight: bold; /* Bold text for links */
    }

    .link:hover {
      text-decoration: underline; /* Underline on hover for links */
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

<div class="signup-card">
  <div class="header">Sign Up</div>

  <?php
  // Include the database connection
  include('connection.php'); // Make sure the path is correct

  // Initialize a variable for error messages
  $error_msg = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get user inputs and sanitize them
      $username = mysqli_real_escape_string($connection, $_POST['username']);
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $password = mysqli_real_escape_string($connection, $_POST['password']);

      // Check if the username or email already exists
      $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
      $result = mysqli_query($connection, $checkQuery);
      
      if (mysqli_num_rows($result) > 0) {
          $error_msg = 'Username or email already exists. Please choose another.';
      } else {
          // Hash the password for security
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          // Insert data into the users table
          $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

          if (mysqli_query($connection, $query)) {
              // Redirect to the login page after successful registration
              header("Location: login.php");
              exit(); // Ensure no further code is executed after the redirect
          } else {
              $error_msg = "Error: " . mysqli_error($connection);
          }
      }
  }

  // Close the connection
  mysqli_close($connection);
  ?>

  <?php if ($error_msg): ?>
      <div class="alert alert-danger"><?php echo $error_msg; ?></div>
  <?php endif; ?>

  <form action="signup.php" method="POST">
    <div class="form-group input-field">
      <label for="username">Username</label>
      <input type="text" name="username" class="form-control" id="username" placeholder="Choose a username" required>
    </div>
    <div class="form-group input-field">
      <label for="email">Email address</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
    </div>
    <div class="form-group input-field">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Create a password" required>
    </div>
    <button type="submit" class="button btn-block">Sign Up</button>
  </form>
  <div class="footer-links">
    <p>Already have an account? <a href="login.php" class="link">Login</a></p>
  </div>
</div>

</body>
</html>

