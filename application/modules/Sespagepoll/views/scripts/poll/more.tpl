<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: more.tpl  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(count($this->moreuser >0)){
foreach ($this->moreuser as $option){
$user = Engine_Api::_()->getItem('user', $option->user_id);
?>
<div>
  <p><?php echo $user->displayname; ?></p>
  <div class="sespagepoll_more_img">
  <img src="<?php echo $user->getPhotoUrl('thumb.notmal'); ?>">
  </div>
</div>

<?php } } ?>
