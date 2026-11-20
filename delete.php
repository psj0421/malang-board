<?php
// 글 삭제 처리: view.php 의 삭제 버튼 → id 확인 → MySQL에서 삭제 → 목록으로
require __DIR__ . '/db.php';

// 삭제는 POST로만 받아요 (주소창에 delete.php 를 직접 쳐서 지우는 걸 막아요)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php?msg=notfound');
    exit;
}

$stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
$stmt->execute([$id]);

// rowCount() 는 실제로 지워진 줄 수예요. 0이면 이미 없던 글이에요
if ($stmt->rowCount() === 0) {
    header('Location: index.php?msg=notfound');
    exit;
}

header('Location: index.php?msg=deleted');
exit;
