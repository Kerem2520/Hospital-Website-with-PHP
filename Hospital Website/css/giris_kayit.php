<?php
session_start();
require_once "admin_baglanti.php";

// Kullanıcı giriş yaptıysa anasayfaya yönlendir
if (isset($_SESSION['kullanici'])) {
    header("Location: anasayfa.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kayıt ol formu
    if (isset($_POST['register'])) {
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $email = $_POST['email'];
        $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO kullanicilar (ad, soyad, email, sifre) VALUES ('$ad', '$soyad', '$email', '$sifre')";
        if ($dbConnection->query($sql) === TRUE) {
            echo "Kayıt başarılı. Lütfen giriş yapın.";
        } else {
            echo "Hata: " . $dbConnection->error;
        }
    }

    // Giriş yap formu
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $sifre = $_POST['sifre'];

        $sql = "SELECT * FROM kullanicilar WHERE email = '$email'";
        $result = $dbConnection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($sifre, $row['sifre'])) {
                $_SESSION['kullanici'] = $row['id']; // Kullanıcıyı oturumda sakla
                header("Location: index.php"); // Anasayfaya yönlendir
                exit();
            } else {
                echo "Yanlış şifre!";
            }
        } else {
            echo "Kullanıcı bulunamadı!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Giriş ve Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Kayıt Ol Formu -->
                <h2 class="text-center mb-4">Kayıt Ol</h2>
                <form method="POST">
                    <div class="mb-3">
                        <label for="ad" class="form-label">Ad</label>
                        <input type="text" class="form-control" id="ad" name="ad" required>
                    </div>
                    <div class="mb-3">
                        <label for="soyad" class="form-label">Soyad</label>
                        <input type="text" class="form-control" id="soyad" name="soyad" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="sifre" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="sifre" name="sifre" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Kayıt Ol</button>
                </form>
                <hr>
                <!-- Giriş Yap Formu -->
                <h2 class="text-center mb-4">Giriş Yap</h2>
                <form method="POST">
                    <div class="mb-3">
                        <label for="login_email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="login_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="login_sifre" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="login_sifre" name="sifre" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Giriş Yap</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
