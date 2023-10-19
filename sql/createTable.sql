-- "Ideka"データベースが存在する場合、削除する
DROP DATABASE IF EXISTS Ideka;

-- "Ideka"データベースを作成
CREATE DATABASE Ideka;

-- "Ideka"データベースを使用
USE Ideka;

-- ここにCREATE TABLE文を挿入してください


-- userテーブル
CREATE TABLE user (
    user_id INT NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(191) NOT NULL,
    user_mail VARCHAR(191) NOT NULL,
    user_password VARCHAR(191) NOT NULL,
    user_icon VARCHAR(191) NOT NULL DEFAULT 'img/icon/default.png',
    user_intro VARCHAR(191),
    PRIMARY KEY (user_id)
);

-- addressテーブル
CREATE TABLE address (
    user_id INT NOT NULL,
    address_detail_id INT NOT NULL,
    chi_name VARCHAR(191) NOT NULL,
    kana_name VARCHAR(191) NOT NULL,
    phone_number VARCHAR(191) NOT NULL,
    post_code VARCHAR(191) NOT NULL,
    user_address VARCHAR(191) NOT NULL,
    mail_address VARCHAR(191) NOT NULL,
    PRIMARY KEY (user_id, address_detail_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

-- project_tagテーブル
CREATE TABLE project_tag (
    tag_id INT NOT NULL AUTO_INCREMENT,
    tag_name VARCHAR(191) NOT NULL,
    PRIMARY KEY (tag_id)
);

-- projectテーブル
CREATE TABLE project (
    project_id INT NOT NULL AUTO_INCREMENT,
    project_name VARCHAR(191) NOT NULL,
    project_goal_money INT NOT NULL,
    project_intro VARCHAR(191) NOT NULL,
    project_start DATE NOT NULL,
    project_end DATE NOT NULL,
    user_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (project_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (tag_id) REFERENCES project_tag(tag_id)
);

-- project_courseテーブル
CREATE TABLE project_course (
    project_id INT NOT NULL,
    project_course_detail_id INT NOT NULL,
    project_course_name VARCHAR(191) NOT NULL,
    project_course_thumbnail VARCHAR(191) NOT NULL DEFAULT 'img/project_course/default.png',
    project_course_intro VARCHAR(191) NOT NULL,
    PRIMARY KEY (project_id, project_course_detail_id),
    FOREIGN KEY (project_id) REFERENCES project(project_id)
);

-- project_supportテーブル
CREATE TABLE project_support (
    support_id INT NOT NULL AUTO_INCREMENT,
    support_method VARCHAR(191) NOT NULL,
    support_limit DATETIME NOT NULL,
    support_flag VARCHAR(191) NOT NULL,
    project_id INT NOT NULL,
    project_course_detail_id INT NOT NULL,
    user_id INT NOT NULL,
    address_detail_id INT NOT NULL,
    PRIMARY KEY (support_id),
    FOREIGN KEY (user_id, address_detail_id) REFERENCES address(user_id, address_detail_id),
    FOREIGN KEY (project_id, project_course_detail_id) REFERENCES project_course(project_id, project_course_detail_id)
);

-- project_heartテーブル
CREATE TABLE project_heart (
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    heart_time DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (project_id) REFERENCES project(project_id)
);

-- project_commentテーブル
CREATE TABLE project_comment (
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_time DATETIME NOT NULL,
    parent_comment_id INT,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (project_id) REFERENCES project(project_id)
);

-- project_introテーブル
CREATE TABLE project_intro (
    project_id INT NOT NULL,
    project_intro_detail_id INT NOT NULL,
    project_intro_flag VARCHAR(191) NOT NULL,
    project_intro_image VARCHAR(191),
    project_intro_text VARCHAR(191),
    FOREIGN KEY (project_id) REFERENCES project(project_id)
);

-- project_thumbnailテーブル
CREATE TABLE project_thumbnail (
    project_id INT NOT NULL,
    project_thumbnail_detail_id INT NOT NULL,
    project_thumbnail_image VARCHAR(191) NOT NULL,
    FOREIGN KEY (project_id) REFERENCES project(project_id)
);

-- board_commentテーブル
CREATE TABLE board_comment (
    comment_id INT NOT NULL AUTO_INCREMENT,
    comment_content VARCHAR(191) NOT NULL,
    comment_time DATETIME NOT NULL,
    parent_comment_id INT,
    user_id INT NOT NULL,
    PRIMARY KEY (comment_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (parent_comment_id) REFERENCES board_comment(comment_id)
);

-- board_heartテーブル
CREATE TABLE board_heart (
    comment_id INT NOT NULL,
    user_id INT NOT NULL,
    heart_time DATETIME NOT NULL,
    PRIMARY KEY (comment_id, user_id),
    FOREIGN KEY (comment_id) REFERENCES board_comment(comment_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);
