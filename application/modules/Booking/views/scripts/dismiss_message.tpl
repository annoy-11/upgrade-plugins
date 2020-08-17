<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Booking & Appointments Plugin") ?></h2>
<?php $booking_adminmenu = Zend_Registry::isRegistered('booking_adminmenu') ? Zend_Registry::get('booking_adminmenu') : null; ?>
<?php if($booking_adminmenu) { ?>
  <?php if(count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
    <ul>
      <?php foreach( $this->navigation as $navigationMenu ):
        $explodedal = explode(' ', $navigationMenu->class);
      ?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php echo $this->htmlLink($navigationMenu->getHref(), $this->translate($navigationMenu->getLabel()), array(
            'class' => $navigationMenu->getClass())); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    </div>
  <?php endif; ?>
<?php } ?>
