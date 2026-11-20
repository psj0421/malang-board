<?php
// 글 등록 처리: 폼 → 빈칸 확인 → MySQL 저장 → 목록으로 돌아가기
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$author  = trim($_POST['author']  ?? '');
$title   = trim($_POST['title']   ?? '');
$content = trim($_POST['content'] ?? '');

if ($author === '' || $title === '' || $content === '') {
    header('Location: index.php?msg=empty');
    exit;
}

// 테이블 길이 제한에 맞춰 자르기 (author 30자, title 120자)
$author = mb_substr($author, 0, 30);
$title  = mb_substr($title, 0, 120);

// ? 자리표시자로 값을 따로 넘기면 SQL 인젝션을 막을 수 있어요
$stmt = $pdo->prepare('INSERT INTO posts (author, title, content) VALUES (?, ?, ?)');
$stmt->execute([$author, $title, $content]);

// 저장 후 목록으로 이동 (새로고침해도 같은 글이 두 번 등록되지 않아요)
header('Location: index.php?msg=ok');
exit;
