<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template3.css'); ?>

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des3wid7_wrapper">
	<div class="seslp_blocks_container">
		<h2><?php echo $this->title; ?></h2>
    <div class="seslp_des3wid7_content">
      <?php if(count($this->paginator1) > 0) { ?>
        <div class="seslp_des3wid7_member_list" id="seslp_m_all">
          <?php foreach($this->paginator1 as $user) { ?>
            <?php if(!empty($user->photo_id)): ?>
              <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
              if($photo)
              $photo_url = $photo->getPhotoUrl(); ?>
            <?php else: ?>
              <?php $photo_url = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
            <?php endif; ?>
            <div class="seslp_des3wid7_member_list_item">
              <a href="<?php echo $user->getHref(); ?>" class="seslp_des3wid7_member_list_item_thumb"><img src="<?php echo $photo_url; ?>" /></a>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      
      
      <?php if(count($this->paginator2) > 0) { ?>
        <div class="seslp_des3wid7_member_list" id="seslp_m_men">
          <?php foreach($this->paginator2 as $user) { ?>
            <?php if(!empty($user->photo_id)): ?>
              <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
              if($photo)
              $photo_url = $photo->getPhotoUrl(); ?>
            <?php else: ?>
              <?php $photo_url = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
            <?php endif; ?>
            <div class="seslp_des3wid7_member_list_item">
              <a href="<?php echo $user->getHref(); ?>" class="seslp_des3wid7_member_list_item_thumb"><img src="<?php echo $photo_url; ?>" /></a>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      
      <?php if(count($this->paginator3) > 0) { ?>
        <div class="seslp_des3wid7_member_list" id="seslp_m_women">
          <?php foreach($this->paginator3 as $user) { ?>
            <?php if(!empty($user->photo_id)): ?>
              <?php $photo = Engine_Api::_()->storage()->get($user->photo_id, '');
              if($photo)
              $photo_url = $photo->getPhotoUrl(); ?>
            <?php else: ?>
              <?php $photo_url = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
            <?php endif; ?>
            <div class="seslp_des3wid7_member_list_item">
              <a href="<?php echo $user->getHref(); ?>" class="seslp_des3wid7_member_list_item_thumb"><img src="<?php echo $photo_url; ?>" /></a>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      
			<div class="seslp_des3wid7_tabs">
        <?php if(count($this->paginator1) > 0) { ?>
          <a href="javascript:void(0);" class="seslp_animation seslp_m_tablinks" onclick="openTab(event, 'seslp_m_all')" id="defaultOpen"><?php echo $this->tabtitle1; ?></a>
        <?php } ?>
        <?php if(count($this->paginator2) > 0) { ?>
          <a href="javascript:void(0);" class="seslp_animation seslp_m_tablinks" onclick="openTab(event, 'seslp_m_men')"><?php echo $this->tabtitle2; ?></a>
        <?php } ?>
        <?php if(count($this->paginator3) > 0) { ?>
          <a href="javascript:void(0);" class="seslp_animation seslp_m_tablinks" onclick="openTab(event, 'seslp_m_women')"><?php echo $this->tabtitle3; ?></a>
        <?php } ?>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
function openTab(evt, mlist) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("seslp_des3wid7_member_list");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("seslp_m_tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(mlist).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();
</script>
