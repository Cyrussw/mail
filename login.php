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
        // Kullanıcı tarafından sağlanan giriş bilgilerini alın
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Sorguyu hazırlayın
        $query = "SELECT * FROM uyeler WHERE username = :username AND password = :password";

        // Sorguyu hazırlayın ve çalıştırın
        $statement = $db->prepare($query);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->execute();

        // Sonuçları alın
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Kullanıcıyı doğrula
        if ($result) {
            // Oturumu başlat
            session_start();

            // Kullanıcı bilgilerini oturum değişkenlerine kaydet
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            // Kullanıcı doğrulandı, ana sayfaya yönlendir
            header("Location: index.php");
            exit();
        } else {
            // Kullanıcı doğrulanmadı, hata mesajı göster
            echo "Hatalı kullanıcı adı veya şifre.";
        }
    }
} catch (PDOException $e) {
    // Hata oluştuğunda hata mesajını görüntüle
    echo "Hata: " . $e->getMessage();
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CYRMail | Giriş</title>
</head>

<body>
    <h1>Giriş Yap</h1>

    <form method="POST" action="login.php">
        <label for="username">Kullanıcı Adı:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Şifre:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Giriş Yap">
    </form>
</body>

</html>