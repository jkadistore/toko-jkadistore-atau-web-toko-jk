<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

// ✅ KUNCI RAHASIA — JANGAN DIBAGIKAN!
$API_KEY = '0G^17sp-j#XxdGZ2,Weqzk}gY[j:2sYCYRPoa[M6QRvYcE3yZ45E99y0%D?!Pi2LJ.jilpgfl}&%W_2GS4LFD#b5,k2D-GAV[A8t(.M.)VpFA$]GKW7,le%a5IPB#u7[';

// ✅ DATA DATABASE KAMU (sudah diisi sesuai yang kita buat)
$DB_HOST = 'sql206.infinityfree.com';
$DB_USER = 'if0_42753718';
$DB_PASS = 'Zoezon1404055'; // ⚠️ Ganti dengan sandi aslimu
$DB_NAME = 'if0_42753718_jkadistore';

// ✅ Baca Header Authorization
$providedKey = '';
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $auth = trim($_SERVER['HTTP_AUTHORIZATION']);
    if (stripos($auth, 'Bearer ') === 0) {
        $providedKey = trim(substr($auth, 7));
    }
}
if ($providedKey === '' && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
    $auth = trim($_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
    if (stripos($auth, 'Bearer ') === 0) {
        $providedKey = trim(substr($auth, 7));
    }
}

// ✅ Cek keaslian kunci
if ($providedKey === '' || !hash_equals($API_KEY, $providedKey)) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error'   => 'Unauthorized',
        'message' => 'API key tidak valid.'
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// ✅ Sambung ke Database MySQL
try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    $db_status = "Terhubung ke Database";
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "Gagal sambung DB",
        'info' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// ✅ Hasil Akhir
$data = [
    'success' => true,
    'message' => '✅ API JK AdiStore Berhasil!',
    'database' => $db_status,
    'data' => [
        'nama' => 'JK AdiStore',
        'status' => 'online',
        'version' => '1.0'
    ]
];

// ✅ Kirim hasil
http_response_code(200);
echo json_encode(
    $data,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
);
?>
