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


UPDATE `engine4_core_menuitems` SET `params` = '{"route":"sesproduct_general","action":"browse"}' WHERE `engine4_core_menuitems`.`name` = 'core_main_sesproduct';
