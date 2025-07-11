<?php 
ob_start(); 

require_once "admin_baglanti.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Randevular Sayfası</title> 
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
        <div class="table-container">
            <h2>Randevular</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hasta Kimlik No</th>
                        <th>Randevu Tarihi</th>
                        <th>Doktor ID</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sorgu = mysqli_query($dbConnection, "SELECT * FROM randevular");
                    if ($sorgu) {
                        while ($satir = mysqli_fetch_assoc($sorgu)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($satir['ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['HASTA_TCKN']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['RANDEVU_TARIHI']) . "</td>";
                            echo "<td>" . htmlspecialchars($satir['DOKTOR_ID']) . "</td>";               
                            echo "<td>
                                    <a href='admin_randevu_sil.php?id=" . $satir['ID'] . "' class='action-btn delete-btn' title='Sil' onclick='return confirm(\"Bu kaydı silmek istediğinize emin misiniz?\");'>🗑</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Kayıt bulunamadı.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    
</body>
</html>

<?php ob_end_flush();  ?>