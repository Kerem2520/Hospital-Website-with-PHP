<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
     <style>
    </style>
  <body>
    
    <?php
    // Veritabanı bağlantısını yapalım
    $dbConnection = new mysqli("localhost", "root", "", "hastane");

    if ($dbConnection->connect_error) {
        die("Bağlantı hatası: " . $dbConnection->connect_error);
    }

    // Haberler tablosundan slider verilerini çekelim
    $sorgu = $dbConnection->query("SELECT * FROM haberler");

    if ($sorgu->num_rows > 0) {
        echo '<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">';
        echo '<div class="carousel-indicators">';

        for ($i = 0; $i < $sorgu->num_rows; $i++) {
            echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '" ' . ($i === 0 ? 'class="active" aria-current="true"' : '') . ' aria-label="Slide ' . ($i + 1) . '"></button>';
        }

        echo '</div>';
        echo '<div class="carousel-inner">';

        $firstItem = true;
        while ($row = $sorgu->fetch_assoc()) {
            echo '<div class="carousel-item' . ($firstItem ? ' active' : '') . '" style="height: 300px;">';
            echo '<a href="detay.php?id=' . $row['ID'] . '">';
            echo '<img src="' . $row['RESIM'] . '" class="d-block w-100" alt="...">';
            echo '</a>';
            echo '</div>';
            $firstItem = false;
        }

        echo '</div>';
        echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Önceki</span>';
        echo '</button>';
        echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Sonraki</span>';
        echo '</button>';
        echo '</div>';
    } else {
        echo "Slider verisi bulunamadı.";
    }

    $dbConnection->close();
    ?>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>