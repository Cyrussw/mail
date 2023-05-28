<?php
$host = "localhost";
$dbname = "cyrmail";
$username = "root";
$password = "";

try {
    // PDO bağlantısını oluşturun
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Hata modunu ayarlayın
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Veritabanına bağlantı başarılı!";
} catch (PDOException $e) {
    // Hata oluştuğunda hata mesajını görüntüle
    echo "Veritabanı bağlantısı hatası: " . $e->getMessage();
}
?>
