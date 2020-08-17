<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(isset($this->decisionmaker) && count($this->decisionmaker)>0){ ?>
<ul class="epetition_profile_decision_maker">
    <?php $c=0; foreach ($this->decisionmaker as $item) { ?>
        <?php $user = Engine_Api::_()->getItem('user', $item['user_id']); ?>
    <li><?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?> <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?></li>
     <?php  } ?>
</ul>
<?php } else { echo "<h4 class='no_dm'>".$this->translate('No Decision Maker')."</h4>"; } ?>
