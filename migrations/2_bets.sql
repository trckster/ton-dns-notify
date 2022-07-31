CREATE TABLE IF NOT EXISTS `bets`
(
    `id`               BIGINT UNSIGNED AUTO_INCREMENT,
    `auction_id`       BIGINT UNSIGNED,
    `transaction_lt`   VARCHAR(255) NOT NULL,
    `transaction_hash` VARCHAR(255) NOT NULL,
    `source`           VARCHAR(60)  NOT NULL,
    `destination`      VARCHAR(60)  NOT NULL,
    `price`            DECIMAL      NOT NULL,
    `made_at`          TIMESTAMP    NOT NULL,
    `created_at`       TIMESTAMP    NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `transaction_id` (`transaction_lt`, `transaction_hash`),
    FOREIGN KEY (`auction_id`) REFERENCES `auctions` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_520_ci;