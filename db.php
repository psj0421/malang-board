<?php
// MySQL 연결 설정
// ⚠️ DB_PASS 는 MySQL에서 board_user 를 만들 때 정한 비밀번호와 같아야 해요
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_NAME = getenv('DB_NAME') ?: 'board';
$DB_USER = getenv('DB_USER') ?: 'board_user';
$DB_PASS = getenv('DB_PASSWORD') ?: '1234';

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('😿 DB에 연결하지 못했어요. db.php 의 계정 정보를 확인해 주세요.');
}

// 화면에 출력할 때 사용자가 넣은 HTML/스크립트가 실행되지 않게 바꿔 줘요 (XSS 방지)
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
