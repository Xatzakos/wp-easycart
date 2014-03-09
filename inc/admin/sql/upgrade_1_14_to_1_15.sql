﻿;
ALTER TABLE ec_product ADD `width` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Width of the product in the default shipping unit.';
ALTER TABLE ec_product ADD `height` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Height of the product in the default shipping unit.';
ALTER TABLE ec_product ADD `length` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'Length of the product in the default shipping unit.';
ALTER TABLE ec_product ADD `trial_period_days` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Length of subscription trial period in days.';
ALTER TABLE ec_product ADD `stripe_plan_added` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Has this subscription product been added to Stripe.';
ALTER TABLE ec_product ADD `subscription_plan_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Used to group the subscriptions in a membership plan used for upgrade.';
ALTER TABLE ec_product ADD `allow_multiple_subscription_purchases` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Should this item be able to be purchased multiple times.';
ALTER TABLE ec_setting ADD `fraktjakt_customer_id` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt Customer ID.';
ALTER TABLE ec_setting ADD `fraktjakt_login_key` VARCHAR(64) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Fraktjakt Login Key.';
ALTER TABLE ec_setting ADD `fraktjakt_conversion_rate` DOUBLE(15,3) NOT NULL DEFAULT '1.000' COMMENT 'The conversion rate between your base currency and SEK.';
ALTER TABLE ec_setting ADD `fraktjakt_test_mode` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Use test mode for Fraktjakt.';
ALTER TABLE ec_order ADD `fraktjakt_order_id` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Order ID for the Fraktjakt shipment.';
ALTER TABLE ec_order ADD `fraktjakt_shipment_id` VARCHAR(20) COLLATE utf8_general_ci DEFAULT '' COMMENT 'Shipment ID for the Fraktjakt shipment.';
ALTER TABLE ec_order ADD `stripe_charge_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Stripe Charge ID if Stripe used.';
ALTER TABLE ec_order ADD `subscription_id` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'Subscription ID from the ec_subscription table if order was a subscription order.';
ALTER TABLE ec_promocode ADD `max_redemptions` INTEGER(11) NOT NULL DEFAULT '999' COMMENT 'The maximum number of times you can use this promotion code.';
ALTER TABLE ec_promocode ADD `times_redeemed` INTEGER(11) NOT NULL DEFAULT '0' COMMENT 'This is the number of times this coupon has been redeemed.';
ALTER TABLE ec_user ADD `stripe_customer_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Stripe Customer ID if subscription created with Stripe.';
ALTER TABLE ec_subscription ADD `stripe_subscription_id` VARCHAR(128) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'If subscription created with Stripe, Stripe ID here.';
ALTER TABLE ec_subscription MODIFY `last_payment_date` VARCHAR(510) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Last payment made.';
CREATE TABLE IF NOT EXISTS `ec_subscription_plan` (
  `subscription_plan_id` INTEGER(11) NOT NULL AUTO_INCREMENT COMMENT
   'Unique ID for a Subscription Plan.',
  `plan_title` VARCHAR(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT
   'Title to describe the plan of connecting subscriptions.',
  `can_downgrade` TINYINT(1) NOT NULL DEFAULT '0' COMMENT
   'Can a customer automatically downgrade their subscription plan.',
  PRIMARY KEY (`subscription_plan_id`)
) ENGINE=MyISAM 
AUTO_INCREMENT=0 CHARACTER SET'utf8' COLLATE
 'utf8_general_ci'
COMMENT=''
;
