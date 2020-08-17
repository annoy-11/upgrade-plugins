<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: unlike-as-business.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesbusiness_profile_likebusiness_popup sesbasic_bxs sesbusiness_profile_unlikebusiness_popup_">
	<div class="_header">Remove <?php echo $this->business->getTitle(); ?> from my Business's favorites?</div>
	<div class="_content sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $this->business->getPhotoUrl('thumb.normal'); ?>" alt="" />
    </div>
  	<div class="_cont">
    	<p>For which business would you like to remove  <?php echo $this->business->getTitle(); ?> from favorites?</p>
      <p>
        <select name="business" id="sesbusiness_business_selected">
          <option value="">Select a Business</option>
          <?php foreach($this->myBusinesses as $business){
                $business = Engine_Api::_()->getItem('businesses',$business->business_id);
           ?>
            <option value="<?php echo $business->getIdentity(); ?>"><?php echo $business->getTitle(); ?></option>
          <?php } ?>
        </select>
      </p>
    </div>
  </div>
  <div class="_footer">
  	<div class="floatR">
    	<a href="javascript:;" class="sesbasic_button" onClick="sessmoothboxclose();return false;">Cancel</a>
      <button type="button" onClick="saveValueSesbusiness();">Submit</button>
    </div>
  </div>
</div>
<script type="application/javascript">
function saveValueSesbusiness(){
  var value = sesJqueryObject('#sesbusiness_business_selected').val();
  if(!value)
    return;
    
  sesJqueryObject.post('sesbusiness/index/unlike-as-business/',{business_id:value,type:business,id:<?php echo $this->business->getIdentity(); ?>},function(res){
     if(res){
       var innerhtml="<div class='_header'>Remove <?php echo $this->business->getTitle(); ?> from my Business's favorites?</div><div class='_content sesbasic_clearfix'>    <div class='_thumb'><img src='<?php echo $this->business->getPhotoUrl('thumb.normal'); ?>' alt='' /></div><div class='_cont'><p><?php echo $this->business->getTitle(); ?> has been removed from favorites.</p></div></div><div class='_footer sesbasic_clearfix'><div class='floatR'><button onClick='sessmoothboxclose();return false;'>Ok</a></div></div></div>";
			 sesJqueryObject('.sesbusiness_profile_unlikebusiness_popup_').html(innerhtml);
     } 
  });
  
}
</script>
<?php die; ?>
