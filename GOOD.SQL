CREATE TABLE `Orders` (
	`reference` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	`order_id` varchar(64) NOT NULL,
	`source` varchar(32) NOT NULL,
	`account` varchar(64) NOT NULL,
	`total_price` DECIMAL(8, 2) UNSIGNED NOT NULL,
	`service` varchar(16) NOT NULL,
	`status` varchar(16),
	`parcel_count` tinyint UNSIGNED NOT NULL DEFAULT 1,
	`weight` smallint UNSIGNED,
	`length` smallint UNSIGNED,
	`order_message` varchar(255),
	`courier_code` varchar(8) NOT NULL DEFAULT 'N/A',
	`customer_id` int(8) UNSIGNED NOT NULL,
	`address_id` int(8) UNSIGNED NOT NULL,
	PRIMARY KEY (`reference`)
);

CREATE TABLE `Customers` (
	`id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	`first_name` varchar(32) NOT NULL,
	`last_name` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL UNIQUE,
	`telephone` varchar(32),
	`address_id` int(8) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Addresses` (
	`id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	`first_name` varchar(32) NOT NULL,
	`last_name` varchar(255) NOT NULL,
	`line_1` varchar(64) NOT NULL,
	`line_2` varchar(64),
	`line_3` varchar(64),
	`city` varchar(32) NOT NULL,
	`region` varchar(32) NOT NULL,
	`postal_code` varchar(16) NOT NULL,
	`country_code` varchar(2) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Inventory` (
	`sku` varchar(64) NOT NULL UNIQUE,
	`parent_sku` varchar(64),
	`weight` smallint UNSIGNED DEFAULT 0,
	`length` smallint UNSIGNED DEFAULT 0,
	`name` varchar(255) NOT NULL,
	`sku_is_generated` bool NOT NULL DEFAULT false,
	PRIMARY KEY (`sku`)
);

CREATE TABLE `Orders_Products` (
	`order_reference` int(8) UNSIGNED NOT NULL,
	`order_item_id` int(8) UNSIGNED NOT NULL
);

CREATE TABLE `InventoryProperties` (
	`sku` varchar(64) NOT NULL,
	`name` varchar(64) NOT NULL,
	`value` varchar(64) NOT NULL,
	`source` varchar(32),
	`account` varchar(64)
);

CREATE TABLE `InventoryExternals` (
	`sku` varchar(64) NOT NULL,
	`price` DECIMAL(8, 2) UNSIGNED NOT NULL,
	`id` varchar(64) NOT NULL,
	`sales` int UNSIGNED NOT NULL DEFAULT 0,
	`source` varchar(32) NOT NULL,
	`account` varchar(64) NOT NULL
);

CREATE TABLE `InventoryCategories` (
	`sku` varchar(64) NOT NULL,
	`category` varchar(64) NOT NULL,
	`source` varchar(32),
	`account` varchar(64)
);

CREATE TABLE `OrderTime` (
	`order_reference` int(8) UNSIGNED NOT NULL,
	`time_placed` DATETIME NOT NULL,
	`time_retrieved` DATETIME NOT NULL,
	`time_dispatched` DATETIME,
	`time_last_status` DATETIME,
	`time_delivered` DATETIME,
	`time_expected` DATETIME,
	PRIMARY KEY (`order_reference`)
);

CREATE TABLE `Raw` (
	`id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	`order_reference` int(8) UNSIGNED,
	`sku` varchar(64) NOT NULL,
	`path` varchar(255) NOT NULL UNIQUE,
	PRIMARY KEY (`id`)
);

CREATE TABLE `Tracking` (
	`order_reference` int(8) UNSIGNED NOT NULL,
	`tracking_number` varchar(64) NOT NULL UNIQUE
);

CREATE TABLE `OrderProperties` (
	`order_reference` int(8) UNSIGNED NOT NULL,
	`name` varchar(64) NOT NULL,
	`value` varchar(64) NOT NULL
);

CREATE TABLE `Couriers` (
	`code` varchar(8) NOT NULL DEFAULT 'N/A',
	`name` varchar(32) NOT NULL UNIQUE DEFAULT 'Other Courier',
	`max_weight` smallint UNSIGNED,
	`max_length` smallint UNSIGNED,
	`split_weight` smallint UNSIGNED,
	`min_order_value` DECIMAL(8, 2) UNSIGNED,
	`max_order_value` DECIMAL(8, 2) UNSIGNED,
	`service_cost` DECIMAL(8, 2) UNSIGNED,
	`available_services` varchar(128),
	`integrated` bool NOT NULL DEFAULT false,
	`international` bool NOT NULL DEFAULT false,
	`recorded` bool NOT NULL DEFAULT false,
	PRIMARY KEY (`code`)
);

CREATE TABLE `Products` (
	`order_item_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	`sku` varchar(64) NOT NULL UNIQUE,
	`id` varchar(64) NOT NULL,
	`image_url` varchar(128) NOT NULL,
	`name` varchar(255) NOT NULL,
	`price` DECIMAL(8, 2) UNSIGNED NOT NULL,
	`shipping` DECIMAL(8, 2) UNSIGNED NOT NULL,
	`quantity` smallint UNSIGNED NOT NULL DEFAULT 1,
	PRIMARY KEY (`order_item_id`)
);

ALTER TABLE `Orders` AUTO_INCREMENT=10000000;
ALTER TABLE `Customers` AUTO_INCREMENT=10000000;
ALTER TABLE `Addresses` AUTO_INCREMENT=10000000;
ALTER TABLE `Products` AUTO_INCREMENT=10000000;

ALTER TABLE `Orders` ADD CONSTRAINT `Orders_fk0` FOREIGN KEY (`courier_code`) REFERENCES `Couriers`(`code`);

ALTER TABLE `Orders` ADD CONSTRAINT `Orders_fk1` FOREIGN KEY (`customer_id`) REFERENCES `Customers`(`id`);

ALTER TABLE `Orders` ADD CONSTRAINT `Orders_fk2` FOREIGN KEY (`address_id`) REFERENCES `Addresses`(`id`);

ALTER TABLE `Customers` ADD CONSTRAINT `Customers_fk0` FOREIGN KEY (`address_id`) REFERENCES `Addresses`(`id`);

ALTER TABLE `Orders_Products` ADD CONSTRAINT `Orders_Products_fk0` FOREIGN KEY (`order_reference`) REFERENCES `Orders`(`reference`);

ALTER TABLE `Orders_Products` ADD CONSTRAINT `Orders_Products_fk1` FOREIGN KEY (`order_item_id`) REFERENCES `Products`(`order_item_id`);

ALTER TABLE `InventoryProperties` ADD CONSTRAINT `InventoryProperties_fk0` FOREIGN KEY (`sku`) REFERENCES `Inventory`(`sku`);

ALTER TABLE `InventoryExternals` ADD CONSTRAINT `InventoryExternals_fk0` FOREIGN KEY (`sku`) REFERENCES `Inventory`(`sku`);

ALTER TABLE `InventoryCategories` ADD CONSTRAINT `InventoryCategories_fk0` FOREIGN KEY (`sku`) REFERENCES `Inventory`(`sku`);

ALTER TABLE `OrderTime` ADD CONSTRAINT `OrderTime_fk0` FOREIGN KEY (`order_reference`) REFERENCES `Orders`(`reference`);

ALTER TABLE `Raw` ADD CONSTRAINT `Raw_fk0` FOREIGN KEY (`order_reference`) REFERENCES `Orders`(`reference`);

ALTER TABLE `Raw` ADD CONSTRAINT `Raw_fk1` FOREIGN KEY (`sku`) REFERENCES `Inventory`(`sku`);

ALTER TABLE `Tracking` ADD CONSTRAINT `Tracking_fk0` FOREIGN KEY (`order_reference`) REFERENCES `Orders`(`reference`);

ALTER TABLE `OrderProperties` ADD CONSTRAINT `OrderProperties_fk0` FOREIGN KEY (`order_reference`) REFERENCES `Orders`(`reference`);

ALTER TABLE `Products` ADD CONSTRAINT `Products_fk0` FOREIGN KEY (`sku`) REFERENCES `Inventory`(`sku`);

