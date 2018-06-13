use auth;

CREATE TABLE users
(
  user_id     VARCHAR(50)            NOT NULL
    PRIMARY KEY,
  developer   TINYINT(1) DEFAULT '0' NULL,
  first_name  VARCHAR(50)            NULL,
  last_name   VARCHAR(50)            NULL,
  email       VARCHAR(200)           NULL,
  dob         DATE                   NULL,
  github_id   INT                    NULL,
  facebook_id BIGINT                 NULL,
  google_id   BIGINT                 NULL,
  hashed_password    VARCHAR(200)    NULL,
  data        JSON                   NULL,
  created     DATETIME               NOT NULL,
  modified    DATETIME               NOT NULL,
  CONSTRAINT users_user_id_uindex
  UNIQUE (user_id),
  CONSTRAINT users_email_uindex
  UNIQUE (email),
  CONSTRAINT users_github_id_uindex
  UNIQUE (github_id),
  CONSTRAINT users_facebook_id_uindex
  UNIQUE (facebook_id),
  CONSTRAINT users_google_id_uindex
  UNIQUE (google_id)
)
  ENGINE = InnoDB;

