CREATE TABLE IF NOT EXISTS `auctions`
(
    `id`          BIGINT UNSIGNED AUTO_INCREMENT,
    `dns`         VARCHAR(126)    NOT NULL ,
    `address`     VARCHAR(60)     NOT NULL,
    `created_at`  TIMESTAMP       NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_520_ci;