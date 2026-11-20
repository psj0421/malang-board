<?php
// 글 상세 보기: view.php?id=글번호
require __DIR__ . '/db.php';

// 주소창의 id 값을 숫자로 바꿔요. 숫자가 아니면 목록으로 돌려보내요
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php?msg=notfound');
    exit;
}

$stmt = $pdo->prepare('SELECT id, author, title, content, created_at FROM posts WHERE id = ?');
$stmt->execute([$id]);
$post = $stmt->fetch();

// 이미 지워졌거나 없는 번호면 목록으로
if (!$post) {
    header('Location: index.php?msg=notfound');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($post['title']) ?> - 🐰 말랑 게시판</title>
  <link href="https://fonts.googleapis.com/css2?family=Jua&family=Gowun+Dodum&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="wrap single">
    <header>
      <h1><a href="index.php">🐰 말랑 게시판</a></h1>
    </header>

    <article class="card detail">
      <h2><?= e($post['title']) ?></h2>
      <p class="meta">
        #<?= (int)$post['id'] ?> · ✍️ <?= e($post['author']) ?> · <?= e($post['created_at']) ?>
      </p>
      <p class="content"><?= e($post['content']) ?></p>

      <div class="actions">
        <a class="btn btn-mint" href="index.php">← 목록으로</a>

        <!-- 삭제는 POST로 보내요. 링크(GET)로 지우면 주소만 열어도 글이 지워질 수 있어서 위험해요 -->
        <form action="delete.php" method="post"
              onsubmit="return confirm('정말 이 글을 지울까요? 지우면 되돌릴 수 없어요.');">
          <input type="hidden" name="id" value="<?= (int)$post['id'] ?>" />
          <button type="submit" class="btn btn-gray">삭제 🗑️</button>
        </form>
      </div>
    </article>
  </div>
</body>
</html>
