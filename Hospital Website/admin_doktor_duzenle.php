<?php 
ob_start(); 

require_once "admin_baglanti.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    
    $sorgu = mysqli_query($dbConnection, "SELECT * FROM doktorlar WHERE ID = $id");
    $doktor = mysqli_fetch_assoc($sorgu);

    if ($doktor) {
        ?>
        <!DOCTYPE html>
        <html lang="tr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Doktor Bilgilerini Düzenle</title>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: 'Roboto', sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .form-container {
                    background: #ffffff;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                    padding: 20px;
                    width: 400px;
                }
                .form-container h2 {
                    margin-bottom: 20px;
                    font-size: 24px;
                    color: #333;
                }
                .form-group {
                    margin-bottom: 15px;
                }
                .form-group label {
                    display: block;
                    font-weight: 500;
                    color: #555;
                    margin-bottom: 5px;
                }
                .form-group input {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 14px;
                }
                .form-group input:focus {
                    outline: none;
                    border-color: #007bff;
                }
                .btn {
                    background-color: #007bff;
                    color: #fff;
                    padding: 10px 15px;
                    border: none;
                    border-radius: 4px;
                    font-size: 16px;
                    cursor: pointer;
                    width: 100%;
                }
                .btn:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="form-container">
                <h2>Doktor Bilgilerini Düzenle</h2>
                <form action="admin_doktor_duzenle.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $doktor['ID']; ?>">
                    <div class="form-group">
                        <label for="ad">Ad:</label>
                        <input type="text" id="ad" name="ad" value="<?php echo htmlspecialchars($doktor['AD']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="soyad">Soyad:</label>
                        <input type="text" id="soyad" name="soyad" value="<?php echo htmlspecialchars($doktor['SOYAD']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefon">Telefon:</label>
                        <input type="text" id="telefon" name="telefon" value="<?php echo htmlspecialchars($doktor['TEL']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="uzmanlik">Uzmanlık Alanı:</label>
                        <input type="text" id="uzmanlik" name="uzmanlik" value="<?php echo htmlspecialchars($doktor['ALANI']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hakkinda">Hakkında:</label>
                        <textarea rows="5" style="width: 100%;" name="hakkinda" required><?php echo htmlspecialchars($doktor['HAKKINDA']); ?></textarea>

                    </div>
                     <div class="form-group">
                        <label for="resim">Fotoğrafı:</label>
                        <input type="file" id="resim" name="resim" required>
                    </div>
                    <button type="submit" name="guncelle" class="btn">Bilgileri Güncelle</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Kayıt bulunamadı.";
    }
} elseif (isset($_POST['guncelle'])) {
    
    $id = intval($_POST['id']);
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $uzmanlik = $_POST['uzmanlik'];
    $hakkinda = $_POST['hakkinda'];
    $resim_adi = $_FILES["resim"]["name"];
   
    $hedefKlasor = "resimler/";
    $yeni_ad = $hedefKlasor.$resim_adi;
    move_uploaded_file($_FILES["resim"]["tmp_name"], $yeni_ad);
    
    $sorgu = mysqli_query($dbConnection, "UPDATE doktorlar SET AD = '$ad', SOYAD = '$soyad', TEL = '$telefon', ALANI = '$uzmanlik', HAKKINDA='$hakkinda',RESIM='$yeni_ad' WHERE ID = $id");

    if ($sorgu) {
        header("Location: admin_doktorlar.php?mesaj=guncellendi");
        exit;
    } else {
        echo "Bir hata oluştu: " . mysqli_error($dbConnection);
    }
} else {
    echo "Geçerli bir işlem belirtilmedi.";
}

ob_end_flush(); 
?>
