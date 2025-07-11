<?php 

require_once "admin_baglanti.php";

if (isset($_GET['id'])) {
    $id = $_GET['id']; 
   
    $query = "SELECT * FROM haberler WHERE ID = ?";
    $stmt = $dbConnection->prepare($query);
    $stmt->bind_param("i", $id); 
    $stmt->execute(); 
    $result = $stmt->get_result();
    $haber = $result->fetch_assoc();


}
 ?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haber Bilgisi</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
       
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    width: 100%;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.doctor-card {
    background-color: #ffffff;
    border-radius: 16px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    width: 800px;
    overflow: hidden;
    margin-top: 20px;
}

.doctor-photo {
    width: 100%;
    height: 350px;
    overflow: hidden;
    text-align: center;
}

.doctor-photo img {
    width: 1000px;
    height: 300px;
    object-fit: cover;
    text-align: center;
}

.doctor-info {
    padding: 20px;
    background-color: #f8f8f8;
    text-align: center;
}

.doctor-name {
    font-size: 32px;
    font-weight: 700;
    color: #007bff;
    margin-bottom: 10px;
}

.doctor-specialty {
    font-size: 20px;
    font-weight: 500;
    color: #555;
    margin-bottom: 20px;
}

.doctor-description {
    padding: 20px;
    background-color: #ffffff;
}

.doctor-description h3 {
    font-size: 24px;
    font-weight: 600;
    color: #007bff;
    margin-bottom: 15px;
}

.doctor-description p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}

/* Responsive tasarım */
@media (max-width: 768px) {
    .doctor-card {
        width: 100%;
        margin: 10px;
    }

    .doctor-name {
        font-size: 28px;
    }

    .doctor-specialty {
        font-size: 18px;
    }

    .doctor-description h3 {
        font-size: 20px;
    }

    .doctor-description p {
        font-size: 14px;
    }
}

    </style>
</head>
<body>

    
        <div class="container">

            <div class="doctor-photo">
                <img src="<?php echo $haber['RESIM']; ?>" alt="Haber Fotoğrafı">
            </div>
            <div class="doctor-info">
                <h1 class="doctor-name"><?php echo $doctor['BASLIK']; ?></h1>
            </div>
            <div class="doctor-description">
                <h3>Açıklamalar: </h3>
                 <p><?php echo $haber['ACIKLAMA']; ?></p>
            </div>
        </div>
    

</body>
</html>
