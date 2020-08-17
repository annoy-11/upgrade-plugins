<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmenu/externals/styles/styles.css'); ?>
<?php $menuItem = $this->menuItem; ?>
<?php $menu_id = $this->menu_id; ?>
<?php $apiTable = Engine_Api::_()->getApi('core', 'sesmenu');?>
<?php $moduleData  = $apiTable->getModuleData($menuItem->module); ?>
<?php if($this->design_templete > 0 && $this->design_templete <= 18) { ?>
<?php include APPLICATION_PATH .  "/application/modules/Sesmenu/views/scripts/menu_types/design".$this->design_templete.".tpl"; ?>
<?php } ?>

