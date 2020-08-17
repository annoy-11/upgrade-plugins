<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: user-search.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if (count($this->paginator) > 1):?>
<?php echo $this->translate("Your search returned too many results; only displaying the first 20.") ?>
<?php endif;?>
<?php foreach ($this->paginator as $user):?>
<?php if (!$this->sesforum->isModerator($user)):?>
  <li>
    <a href='javascript:addModerator(<?php echo $user->getIdentity();?>);'><?php echo $user->getTitle();?></a>
  </li>
<?php endif;?>
<?php endforeach;?>
