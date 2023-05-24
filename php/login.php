<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the input values from the login form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Connect to the database
  $db = new mysqli('localhost', 'username', 'password', 'database_name');

  // Check for errors in database connection
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  // Prepare and execute the SQL statement to get user information
  $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the user exists in the database
  if ($result->num_rows == 1) {
    // Get the user's information from the database
    $row = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $row['password'])) {
      // Password is correct, set session variables and redirect to the home page
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      header('Location: home.php');
      exit();
    } else {
      // Password is incorrect
      $error = "Invalid password.";
    }
  } else {
    // User does not exist in the database
    $error = "Invalid username.";
  }

  // Close the database connection
  $stmt->close();
  $db->close();
}
?>