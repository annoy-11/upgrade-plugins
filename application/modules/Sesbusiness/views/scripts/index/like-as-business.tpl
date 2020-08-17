<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: like-as-business.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesbusiness_profile_likebusiness_popup sesbasic_bxs sesbusiness_profile_likebusiness_popup_">
  <div class="_header">Like <?php echo $this->business->getTitle(); ?> as Your Business</div>
  <div class="_content sesbasic_clearfix">
    <div class="_thumb">
    	<img src="<?php echo $this->business->getPhotoUrl('thumb.normal'); ?>" alt="" />
    </div>
    <div class="_cont">
      <p> Likes will show up on your Business's timeline. Which Business do you want to like <?php echo $this->business->getTitle(); ?> as? </p>
      <p>
        <select name="business" id="sesbusiness_business_selected">
          <option value="">Select a Business</option>
          <?php foreach($this->myBusinesses as $business){
                $business = Engine_Api::_()->getItem('businesses',$business->business_id);
           ?>
           <?php if($business){?>
          	<option value="<?php echo $business->getIdentity(); ?>"><?php echo $business->getTitle(); ?></option>
          	<?php }?>
          <?php } ?>
        </select>
      </p>
    </div>
  </div>
  <div class="_footer sesbasic_clearfix">
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
    
  sesJqueryObject.post('sesbusiness/index/like-as-business/',{business_id:value,type:'businesses',id:<?php echo $this->business->getIdentity(); ?>},function(res){
     if(res){
       var innerhtml="<div class='_header'>Like <?php echo $this->business->getTitle(); ?> as Your Business</div><div class='_content sesbasic_clearfix'>    <div class='_thumb'><img src='<?php echo $this->business->getPhotoUrl('thumb.normal'); ?>' alt='' /></div><div class='_cont'><p><?php echo $this->business->getTitle(); ?><?php echo $this->translate(' has been liked as Your business.');?></p></div></div><div class='_footer sesbasic_clearfix'><div class='floatR'><button onClick='sessmoothboxclose();return false;'>Ok</a></div></div></div>";
			 sesJqueryObject('.sesbusiness_profile_likebusiness_popup_').html(innerhtml);
     } 
  });
  
}
</script>
<?php die; ?>
