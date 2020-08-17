ALTER TABLE `engine4_sesproduct_usergateways` ADD `gateway_type` varchar(64) NOT NULL;

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
('sesproduct_product_creation', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[product_name]'),
('sesproduct_product_outOfStock', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[product_name]'),
('estore_payment_request', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[store_name],[product_subject]'),
('estore_approve_request', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description]'),
('estore_cancel_request', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description]'),

('sesproduct_product_approved', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[product_name],[member_name]'),
('sesproduct_product_disapproved', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[product_name],[member_name]'),
('sesproduct_product_orderplaced', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[order_id],[buyer_name],[gateway_name],[store_name]'),
('sesproduct_product_orderplacedtobuyer', 'sesproduct', '[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_description],[order_id],[buyer_name],[gateway_name]');


INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`, `default`) VALUES
("sesproduct_product_creation", "sesproduct", 'A new product  {var:$productname} is created in store {item:$object}.', 0, "", 1),
("sesproduct_product_outOfStock", "sesproduct", 'Product {var:$productname} is out of stock.', 0, "", 1),
("estore_reviewpost", "estore", '{item:$subject} has given a review on store {item:$object}.', 0, "", 1),
("sesproduct_reviewpost", "sesproduct", '{item:$subject} has posted a review on product {item:$object}.', 0, "", 1),
("sesproduct_product_favourite", "sesproduct", '{item:$subject}  has marked your Product {item:$object} as favourite.', 0, "", 1),
("sesproduct_product_approve", "sesproduct", 'Your Product {item:$object} has been approved.', 0, "", 1),
("sesproduct_product_waitApprove", "sesproduct", 'A New Product {item:$object} is waiting for your approval.', 0, "", 1),
("sesproduct_product_disapproved", "sesproduct", 'Sorry! Your Product {item:$object} has been disapproved.', 0, "", 1),
("estore_payment_request", "estore", 'Member {item:$subject} request for payment for Store {item:$object}.', 0, "", 1),
("estore_approve_request", "estore", 'Site admin approved your payment request for Store {item:$object}.', 0, "", 1),
("estore_payment_done", "estore", 'Member  {item:$subject} has been made payment for Product {item:$object}.', 0, "", 1),
("estore_cancel_request", "estore", 'Site admin rejected your payment request for Store {item:$object}.', 0, "", 1),
("sesproduct_wishlist_product", "sesproduct", 'Product {item:$subject} s out of stock will update you soon when it comes in the store {item:$object}.', 0, "", 1);

INSERT IGNORE INTO `engine4_sesbasic_integrateothermodules` (`module_name`, `type`, `content_type`, `content_type_photo`, `content_id`, `content_id_photo`, `enabled`) VALUES
('sesproduct', 'lightbox', 'sesproduct_album', 'sesproduct_photo', 'album_id', 'photo_id', 1);

ALTER TABLE `engine4_estore_stores` CHANGE `member_count` `member_count` INT(1) NULL DEFAULT '0';
