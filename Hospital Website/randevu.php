<?php
session_start();
require_once "admin_baglanti.php";


$doctorQuery = $dbConnection->query("SELECT ID, AD, SOYAD FROM doktorlar");
$doktorlar = $doctorQuery->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Al</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="randevu.css">
</head>
<body>
    <div class="container">
        <h1>Randevu Al</h1>
        <form action="#" method="POST">
            <table>
                <tr>
                    <td>
                        <label for="tckn">TC Kimlik Numaranız</label>
                        <input type="text" id="tckn" name="tckn" value="<?php echo isset($_SESSION['tckn']) ? $_SESSION['tckn'] : ''; ?>" placeholder="TC Kimlik Numarası" required>
                       <!-- <input type="text" id="tckn" name="tckn" placeholder="TC Kimlik Numarası" required> -->
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="randevu-tarihi">Randevu Tarihi</label>
                        <input type="date" id="randevu-tarihi" name="randevu-tarihi" required min="<?php echo date('Y-m-d'); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="doktor">Doktor Seç</label>
                        <select id="doktor" name="doktor" required>
                            <option value="" disabled selected>Doktor Seçiniz</option>
                            <?php foreach ($doktorlar as $doktor): ?>
                                 <option value="<?php echo $doktor['AD'] . ' ' . $doktor['SOYAD']; ?>">
                                     <?php echo $doktor['AD'] . " " . $doktor['SOYAD']; ?>
                                  </option>
                           <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <button type="submit" name="randevu">Randevu Al</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php 
        
         if (isset($_POST['randevu']))
         { 
            $hasta_tckn = $_POST['tckn'];  
            $randevuTarihi = $_POST['randevu-tarihi']; 
            $doktorAdSoyad = $_POST['doktor']; 
            list($doktorAd, $doktorSoyad) = explode(' ', $doktorAdSoyad);

            $doctorQuery = $dbConnection->prepare("SELECT ID FROM doktorlar WHERE AD = ? AND SOYAD = ?");
            $doctorQuery->bind_param("ss", $doktorAd, $doktorSoyad);
            $doctorQuery->execute();
            $doctorResult = $doctorQuery->get_result();
            $doctor = $doctorResult->fetch_assoc();

            $doktorId = $doctor['ID'];

            $insertQuery = $dbConnection->prepare("INSERT INTO randevular (HASTA_TCKN, RANDEVU_TARIHI, DOKTOR_ID) VALUES (?, ?, ?)");
            $insertQuery->bind_param("ssi", $hasta_tckn, $randevuTarihi, $doktorId);
            if ($insertQuery->execute()) 
            {
                $message = "Randevunuz başarıyla kaydedildi.";
                $status = "success";
            } 
            else 
            {
                 $message = "Randevu kaydedilirken bir hata oluştu.";
                 $status = "error";
            }


         }

     ?>

     <script>
    window.onload = function() {
        var status = "<?php echo $status; ?>";
        var message = "<?php echo $message; ?>";

        if (status === "success") {
            showModal("Başarılı", message, "green");
        } else if (status === "error") {
            showModal("Hata", message, "red");
        }
    }

    function showModal(title, message, color) {
        var modal = document.createElement("div");
        modal.style.position = "fixed";
        modal.style.top = "0";
        modal.style.left = "0";
        modal.style.width = "100%";
        modal.style.height = "100%";
        modal.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
        modal.style.display = "flex";
        modal.style.justifyContent = "center";
        modal.style.alignItems = "center";

        var modalContent = document.createElement("div");
        modalContent.style.backgroundColor = "white";
        modalContent.style.padding = "20px";
        modalContent.style.borderRadius = "8px";
        modalContent.style.textAlign = "center";
        modalContent.style.border = "2px solid " + color;
        modalContent.style.boxShadow = "0 0 10px rgba(0,0,0,0.1)";

        var modalTitle = document.createElement("h2");
        modalTitle.innerText = title;
        modalTitle.style.color = color;

        var modalMessage = document.createElement("p");
        modalMessage.innerText = message;

        var closeButton = document.createElement("button");
        closeButton.innerText = "Kapat";
        closeButton.style.padding = "10px 20px";
        closeButton.style.marginTop = "20px";
        closeButton.style.backgroundColor = color;
        closeButton.style.color = "white";
        closeButton.style.border = "none";
        closeButton.style.cursor = "pointer";
        closeButton.onclick = function() {
            modal.style.display = "none";
        };

        modalContent.appendChild(modalTitle);
        modalContent.appendChild(modalMessage);
        modalContent.appendChild(closeButton);
        modal.appendChild(modalContent);

        document.body.appendChild(modal);
    }
</script>
</body>
</html>
