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
require_once "connect.php";
require "index.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini alın
    $header = $_POST["header"];
    $message = $_POST["message"];
    $footer = $_POST["footer"];
    $file = $_FILES["file"]["tmp_name"];
    $tomail = $_POST["recipient"];

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // Fetch SMTP username, password, and port from cyrmail.ayarlar
        $query = "SELECT * FROM cyrmail.ayarlar";
        $statement = $db->query($query);
        $ayarlar = $statement->fetch(PDO::FETCH_ASSOC);

        $mail->Username = $ayarlar['mail'];
        $mail->Password = $ayarlar['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $ayarlar['port'];

        // Recipients
        $mail->setFrom($ayarlar['mail'], $ayarlar['username']);
        $mail->addAddress($tomail, $usern);

        // Attachments
        if ($_FILES["file"]["error"] != UPLOAD_ERR_NO_FILE) {
            $mail->addAttachment($file);
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $header;
        $mail->Body = $message;
        $mail->AltBody = $footer;

        $mail->send();
        echo 'Mesaj başarıyla kullanıcıya ulaştırıldı!';

        // Index.php'ye yönlendirme
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        echo "Mesaj gönderilemedi! Hata: {$mail->ErrorInfo}";
    }
}
?>
