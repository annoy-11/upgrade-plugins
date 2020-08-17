 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: my-upgrade-4.10.3-4.10.5.sql 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


ALTER TABLE `engine4_estorepackage_transactions` ADD `credit_point` INT(11) NOT NULL DEFAULT '0', ADD `credit_value` FLOAT NOT NULL DEFAULT '0';
ALTER TABLE `engine4_estorepackage_transactions` ADD `ordercoupon_id` INT NULL DEFAULT '0';

