-- Additive demo-only storage. No card fields, order changes or catalog updates.
CREATE TABLE IF NOT EXISTS demo_submissions (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 reference VARCHAR(32) NOT NULL UNIQUE,
 checkout_key CHAR(64) NOT NULL UNIQUE, access_hash CHAR(64) NOT NULL,
 carrier_name VARCHAR(100) NOT NULL, plan_name VARCHAR(150) NOT NULL,
 amount_cents INT UNSIGNED NOT NULL,
 customer_name VARCHAR(150) NOT NULL, email VARCHAR(254) NOT NULL,
 customer_phone CHAR(10) NOT NULL, recharge_phone CHAR(10) NOT NULL, zip VARCHAR(10) NOT NULL,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, completed_at DATETIME NULL,
 INDEX demo_email(email), INDEX demo_created(created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT IGNORE INTO settings (`key`,`value`) VALUES ('demo_checkout_enabled','0');
