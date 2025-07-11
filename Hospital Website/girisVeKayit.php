<?php 
session_start();
require_once "admin_baglanti.php";



if (isset($_GET['misafir'])) {
    $_SESSION['user_status'] = 'guest';
}

if (isset($_POST['giris'])) {
 

  $stmt = $dbConnection->prepare("SELECT * FROM hastalar WHERE MAIL = ? AND SIFRE = ?");
  $stmt->bind_param("ss", $_POST['email-login'], $_POST['password-login']);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
    if($user)
    {
        $_SESSION['id'] = $user['ID'];
        $_SESSION['userName'] = $user['AD'];
        $_SESSION['tckn'] = $user['TCKN'];
        header("Location: anasayfa.php");
        exit;
    }
    else
    {
        echo "Mail veya şifre hatalı";
        exit;
    }
  
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hastane Giriş/Kayıt Ol</title>
    <link rel="stylesheet" href="girisVeKayit.css">

</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>WEB PROJESİ HASTANESİ</h1>
            <div class="tab-buttons">
                <button id="login-tab" class="active" onclick="showLogin()">Giriş Yap</button>
                <button id="signup-tab" onclick="showSignup()">Kayıt Ol</button>
            </div>
            <div class="form-wrapper">
                <form id="login-form" method="POST" >
                    <table>
                        <tr>
                            <td><label for="email-login">E-posta</label></td>
                            <td><input type="email" id="email-login" name="email-login" placeholder="E-posta" required></td>
                        </tr>
                        <tr>
                            <td><label for="password-login">Şifre</label></td>
                            <td><input type="password" id="password-login" name="password-login" placeholder="Şifre" required></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <button type="submit" name="giris" class="btn">Giriş Yap</button>
                            </td>
                        </tr>
                    </table>
                </form>


                <form id="signup-form" action="#" method="POST" style="display: none;">
                    <table>
                        <tr>
                            <td><label for="name-signup">Ad</label></td>
                            <td><input type="text" id="name-signup" name="name-signup" placeholder="Ad" required></td>
                        </tr>
                        <tr>
                            <td><label for="surname-signup">Soyad</label></td>
                            <td><input type="text" id="surname-signup" name="surname-signup" placeholder="Soyad" required></td>
                        </tr>
                        <tr>
                            <td><label for="email-signup">E-posta</label></td>
                            <td><input type="email" id="email-signup" name="email-signup" placeholder="E-posta" required></td>
                        </tr>
                        <tr>
                            <td><label for="password-signup">Şifre</label></td>
                            <td><input type="password" id="password-signup" name="password-signup" placeholder="Şifre" required></td>
                        </tr>
                        <tr>
                            <td><label for="tckn">TC Kimlik Numarası</label></td>
                            <td><input type="text" id="tckn" name="tckn" placeholder="TC Kimlik Numarası" required></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <button type="submit" name="kaydet" class="btn">Kayıt Ol</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <?php 
                   if (isset($_POST['kaydet'])) {  
                    $signad = $_POST["name-signup"];
                    $signsoyad = $_POST["surname-signup"];
                    $signmail = $_POST["email-signup"];
                    $signpassword = $_POST["password-signup"];
                    $signtckn = $_POST["tckn"];
                    $ekle = mysqli_query($dbConnection, "insert into hastalar (AD,SOYAD,MAIL,SIFRE,TCKN) VALUES ('$signad','$signsoyad','$signmail','$signpassword','$signtckn')");
                
                    if ($ekle) {
                        header('girisVeKayit.php');
                        exit; 
                    } else {
                        echo "Bir hata oluştu: " . mysqli_error($dbConnection);
                    }
                }


                 ?>
                <div class="misafir">
                <a href="anasayfa.php?misafir=true" class="misafir_link">Misafir olarak devam et</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showLogin() {
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('signup-form').style.display = 'none';
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('signup-tab').classList.remove('active');
        }

        function showSignup() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('signup-form').style.display = 'block';
            document.getElementById('signup-tab').classList.add('active');
            document.getElementById('login-tab').classList.remove('active');
        }
    </script>
</body>
</html>
