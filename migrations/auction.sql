CREATE TABLE IF NOT EXISTS `auctions`
(
    `id`          BIGINT UNSIGNED AUTO_INCREMENT,
    `address`     VARCHAR(60)     NOT NULL,
    `last_bet_id` BIGINT UNSIGNED NOT NULL,
    `created_at`  TIMESTAMP       NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`last_bet_id`) REFERENCES `bets` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_520_ci;