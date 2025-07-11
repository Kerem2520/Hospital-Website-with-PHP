<?php 

  $dbConnection = new mysqli("localhost", "root", "12345678", "hastane");

 ?>

 <?php 
    if(isset($_POST['login-button'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $dbConnection->prepare("SELECT * FROM adminler WHERE Kullanıcı_adı = ? AND Sifre = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0)
    {
      
        header("Location: admin_anasayfa.php");
        exit;
    } 
    else
    {
        echo "<script>
                alert('Kullanıcı adı veya şifre yanlış!');
                document.getElementById('username').value = '';
                document.getElementById('password').value = '';
              </script>";
             
    }
}




  ?>

 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
 
  <link rel="stylesheet" type="text/css" href="admin_login.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="login-header">
        <h2>Admin Panel</h2>
        <span class="lock-icon">🔒</span>
      </div>
      <form method="POST" action="">
        <div class="input-group">
          <label for="username">Kullanıcı Adı</label>
          <input type="text" id="username" name="username" placeholder="Kullanıcı Adınızı Girin" required>
        </div>
        <div class="input-group">
          <label for="password">Şifre</label>
          <input type="password" id="password" name="password" placeholder="Şifrenizi Girin" required>
        </div>
        <button type="submit" class="login-button" name="login-button">Giriş Yap</button>
      </form>
    </div>
  </div>
</body>
</html>
