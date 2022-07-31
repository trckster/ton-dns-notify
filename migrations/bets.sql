CREATE TABLE IF NOT EXISTS `bets`
(
    `id`               BIGINT UNSIGNED AUTO_INCREMENT,
    `transaction_lt`   VARCHAR(255) NOT NULL,
    `transaction_hash` VARCHAR(255) NOT NULL,
    `dns`              VARCHAR(126) NOT NULL,
    `address`          VARCHAR(60)  NOT NULL,
    `price`            DECIMAL      NOT NULL,
    `made_at`          TIMESTAMP    NOT NULL,
    `created_at`       TIMESTAMP    NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `transaction_id` (`transaction_lt`, `transaction_hash`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_520_ci;