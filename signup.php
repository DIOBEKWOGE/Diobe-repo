
<?php

if($_SERVER['REQUEST_METHOD']== 'POST'){
  include './db_connect.php';
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM signup WHERE username = '$username'";

  $result = mysqli_query($conn, $sql);
  if($result){
    $num = mysqli_num_rows($result);
    if($num > 0){
      $user = 1;
    }else{
      $sql = "INSERT INTO signup (username, password) VALUES ('$username', '$password')";
      $result = mysqli_query($conn, $sql);

      if($result){
        header('location: signin.php');
      }else{
        die(mysqli_error($conn));
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Self WhatsApp Chat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'sans-serif';
      transition: background 0.3s, color 0.3s;
    }
    .nav {
      padding: 10px;
      background: #075e54;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      z-index: 1;
    }
    .logo {
      font-family: 'sans-serif';
      font-size: 22px;
      font-weight: bold;
      letter-spacing: 1px;
    }
    .nav-links {
      display: flex;
      gap: 15px;
    }
    .nav-links a {
      color: white;
      text-decoration: none;
      font-size: 14px;
    }
    .menu-toggle {
      display: none;
      font-size: 22px;
      cursor: pointer;
    }
    .home-page {
      /* position: relative; */
      height: 100vh;
      background: #001f3f;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      flex-direction: column;
    }
    .home-page img {
      position: relative;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.25;
    }
    .form-box {
      position: absolute;
      background: rgba(0,0,0,0.7);
      padding: 30px;
      border-radius: 10px;
      max-width: 350px;
      width: 90%;
    }
    .form-box input, .form-box button {
      margin: 8px 0;
      padding: 10px 12px;
      font-size: 14px;
      width: 90%;
      border: none;
      border-radius: 5px;
    }
    .form-box button {
      background: #075e54;
      color: white;
      cursor: pointer;
    }
    .form-box p {
      margin-top: 15px;
      font-size: 13px;
    }
    .form-box a {
      color: #34B7F1;
      text-decoration: none;
    }
    .footer {
      background: #075e54;
      color: white;
      padding: 15px;
      text-align: center;
    }
    .footer .social-icons a {
      color: white;
      margin: 0 8px;
      font-size: 18px;
      text-decoration: none;
    }

    
    @media (max-width: 600px) {
      .nav-links {
        display: none;
        flex-direction: column;
        background: #075e54;
        position: absolute;
        top: 50px;
        right: 0;
        width: 150px;
      }
      .nav-links.show {
        display: flex;
      }
      .nav-links a {
        padding: 10px;
      }
      .menu-toggle {
        display: contents;
      }
      .form-box{
        width: 70%;
      }
    }
  </style>
</head>
<body>
  <div class="nav">
    <div class="logo">Whatsapp Self Chat</div>
    <div class="menu-toggle" onclick="toggleMenu()"><i class="fa fa-bars"></i></div>
    <div class="nav-links" id="navLinks">
      <a href="signup.html" onclick="scrollToSection('home')">Home</a>
      <a href="#chat.html" onclick="goToChat()">Chat</a>
      <a href="#about" onclick="scrollToSection('about')">About</a>
    </div>
  </div>

  <div class="home-page" id="home">
    <img src="bgimage.png">
      <form class="form-box" id="signup-form" action="signup.php" method="POST">
        <h2>Sign Up</h2>
        <input type="text" name="username" id="signup-username" placeholder="New Username">
        <input type="password" name="password" id="signup-password" placeholder="New Password">
        <input type="submit" value="Create Account">
        <p>Already have an account? <a href="./signin.php">Sign In</a></p>
  </form>
    </div>

    <footer class="footer">
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p>&copy; 2025 Whatsapp Self Chat. All rights reserved.</p>
      </footer>

      <script>
        function toggleMenu() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('show');
      }
    
        function showSignUp() {
          document.getElementById('signin-form').style.display = 'none';
          document.getElementById('signup-form').style.display = 'block';
        }
    
        function showSignIn() {
          document.getElementById('signup-form').style.display = 'none';
          document.getElementById('signin-form').style.display = 'block';
        }
    
        function signIn() {
          const username = document.getElementById('signin-username').value;
          const password = document.getElementById('signin-password').value;
          if (username && password) {
            alert(`Welcome back, ${username}!`);
            goToChat();
          } else {
            alert('Please enter both username and password.');
          }
        }
    
        function signUp() {
          const username = document.getElementById('signup-username').value;
          const password = document.getElementById('signup-password').value;
          if (username && password) {
            alert(`Account created for ${username}! You can now sign in.`);
            showSignIn();
          } else {
            alert('Please fill out both fields to sign up.');
          }
        }

        function goToChat() {
      window.location.href = 'chat.html';
    }
    function scrollToSection(id) {
      const section = document.getElementById(id);
      if(section) {
        section.scrollIntoView({ behavior: 'smooth' });
      }
    }
      </script>
  

  
</body>
</html>
