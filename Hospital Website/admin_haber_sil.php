<?php 
ob_start();

require_once "admin_baglanti.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sorgu = mysqli_query($dbConnection, "DELETE FROM haberler WHERE ID = $id");

    if ($sorgu) {
       
        header("Location: admin_haberler.php?mesaj=silindi");
        exit; 
    } else {
        echo "Bir hata oluştu: " . mysqli_error($dbConnection);
    }
} else {
    echo "Geçerli bir ID belirtilmedi.";
}

ob_end_flush(); 
?>
