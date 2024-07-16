<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/camera.css">
    <title>QRコード</title>

</head>
<body>

    <main>
    <?php
        require '../vendor/autoload.php';

        use Endroid\QrCode\QrCode;
        use Endroid\QrCode\Writer\PngWriter;

        // 指定のURL
        $url = 'https://youtu.be/oyxdKe7cj3s';

        // QRコードを生成
        $qrCode = new QrCode($url);
        $writer = new PngWriter();

        // QRコードをPNG形式で出力
        $qrCodeImage = $writer->write($qrCode)->getString();
        ?>


        <div class="chat-container">
            <h3 class="chat_user">
                <?php
                if (isset($your1) && is_array($your1) && isset($your1[0])) {
                    echo htmlspecialchars($your1[0], ENT_QUOTES, 'UTF-8');
                } else {
                    echo '拠点カメラQRコード'; // デフォルトのユーザー名
                }
                ?>
            </h3>
            <div class="chcon" id="chatContent">
                <img src="data:image/png;base64,<?php echo base64_encode($qrCodeImage); ?>" alt="QR Code" />
            </div>
        </div>

    </main>
</body>
</html>
