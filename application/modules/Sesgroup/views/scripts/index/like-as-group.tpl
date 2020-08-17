<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: like-as-group.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesgroup_profile_likegroup_popup sesbasic_bxs sesgroup_profile_likegroup_popup_">
  <div class="_header">Like <?php echo $this->group->getTitle(); ?> as Your Group</div>
  <div class="_content sesbasic_clearfix">
    <div class="_thumb">
    	<img src="<?php echo $this->group->getPhotoUrl('thumb.normal'); ?>" alt="" />
    </div>
    <div class="_cont">
      <p> Likes will show up on your Group's timeline. Which Group do you want to like <?php echo $this->group->getTitle(); ?> as? </p>
      <p>
        <select name="group" id="sesgroup_group_selected">
          <option value="">Select a Group</option>
          <?php foreach($this->myGroups as $group){
                $group = Engine_Api::_()->getItem('sesgroup_group',$group->group_id);
           ?>
           <?php if($group){?>
          	<option value="<?php echo $group->getIdentity(); ?>"><?php echo $group->getTitle(); ?></option>
          	<?php }?>
          <?php } ?>
        </select>
      </p>
    </div>
  </div>
  <div class="_footer sesbasic_clearfix">
  	<div class="floatR">
      <a href="javascript:;" class="sesbasic_button" onClick="sessmoothboxclose();return false;">Cancel</a>
      <button type="button" onClick="saveValueSesgroup();">Submit</button>
    </div>
  </div>
</div>
<script type="application/javascript">
function saveValueSesgroup(){
  var value = sesJqueryObject('#sesgroup_group_selected').val();
  if(!value)
    return;
    
  sesJqueryObject.post('sesgroup/index/like-as-group/',{group_id:value,type:'sesgroup_group',id:<?php echo $this->group->getIdentity(); ?>},function(res){
     if(res){
       var innerhtml="<div class='_header'>Like <?php echo $this->group->getTitle(); ?> as Your Group</div><div class='_content sesbasic_clearfix'>    <div class='_thumb'><img src='<?php echo $this->group->getPhotoUrl('thumb.normal'); ?>' alt='' /></div><div class='_cont'><p><?php echo $this->group->getTitle(); ?><?php echo $this->translate(' has been liked as Your group.');?></p></div></div><div class='_footer sesbasic_clearfix'><div class='floatR'><button onClick='sessmoothboxclose();return false;'>Ok</a></div></div></div>";
			 sesJqueryObject('.sesgroup_profile_likegroup_popup_').html(innerhtml);
     } 
  });
  
}
</script>
<?php die; ?>
