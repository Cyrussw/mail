<?php
session_start();

// Oturum kontrolü yap
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Oturum doğrulanmadı, giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}
?>
<?php require_once "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CYRMail | Ana Sayfa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form class="container" action="sendMail.php" method="post" enctype="multipart/form-data">
        <label for="header">Başlık</label>
        <input type="text" name="header">

        <label for="message">Mesajınız</label>
        <textarea name="message" rows="4" cols="50"></textarea>

        <label for="footer">Alt Mesaj (Opsiyonel)</label>
        <textarea name="footer" rows="2" cols="50"></textarea>

        <label for="file">Dosya Ekle</label>
        <input type="file" name="file" id="file">
        <label for="recipient">Mesaj Gönderilecek Kişi/E-Posta</label>
        <select name="recipient">
            <?php
            // Aboneleri seçmek için sorgu

            $query = "SELECT * FROM aboneler";
            $result = $db->query($query);

            // Her bir aboneyi seçenek olarak listeleme
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch()) {
                    $email = $row["mail"];
                    $usern = $row["adsoyad"];
                    echo "<option value=\"$email\">$email</option>";
                }
            }
            ?>
        </select>

        <input type="submit" value="Gönder">
    </form>
</body>

</html>