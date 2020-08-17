<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _groupMemberStatics.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $users = $this->viewer()->membership()->getMembershipsOfIds();?>
<?php if($users):?>
  <?php $friends = Engine_Api::_()->getDbTable('membership','sesgroup')->getFriendGroup(array('user_id' => $this->viewer()->getIdentity(), 'group_id' => $group->group_id),$users);?>
<?php else:?>
  <?php $friends = 0;?>
<?php endif;?>
<div class="clear _stats sesbasic_text_light _member sesbasic_clearfix">
  <?php if(isset($this->friendActive) && $friends):?>
    <span title="<?php echo $this->translate(array('%s Friend', '%s Friends',$friends), $this->locale()->toNumber($friends)) ?>"><?php echo $this->translate(array('%s Friend', '%s Friends',$friends), $this->locale()->toNumber($friends)) ?></span>
  <?php endif;?>
  <?php if(isset($this->memberActive)):?>
  	<i class="fa fa-users"></i>
    <span title="<?php echo $this->translate(array('%s Member', '%s Members', $group->member_count), $this->locale()->toNumber($group->member_count)) ?>"><?php echo $this->translate(array('%s Member', '%s Members', $group->member_count), $this->locale()->toNumber($group->member_count)) ?></span>
  <?php endif;?>
</div>