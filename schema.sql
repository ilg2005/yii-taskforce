CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE locations
(
    id        int AUTO_INCREMENT PRIMARY KEY,
    town      VARCHAR(64),
    latitude  FLOAT,
    longitude FLOAT
);

CREATE TABLE categories
(
    id   int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(64),
    icon VARCHAR(64)
);

CREATE TABLE users
(
    id                   int AUTO_INCREMENT PRIMARY KEY,
    registration_date    TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    name                 VARCHAR(64)  NOT NULL,
    town                 VARCHAR(128) NOT NULL,
    email                VARCHAR(128) NOT NULL,
    password             VARCHAR(128) NOT NULL,
    role                 TINYINT(1) DEFAULT 0,
    latest_activity_time TIMESTAMP,
    is_favorite          boolean    DEFAULT false
);

CREATE TABLE users_profiles
(
    id          int AUTO_INCREMENT PRIMARY KEY,
    user_id     int,
    avatar_file VARCHAR(128),
    address     VARCHAR(1000),
    location_id int,
    birthday    date,
    about       TEXT,
    phone       VARCHAR(20),
    skype       VARCHAR(128),
    messenger   VARCHAR(128),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE CASCADE
);

CREATE TABLE users_settings
(
    id                int AUTO_INCREMENT PRIMARY KEY,
    user_id           int,
    new_message       TINYINT DEFAULT 1,
    actions_on_task   TINYINT DEFAULT 0,
    new_feedback      TINYINT DEFAULT 0,
    show_to_customer  TINYINT DEFAULT 1,
    hide_user_profile TINYINT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE users_categories
(
    id          int AUTO_INCREMENT PRIMARY KEY,
    user_id     int,
    category_id int,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
);

CREATE TABLE tasks
(
    id            int AUTO_INCREMENT PRIMARY KEY,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title         VARCHAR(256) NOT NULL,
    description   TEXT         NOT NULL,
    category_id   int          NOT NULL,
    status        TINYINT   DEFAULT 0,
    address       VARCHAR(256),
    location_id   int,
    budget        int UNSIGNED,
    deadline      TIMESTAMP,
    customer_id   int          NOT NULL,
    worker_id     int,
    latitude      FLOAT,
    longitude     FLOAT,
    FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE,
    FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES users (id) ON UPDATE CASCADE
);

CREATE TABLE files
(
    id       int AUTO_INCREMENT PRIMARY KEY,
    user_id  int,
    filename VARCHAR(128),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE tasks_files
(
    id      int AUTO_INCREMENT PRIMARY KEY,
    task_id int,
    file_id int,
    FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE,
    FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE
);

CREATE TABLE users_portfolio
(
    id      int AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    file_id int,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE
);

CREATE TABLE feedbacks
(
    id            int AUTO_INCREMENT PRIMARY KEY,
    task_id       int NOT NULL,
    worker_id     int NOT NULL,
    customer_id   int NOT NULL,
    rate          TINYINT DEFAULT 0,
    comment       TEXT,
    feedback_date TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES tasks (worker_id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES tasks (customer_id) ON DELETE CASCADE
);

CREATE TABLE tasks_replies
(
    id                int AUTO_INCREMENT PRIMARY KEY,
    task_id           int,
    applicant_id      int,
    applicant_price   int UNSIGNED,
    applicant_comment TEXT,
    reply_time        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_refused        TINYINT   DEFAULT 0,
    FOREIGN KEY (applicant_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE
);

CREATE TABLE correspondence
(
    id           int AUTO_INCREMENT PRIMARY KEY,
    task_id      int,
    sender_id    int,
    recipient_id int,
    message      TEXT,
    message_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES tasks (id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE profile_views
(
    id              int AUTO_INCREMENT PRIMARY KEY,
    current_user_id int,
    viewed_user_id  int,
    viewing_time    TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (current_user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (viewed_user_id) REFERENCES users (id) ON DELETE CASCADE
);

create index users_name_index
    on users (name);
create index users_town_index
    on users (town);
create unique index users_email_index
    on users (email);
create index users_registration_date_index
    on users (registration_date);
create index users_latest_activity_time_index
    on users (latest_activity_time);
create index users_role_index
    on users (role);
create index users_is_favorite_index
    on users (is_favorite);
create index user_id_index
    on users_categories (user_id);
create index category_id_index
    on users_categories (category_id);
create index task_creation_date_index
    on tasks (creation_date);
create index task_title_index
    on tasks (title);

