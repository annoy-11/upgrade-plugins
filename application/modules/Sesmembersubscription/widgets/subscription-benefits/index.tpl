<?php ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmembersubscription/externals/styles/styles.css'); ?>

<div class="sesmembersubscription_intro_wrapper sesbasic_bxs">
	<div class="_header sesbasic_clearfix">
    <div class="floatL _left">
    	<div class="_ptofiletitle">
        <?php if($this->edit) { ?>
          <span class="editbtn"><a href="members/edit/profile"><i class="fa fa-cog"></i></a><span><?php echo $this->translate("Edit")?></span></span>
      	<?php } ?>
    		<h2><?php echo $this->user->getTitle(); ?></h2>
      </div>
    	<div class="_profiletagline">
        <?php if($this->edit) { ?>
          <span class="editbtn"><a href="<?php echo $this->url(array('user_id' => $this->user->getIdentity(), 'action'=>'designation'), 'sesmembersubscription_extended', true); ?>" class="smoothbox"><i class="fa fa-cog"></i></a><span><?php echo $this->translate("Edit")?></span></span>
      	<?php } ?>
      	<?php if($this->user->designation) { ?>
          <span class="sesbasic_text_light"><?php echo $this->user->designation; ?></span>
      	<?php } ?>
      </div>
    </div>
    <div class="floatR _right">
    	<div class="sesmembersubscription_subscribebtn sesbasic_clearfix">
        <?php if($this->edit) { ?>
          <span class="editbtn"><a href="subscriber"><i class="fa fa-cog"></i></a><span><?php echo $this->translate("Edit")?></span></span>
      	<?php } ?>
      	<a href="<?php echo $this->url(array( 'module' => 'sesmembersubscription', 'controller' => 'order', 'action' => 'process', 'package_id' => $this->package_id, 'user_id' => $this->user->getIdentity(), 'gateway_id' => 2), 'default', true); ?>">
        	<span><?php echo  $this->package->getPackageDescription(array('type' => 'user')); ?></span>
          <span class="_sh"><?php echo $this->translate("Subscribe"); ?></span>
        </a>
      </div>
      <?php if($this->edit) { ?>
        <div class="sesmembersubscription_addvideo_btn sesbasic_clearfix">
          <a href="<?php echo $this->url(array('user_id' => $this->user->getIdentity(), 'action'=>'add-video'), 'sesmembersubscription_extended', true); ?>" class="sesbasic_link_btn smoothbox"><i class="fa fa-plus"></i><span><?php if(!$this->user->video_url) { ?><?php echo $this->translate("Add Welcome Video"); ?><?php } else { ?><?php echo $this->translate("Edit Welcome Video"); ?><?php } ?></span></a>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="sesmembersubscription_intro_benifits sesbasic_bxs">
  	<div class="_label"><?php echo $this->translate("Subscriber Benefits"); ?>
      <?php if($this->edit) { ?>
        <span class="editbtn"><a class="smoothbox" href="<?php echo $this->url(array('user_id' => $this->user->getIdentity(), 'action'=>'subscriber-benifit'), 'sesmembersubscription_extended', true); ?>"><i class="fa fa-cog"></i></a><span><?php echo $this->translate("Edit")?></span></span>
      <?php } ?>
  	</div>
    <?php if($this->user->subscriber_benifit) { ?>
      <div class="_body sesbasic_html_block">
        <?php echo $this->user->subscriber_benifit; ?>
      </div>
    <?php } ?>
  </div>
  <div class="member_intro sesbasic_clearfix">
    <div class="_videosection">
      <?php if($this->user->video_url) { ?>
        <div class="_video">
          <!--<iframe width="560" height="315" src="<?php echo $this->user->video_url; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
          <?php echo $this->user->video_url; ?>
        </div>
      <?php } ?>
      <div class="_btn"><a href="<?php echo $this->url(array( 'module' => 'sesmembersubscription', 'controller' => 'order', 'action' => 'process', 'package_id' => $this->package_id, 'user_id' => $this->user->getIdentity(), 'gateway_id' => 2), 'default', true); ?>" class="sesmembersubscription_button"><?php echo $this->translate("Subscribe Now"); ?></a></div>
    </div>
    <div class="adminmsg">
    	<article>
        <div class="_head"><?php echo $this->translate("Welcome to %s's profile page!", $this->user->getTitle()); ?></div>
        <div class="_cont">
          <?php echo nl2br($this->adminMessage); ?>
        </div>
			</article>
    </div>
  </div>
</div>