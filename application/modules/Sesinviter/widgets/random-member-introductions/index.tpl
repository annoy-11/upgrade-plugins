<?php

?>
<?php $allWidgetParams = $this->allWidgetParams; ?>
<?php foreach($this->results as $result) { ?>
  <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
  <?php echo $user->getTitle(); ?>
  <?php if(in_array('memberphoto', $allWidgetParams['information'])) { ?>
    <div>
      <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon')) ?>
    </div>
  <?php } ?>
  <?php if($result->description) { ?>
    <div>
      <?php echo $this->string()->truncate(nl2br($result->description), $allWidgetParams['descriptionlimit']); ?>
    </div>
  <?php } ?>
  <?php if( $this->viewer()->getIdentity() && in_array('addfriendbutton', $allWidgetParams['information'])): ?>
    <div>
      <?php echo $this->userFriendship($user) ?>
    </div>
  <?php endif; ?>
  <?php if( $this->viewer()->getIdentity() && in_array('viewprofile', $allWidgetParams['information'])): ?>
    <div>
      <a href="<?php echo $user->getHref(); ?>"><?php echo $this->translate('VIEW PROFILE'); ?></a>
    </div>
  <?php endif; ?>
  <?php if( $this->viewer()->getIdentity() && in_array('mutualfriendcount', $allWidgetParams['information'])) { ?>
    <?php $mfriend = Engine_Api::_()->sesinviter()->getMutualFriendCount($user, $this->viewer()); ?>
    <?php echo $this->translate(array('%s mutual friend', '%s mutual friends', $mfriend), $this->locale()->toNumber($mfriend)); ?>
  <?php } ?>
<?php } ?>
