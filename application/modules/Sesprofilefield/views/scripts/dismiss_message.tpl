<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<h2><?php echo $this->translate("Professional Profile Fields Plugin") ?></h2>
<?php $sesprofilefield_adminmenu = Zend_Registry::isRegistered('sesprofilefield_adminmenu') ? Zend_Registry::get('sesprofilefield_adminmenu') : null; ?>
<?php if(!empty($sesprofilefield_adminmenu)) { ?>
  <?php if(count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <ul>
        <?php foreach( $this->navigation as $navigationMenu ): ?>
          <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
            <?php echo $this->htmlLink($navigationMenu->getHref(), $this->translate($navigationMenu->getLabel()), array(
              'class' => $navigationMenu->getClass())); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
<?php } ?>
