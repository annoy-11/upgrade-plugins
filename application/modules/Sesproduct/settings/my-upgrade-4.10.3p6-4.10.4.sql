/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my-upgrade-4.10.3p6-4.10.4.sql  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


ALTER TABLE `engine4_sesproduct_orders` ADD `credit_point` INT(11) NOT NULL DEFAULT '0', ADD `credit_value` FLOAT NOT NULL DEFAULT '0';