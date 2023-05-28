<?php
session_start();

// Oturum kontrolü yap
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Oturum doğrulanmadı, giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}
?>
<?php
// Veritabanı bilgilerini ayarlayın
$host = "localhost";
$dbname = "cyrmail";
$username = "root";
$password = "";

try {
    // PDO bağlantısını oluşturun
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Hata modunu ayarlayın
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POST isteğini kontrol edin
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kullanıcı tarafından sağlanan bilgileri alın
        $name = $_POST["adsoyad"];
        $mail = $_POST["mail"];

        // Veritabanına kullanıcıyı ekle
        $query = "INSERT INTO aboneler (adsoyad, mail) VALUES (:adsoyad, :mail)";
        $statement = $db->prepare($query);
        $statement->bindParam(":adsoyad", $name);
        $statement->bindParam(":mail", $mail);
        $statement->execute();

        // Başarılı bir şekilde kaydedildi mesajını göster
        echo "<p class='success-message'> Kullanıcı başarıyla oluşturuldu. </p>";

        // Formu sıfırla
        $_POST = array();
    }
} catch (PDOException $e) {
    // Hata oluştuğunda hata mesajını görüntüle
    echo "Hata: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Üye Oluşturma</title>
</head>

<body>
    <form class="container" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <h1>Üye Oluşturma</h1>
        <label for="adsoyad">İsim Soyisim:</label>
        <input type="text" name="adsoyad" required><br><br>

        <label for="mail">E-posta:</label>
        <input type="email" name="mail" required><br><br>

        <input type="submit" value="Kaydet">
    </form>
</body>

</html>