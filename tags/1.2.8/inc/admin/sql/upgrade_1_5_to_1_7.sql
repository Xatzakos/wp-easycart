﻿;
ALTER TABLE ec_order ADD `txn_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific TXN ID.';
ALTER TABLE ec_order ADD `edit_sequence` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence.';
ALTER TABLE ec_product ADD `list_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific List ID.';
ALTER TABLE ec_product ADD `edit_sequence` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence.';
ALTER TABLE ec_user ADD `list_id` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific List ID.';
ALTER TABLE ec_user ADD `edit_sequence` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Quickbooks Specific Edit Sequence';
ALTER TABLE ec_setting ADD `auspost_api_key` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your Australian Post API Key';
ALTER TABLE ec_setting ADD `auspost_ship_from_zip` VARCHAR(55) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Your Australian Post Ship From Postal Code';
ALTER TABLE ec_shippingrate ADD `is_auspost_based` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, the live rate system for Australian Post is used.';
ALTER TABLE ec_shippingrate MODIFY `shipping_code` VARCHAR(255) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'This is the code used for methods like UPS to determine the cost for this method.';
ALTER TABLE ec_user ADD `realauth_registered` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If selected, customer is using Realex Payments and this customer already has an account in the RealVault.';