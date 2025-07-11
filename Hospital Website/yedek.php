<?php 

require_once "admin_baglanti.php";
             
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Web Proje Hastanesi</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
        rel="stylesheet" />

        <script>
            document.addEventListener('DOMContentLoaded', function () {
              let multipleCardCarousel = document.querySelector("#carouselExampleControls");
          
          
              if (window.matchMedia("(min-width: 768px)").matches) {
                let carousel = new bootstrap.Carousel(multipleCardCarousel, {
                  interval: false, 
                  wrap: false, 
                });
          
          
                let carouselWidth = document.querySelector(".carousel-inner").scrollWidth;
                let cardWidth = document.querySelector(".carousel-item").offsetWidth;
                let scrollPosition = 0;
          
          
                document.querySelector("#carouselExampleControls .carousel-control-next").addEventListener("click", function () {
                  if (scrollPosition < carouselWidth - cardWidth * 4) {
                    scrollPosition += cardWidth;
                    document.querySelector("#carouselExampleControls .carousel-inner").scroll({ left: scrollPosition, behavior: 'smooth' });
                  }
                });
          
          
                document.querySelector("#carouselExampleControls .carousel-control-prev").addEventListener("click", function () {
                  if (scrollPosition > 0) {
                    scrollPosition -= cardWidth;
                    document.querySelector("#carouselExampleControls .carousel-inner").scroll({ left: scrollPosition, behavior: 'smooth' });
                  }
                });
              } else {
                multipleCardCarousel.classList.add("slide");
              }
            });
          </script>

    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/main.css">

    <style>
        header.masthead {
            background-image: url('assets/hastane.jpg');
            background-size: cover;
            background-position: center;
        }

        header.masthead .masthead-content {
            z-index: 1;
            position: relative;
        }

        header.masthead .masthead-content .masthead-heading {
            font-size: 4rem;
        }

        header.masthead .masthead-content .masthead-subheading {
            font-size: 2rem;
        }


        @media (min-width: 992px) {
            header.masthead {
                padding-top: calc(10rem + 55px);
                padding-bottom: 10rem;
            }

            header.masthead .masthead-content .masthead-heading {
                font-size: 6rem;
            }

            header.masthead .masthead-content .masthead-subheading {
                font-size: 4rem;
            }
        }

        #doctorCarousel a, .mobilll a{
            text-decoration: none;
            color: inherit;
        }

        #doctorCarousel a:hover, .mobilll a{
            color: #007bff;
        }
        .mobilll *{
            color: black;
        }
        .doctor-header {
    text-align: center;
    margin-top: 30px; 
    margin-bottom: 30px; 
}

.doctor-header h3 {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}
    </style>


</head>

<body id="page-top">

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="#page-top">WEB HASTANESİ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#dktr">Doktorlarımız</a></li>
                    <li class="nav-item"><a class="nav-link" href="#hbr">Haberler</a></li>
                    <li class="nav-item"><a class="nav-link" href="girisVekayit.php">Kayıt ol/Giriş Yap</a></li>
                    <li class="nav-item"><a class="nav-link" href="giris_kayit.php">Randevu Al</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead text-center text-white">
        <div class="masthead-content">
            <div class="container px-5">
                <h1 class="masthead-heading mb-0">40 bin kapasiteli</h1>
                <h2 class="masthead-subheading mb-5">Gelişmiş tedavi yöntemleri</h2>
            </div>
        </div>
    </header>

    <div class="doctor-header">
        <h3 id="dktr">Doktorlarımız</h3>
    </div>

      
 <?php 

$sql = "SELECT * FROM doktorlar";
 $result = $dbConnection->query($sql);

 if ($result->num_rows > 0) {
     echo '<div id="carouselExampleControls" class="carousel">';
     echo '<div class="carousel-inner slider1 slider1-inner">';

     $first = true;
     while ($row = $result->fetch_assoc()) {
         echo '<div class="carousel-item slider1-item' . ($first ? ' active' : '') . '">';
         echo '<div class="card">';
         echo '<div class="img-wrapper">';
         echo '<img src="' . $row["RESIM"] . '" class="d-block w-100" alt="' . $row["AD"] . ' ' . $row["SOYAD"] . '">';
         echo '</div>';
         echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $row["AD"] . ' ' . $row["SOYAD"] . '</h5>';
         echo '<p class="card-text">' . $row["ALANI"] . '</p>';
      #   echo '<a href="' . $row["detay_url"] . '" class="btn btn-primary">Detayları Gör</a>';
         echo '</div>';
         echo '</div>';
         echo '</div>';
         $first = false;
     }  

     echo '</div>';

     echo '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">';
    echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    echo '<span class="visually-hidden">Önceki</span>';
    echo '</button>';
    echo '<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">';
    echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
    echo '<span class="visually-hidden">Sonraki</span>';
    echo '</button>';
     echo '</div>';


 } else {
     echo "Kayıt bulunamadı.";
 }



?>
 <!-- 2. slidermiz -->   
    <div class="my-5"></div>
    
    <hr>
    <div class="doctor-header">
        <h3 id="hbr">Haberler</h3>
    </div>
    <?php
// Veritabanı bağlantısını yapalım
$dbConnection = new mysqli("localhost", "root", "12345678", "hastane");

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
        echo '<div class="carousel-item' . ($firstItem ? ' active' : '') . '" style="height: 500px;">';
        echo '<a href="detay.php?id=' . $row['ID'] . '">';
        echo '<img src="' . $row['RESIM'] . '" class="d-block w-100" alt="..." style="object-fit: cover; height: 500px;">';
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
?>



  
 

    <footer class="py-3 bg-black mb-0">
        <div class="container px-5">
            <p class="m-0 text-center text-white small">Tüm hakları saklıdır &copy; 2024</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/scripts.js"></script>

    <script>
        var multipleCardCarousel = document.querySelector(
  "#carouselExampleControls"
);
if (window.matchMedia("(min-width: 768px)").matches) {
  var carousel = new bootstrap.Carousel(multipleCardCarousel, {
    interval: false,
  });
  var carouselWidth = $(".carousel-inner")[0].scrollWidth;
  var cardWidth = $(".carousel-item").width();
  var scrollPosition = 0;
  $("#carouselExampleControls .carousel-control-next").on("click", function () {
    if (scrollPosition < carouselWidth - cardWidth * 4) {
      scrollPosition += cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
  $("#carouselExampleControls .carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
      scrollPosition -= cardWidth;
      $("#carouselExampleControls .carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
} else {
  $(multipleCardCarousel).addClass("slide");
}
    </script>

</body>

</html>
<?php 

$dbConnection->close();
             
 ?>
