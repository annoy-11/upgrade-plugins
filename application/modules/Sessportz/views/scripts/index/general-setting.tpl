<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: general-setting.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php echo $this->navigation()->menu()->setContainer($this->settingNavigation)->render();?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<ul>
  <?php if($viewer->level_id == 1 || $viewer->level_id == 2):?>
    <li>
      <a href="<?php echo $this->url(array(), 'admin_default', true)?>"><?php echo $this->translate('Administrator');?></a>
    </li>
  <?php endif;?>
  <li>
    <a href="<?php echo $this->url(array(), 'user_logout', true)?>"><?php echo $this->translate('Logout');?></a>
  </li>
</ul>