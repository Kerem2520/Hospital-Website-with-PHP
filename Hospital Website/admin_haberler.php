<?php 
ob_start(); 

require_once "admin_baglanti.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Haberler Sayfası</title> 
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
        table {
    width: 100%; 
    table-layout: fixed; 
}

td {
    word-wrap: break-word; 
    word-break: break-word; 
    padding: 10px;
    border: 1px solid #ddd; 
}
    </style>
</head>

<body>
    <div class="flex-container">
        <div class="form-container">
            <h2>Haber Ekle</h2>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="baslik">Başlık:</label>
                    <input type="text"  name="baslik" placeholder="Haber başlığı girin" required>
                </div>
                <div class="form-group">
                    <label for="aciklama">Açıklama:</label>
                    <textarea name="aciklama" rows="5" style="width: 100%;" placeholder="Haber açıklamasını girin" required></textarea>
                </div>
                <div class="form-group">
                    <label for="resim">Resim Dosyası:</label>
                    <input type="file"  name="resim" required>
                </div>
                <button type="submit" name="ekle" class="btn">Kaydet</button>
                <a href="admin_anasayfa.php" class="geri_buton" style="margin-top: 10px">Anasayfaya Dön</a>
            </form>
        </div>

        <?php 
        if (isset($_POST['ekle'])) {  
            $baslik = $_POST["baslik"];
            $aciklama = $_POST["aciklama"];
            $resim_adi = $_FILES["resim"]["name"];
            $hedefKlasor = "resimler/";
            $yeni_ad = $hedefKlasor . $resim_adi; 

            if (move_uploaded_file($_FILES["resim"]["tmp_name"], $yeni_ad)) {
                $ekle = mysqli_query($dbConnection, "insert into haberler (BASLIK,ACIKLAMA,RESIM) VALUES ('$baslik','$aciklama','$yeni_ad')");
                
                if ($ekle) {
                    header('Location: admin_haberler.php');
                    exit; 
                } else {
                    echo "Bir hata oluştu: " . mysqli_error($dbConnection);
                }
            }
        }
        ?>

        <!-- Tablo -->
        <div class="table-container">
            <h2>Kayıtlı Bilgiler</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>Resim Yolu</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sorgu = mysqli_query($dbConnection, "SELECT * FROM haberler");
                    if ($sorgu) {
                        while ($satir = mysqli_fetch_assoc($sorgu)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($satir['ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['BASLIK']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['RESIM']) . "</td>";
                            echo "<td>
                                    <a href='admin_haber_duzenle.php?id=" . $satir['ID'] . "' class='action-btn edit-btn' title='Düzenle'>🖉</a>
                                    <a href='admin_haber_sil.php?id=" . $satir['ID'] . "' class='action-btn delete-btn' title='Sil' onclick='return confirm(\"Bu kaydı silmek istediğinize emin misiniz?\");'>🗑</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Kayıt bulunamadı.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php ob_end_flush(); ?>