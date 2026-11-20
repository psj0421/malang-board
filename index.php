<?php
// 게시판 첫 화면: 글쓰기 폼 + 글 목록 (최신순)
require __DIR__ . '/db.php';

$posts = $pdo->query(
    'SELECT id, author, title, content, created_at FROM posts ORDER BY id DESC'
)->fetchAll();

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>🐰 말랑 게시판</title>
  <link href="https://fonts.googleapis.com/css2?family=Jua&family=Gowun+Dodum&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="wrap">
    <header>
      <h1>🐰 말랑 게시판</h1>
      <p>오늘 있었던 일을 살포시 남겨 주세요 ✨</p>
    </header>

    <?php if ($msg === 'ok'): ?>
      <p class="notice ok">글이 등록됐어요 💖</p>
    <?php elseif ($msg === 'deleted'): ?>
      <p class="notice ok">글을 지웠어요 🧹</p>
    <?php elseif ($msg === 'empty'): ?>
      <p class="notice warn">작성자, 제목, 내용을 모두 적어 주세요 🥺</p>
    <?php elseif ($msg === 'notfound'): ?>
      <p class="notice warn">찾는 글이 없어요 🥺</p>
    <?php endif; ?>

    <!-- 새 글 쓰기 -->
    <section class="card">
      <h2>✏️ 새 글 쓰기</h2>
      <form action="write.php" method="post">
        <label for="author">작성자</label>
        <input id="author" name="author" maxlength="30" placeholder="닉네임" required />

        <label for="title">제목</label>
        <input id="title" name="title" maxlength="120" placeholder="제목을 적어 주세요" required />

        <label for="content">내용</label>
        <textarea id="content" name="content" placeholder="하고 싶은 이야기를 적어 주세요" required></textarea>

        <div class="actions">
          <button type="reset" class="btn btn-gray">지우기</button>
          <button type="submit" class="btn btn-pink">글 등록 💌</button>
        </div>
      </form>
    </section>

    <!-- 최근 게시글 -->
    <section class="card">
      <h2>📋 최근 게시글 (<?= count($posts) ?>)</h2>

      <?php if (count($posts) === 0): ?>
        <div class="empty">
          <span class="bunny">🐇</span>
          아직 글이 없어요. 첫 글을 남겨 주세요!
        </div>
      <?php else: ?>
        <?php foreach ($posts as $p): ?>
          <!-- 제목을 누르면 view.php?id=글번호 로 이동해요 -->
          <a class="post" href="view.php?id=<?= (int)$p['id'] ?>">
            <h3><?= e($p['title']) ?></h3>
            <p class="meta">✍️ <?= e($p['author']) ?> · <?= e($p['created_at']) ?></p>
            <!-- 내용은 앞부분 60자만 미리 보여 줘요 -->
            <p class="preview"><?= e(mb_strimwidth($p['content'], 0, 60, '…', 'UTF-8')) ?></p>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </div>
</body>
</html>
