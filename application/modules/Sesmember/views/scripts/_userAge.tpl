<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _userAge.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $memberAge = '';?>
<?php $member = $this->member;?>
<?php if(isset($this->ageActive)): $age = 0; ?>  
  <?php  $getFieldsObjectsByAlias = Engine_Api::_()->fields()->getFieldsObjectsByAlias($member); 
  if (!empty($getFieldsObjectsByAlias['birthdate'])) {
    $optionId = $getFieldsObjectsByAlias['birthdate']->getValue($member);
    if ($optionId && @$optionId->value) {
      $age = floor((time() - strtotime($optionId->value)) / 31556926);
    }
  } ?>
  <?php if($age && $optionId->value): ?>
    <?php echo "<div class='sesmember_list_stats'><span class='widthfull'><i class='fa fa-calendar-o'></i><span>".$this->translate(array('%s year old', '%s years old', $age), $this->locale()->toNumber($age))."</span></span></div>"; ?>
  <?php endif; ?>
<?php endif; ?>