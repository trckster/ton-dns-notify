CREATE TABLE IF NOT EXISTS `subscriptions`
(
    `id`         BIGINT UNSIGNED AUTO_INCREMENT,
    `chat_id`    BIGINT       NOT NULL,
    `dns`        VARCHAR(126) NOT NULL,
    `created_at` TIMESTAMP    NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_520_ci;