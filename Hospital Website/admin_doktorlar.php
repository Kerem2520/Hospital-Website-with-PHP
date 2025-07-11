<?php 
ob_start(); 

require_once "admin_baglanti.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doktorlar Sayfası</title> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stil.css">
    <style>
        .geri_buton {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .geri_buton:hover {
            background-color: #0056b3;
        }
        .geri_container {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="flex-container">
        <div class="form-container">
            <h2>Doktor Kayıt Formu</h2>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="ad">Ad:</label>
                    <input type="text" id="ad" name="ad" placeholder="Doktorun adını girin" required>
                </div>
                <div class="form-group">
                    <label for="soyad">Soyad:</label>
                    <input type="text" id="soyad" name="soyad" placeholder="Doktorun soyadını girin" required>
                </div>
                <div class="form-group">
                    <label for="telefon">Telefon Numarası:</label>
                    <input type="tel" id="telefon" name="telefon" placeholder="05XX XXX XXXX" pattern="05[0-9]{2} [0-9]{3} [0-9]{4}" required>
                </div>
                <div class="form-group">
                    <label for="uzmanlik">Uzmanlık Alanı:</label>
                    <input type="text" id="uzmanlik" name="uzmanlik" placeholder="Doktorun uzmanlık alanını girin" required>
                </div>
                <div class="form-group">
                    <label for="aciklama">Hakkında:</label>
                    <textarea name="hakkinda" rows="5" style="width: 100%;" placeholder="Doktor hakkında bilgi girin" required></textarea>
                </div>
                <div class="form-group">
                    <label for="resim">Resim Dosyası:</label>
                    <input type="file" id="resim" name="resim" required>
                </div>
                <button type="submit" name="ekle" class="btn">Kaydet</button>
                
            </form>
        </div>

        <?php 
        if (isset($_POST['ekle'])) {  
            $ad = $_POST["ad"];
            $soyad = $_POST["soyad"];
            $telefon = str_replace(' ', '', $_POST["telefon"]);
            $uzmanlik = $_POST["uzmanlik"];
            $hakkinda = $_POST["hakkinda"];
            $resim_adi = $_FILES["resim"]["name"];
            $hedefKlasor = "resimler/";
            $yeni_ad = $hedefKlasor . $resim_adi; 

            if (move_uploaded_file($_FILES["resim"]["tmp_name"], $yeni_ad)) {
                $ekle = mysqli_query($dbConnection, "insert into doktorlar (AD,SOYAD,TEL,ALANI,HAKKINDA,RESIM) VALUES ('$ad','$soyad','$telefon','$uzmanlik','$hakkinda','$yeni_ad')");
                
                if ($ekle) {
                    header('Location: admin_doktorlar.php');
                    exit; 
                } else {
                    echo "Bir hata oluştu: " . mysqli_error($dbConnection);
                }
            }
        }
        ?>

     
        <div class="table-container">
            <h2>Kayıtlı Bilgiler</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ad</th>
                        <th>Soyad</th>
                        <th>Telefon Numarası</th>
                        <th>Uzmanlık Alanı</th>
                        <th>Resim Yolu</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sorgu = mysqli_query($dbConnection, "SELECT * FROM doktorlar");
                    if ($sorgu) {
                        while ($satir = mysqli_fetch_assoc($sorgu)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($satir['ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['AD']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['SOYAD']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['TEL']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['ALANI']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['RESIM']) . "</td>";
                            echo "<td>
                                    <a href='admin_doktor_duzenle.php?id=" . $satir['ID'] . "' class='action-btn edit-btn' title='Düzenle'>🖉</a>
                                    <a href='admin_doktor_sil.php?id=" . $satir['ID'] . "' class='action-btn delete-btn' title='Sil' onclick='return confirm(\"Bu kaydı silmek istediğinize emin misiniz?\");'>🗑</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Kayıt bulunamadı.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php ob_end_flush();  ?>
