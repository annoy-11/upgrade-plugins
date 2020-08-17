<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesgroup_profile_tips sesbasic_bxs">
	<div class="sesgroup_profile_tips_header prelative">
  	<a href="javascript:;" class="fa fa-times _remove sesgroup_tip_remove"></a>
  	<div class="_heading"><?php echo $this->title; ?></div>
		<div class="_des"><?php echo $this->description; ?></div>
    <div class="_img"></div>
  </div>  
  <ul class="_tips">
  <?php if(in_array('addLocation',$this->types) && !empty($this->location) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.enable.location', 1)){ ?>
    <li class="sesbasic_clearfix _address sesbasic_animation _tip">
      <i class="_icon"></i>
      <div class="_btn"><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'manage-location'), 'sesgroup_dashboard', true); ?>" class="sesgroup_button">Add Location</a></div>
      <div class="_cont">
        <p class="_title">Help Customers Find Your Place</p>
        <p class="_des">Add your street address to your Group to make it easier for people to visit and check into your place.</p>
      </div>
    </li>
    <?php } ?>
    <?php if(in_array('addProfilePhoto',$this->types) && !empty($this->mainphoto)){ ?>
    <li class="sesbasic_clearfix _profilephoto sesbasic_animation _tip">
      <i class="_icon"></i>
      <div class="_btn"><a href="<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'mainphoto'), 'sesgroup_dashboard', true); ?>" class="sesgroup_button">Add Profile Photo</a></div>
      <div class="_cont">
        <p class="_title">Add a Profile Picture</p>
        <p class="_des">Profile pictures help you build an identity for your Group. They also help people find your Group and recognize it in posts, comments and more.</p>
      </div>
    </li>
    <?php } ?>
    <?php if(in_array('addCover',$this->types) && !empty($this->coverphoto)){ ?>
    <li class="sesbasic_clearfix _coverphoto sesbasic_animation _tip">
      <i class="_icon"></i>
      <div class="_btn"><a href="javascript:;" class="sesgroup_button sesgroup_cover_btn_a">Add Cover</a></div>
      <div class="_cont">
        <p class="_title">Add a Cover Photo</p>
        <p class="_des">Cover photos help you express your Group's identity. Try changing your cover photo when new things are happening with your business or organization.</p>
      </div>
    </li>
    	<?php } ?>
  </ul>
</div>

<script type="application/javascript">
sesJqueryObject('.sesgroup_tip_remove').click(function(){
    sesJqueryObject(this).closest('.generic_layout_container').remove();
})
sesJqueryObject('.sesgroup_cover_btn_a').click(function(){
  sesJqueryObject('html, body').animate({scrollTop: sesJqueryObject('.sesgroup_cover').offset().top}, 1000);
  setTimeout(function(){document.getElementById('coverChangesesgroup').click();},100);
})
</script>

