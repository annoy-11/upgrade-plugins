<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: unlike-as-classroom.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="eclassroom_profile_likeclassroom_popup sesbasic_bxs eclassroom_profile_unlikeclassroom_popup_">
	<div class="_header"><?php echo $this->translate("Remove "); ?><?php echo $this->classroom->getTitle(); ?><?php echo $this->translate(" from my Store's favorites?"); ?></div>
	<div class="_content sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $this->classroom->getPhotoUrl('thumb.normal'); ?>" alt="" />
    </div>
  	<div class="_cont">
    	<p><?php echo $this->translate("For which classroom would you like to remove  "); ?><?php echo $this->classroom->getTitle(); ?><?php echo $this->translate(" from favorites?"); ?></p>
      <p>
        <select name="classroom" id="eclassroom_classroom_selected">
          <option value=""><?php echo $this->translate("Select a Store"); ?></option>
          <?php foreach($this->myStores as $classroom){
                $classroom = Engine_Api::_()->getItem('classrooms',$classroom->classroom_id);
           ?>
            <option value="<?php echo $classroom->getIdentity(); ?>"><?php echo $classroom->getTitle(); ?></option>
          <?php } ?>
        </select>
      </p>
    </div>
  </div>
  <div class="_footer">
  	<div class="floatR">
    	<a href="javascript:;" class="sesbasic_button" onClick="sessmoothboxclose();return false;"><?php echo $this->translate("Cancel"); ?></a>
      <button type="button" onClick="saveValueEclassroom();"><?php echo $this->translate("Submit"); ?></button>
    </div>
  </div>
</div>
<script type="application/javascript">
function saveValueEclassroom(){
  var value = sesJqueryObject('#eclassroom_classroom_selected').val();
  if(!value)
    return;
    
  sesJqueryObject.post('eclassroom/index/unlike-as-classroom/',{classroom_id:value,type:classroom,id:<?php echo $this->classroom->getIdentity(); ?>},function(res){
     if(res){
       var innerhtml="<div class='_header'>Remove <?php echo $this->classroom->getTitle(); ?> from my Store's favorites?</div><div class='_content sesbasic_clearfix'>    <div class='_thumb'><img src='<?php echo $this->classroom->getPhotoUrl('thumb.normal'); ?>' alt='' /></div><div class='_cont'><p><?php echo $this->classroom->getTitle(); ?> has been removed from favorites.</p></div></div><div class='_footer sesbasic_clearfix'><div class='floatR'><button onClick='sessmoothboxclose();return false;'>Ok</a></div></div></div>";
			 sesJqueryObject('.eclassroom_profile_unlikeclassroom_popup_').html(innerhtml);
     } 
  });
  
}
</script>
<?php die; ?>
