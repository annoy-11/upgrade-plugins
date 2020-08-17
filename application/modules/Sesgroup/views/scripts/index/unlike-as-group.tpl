<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: unlike-as-group.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesgroup_profile_likegroup_popup sesbasic_bxs sesgroup_profile_unlikegroup_popup_">
	<div class="_header">Remove <?php echo $this->group->getTitle(); ?> from my Group's favorites?</div>
	<div class="_content sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $this->group->getPhotoUrl('thumb.normal'); ?>" alt="" />
    </div>
  	<div class="_cont">
    	<p>For which group would you like to remove  <?php echo $this->group->getTitle(); ?> from favorites?</p>
      <p>
        <select name="group" id="sesgroup_group_selected">
          <option value="">Select a Group</option>
          <?php foreach($this->myGroups as $group){
                $group = Engine_Api::_()->getItem('sesgroup_group',$group->group_id);
           ?>
            <option value="<?php echo $group->getIdentity(); ?>"><?php echo $group->getTitle(); ?></option>
          <?php } ?>
        </select>
      </p>
    </div>
  </div>
  <div class="_footer">
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
    
  sesJqueryObject.post('sesgroup/index/unlike-as-group/',{group_id:value,type:'sesgroup_group',id:<?php echo $this->group->getIdentity(); ?>},function(res){
     if(res){
       var innerhtml="<div class='_header'>Remove <?php echo $this->group->getTitle(); ?> from my Group's favorites?</div><div class='_content sesbasic_clearfix'>    <div class='_thumb'><img src='<?php echo $this->group->getPhotoUrl('thumb.normal'); ?>' alt='' /></div><div class='_cont'><p><?php echo $this->group->getTitle(); ?> has been removed from favorites.</p></div></div><div class='_footer sesbasic_clearfix'><div class='floatR'><button onClick='sessmoothboxclose();return false;'>Ok</a></div></div></div>";
			 sesJqueryObject('.sesgroup_profile_unlikegroup_popup_').html(innerhtml);
     } 
  });
  
}
</script>
<?php die; ?>