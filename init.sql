-- DB 컨테이너가 "처음" 시작될 때 한 번만 자동으로 실행돼요
-- (board 데이터베이스와 board_user 계정은 docker run 의 -e 옵션으로 자동 생성돼요)

USE board;

CREATE TABLE IF NOT EXISTS posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  author VARCHAR(30) NOT NULL,
  title VARCHAR(120) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET utf8mb4;
