<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: like-as-store.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="estore_profile_likestore_popup sesbasic_bxs estore_profile_likestore_popup_">
  <div class="_header"><?php echo $this->translate("Like "); ?><?php echo $this->store->getTitle(); ?><?php echo $this->translate(" as Your Store"); ?></div>
  <div class="_content sesbasic_clearfix">
    <div class="_thumb">
    	<img src="<?php echo $this->store->getPhotoUrl('thumb.normal'); ?>" alt="" />
    </div>
    <div class="_cont">
      <p><?php echo $this->translate(" Likes will show up on your Store's timeline. Which Store do you want to like "); ?><?php echo $this->store->getTitle(); ?><?php echo $this->translate(" as? "); ?></p>
      <p>
        <select name="store" id="estore_store_selected">
          <option value=""><?php echo $this->translate("Select a Store"); ?></option>
          <?php foreach($this->myStores as $store){
                $store = Engine_Api::_()->getItem('stores',$store->store_id);
           ?>
           <?php if($store){?>
          	<option value="<?php echo $store->getIdentity(); ?>"><?php echo $store->getTitle(); ?></option>
          	<?php }?>
          <?php } ?>
        </select>
      </p>
    </div>
  </div>
  <div class="_footer sesbasic_clearfix">
  	<div class="floatR">
      <a href="javascript:;" class="sesbasic_button" onClick="sessmoothboxclose();return false;"><?php echo $this->translate("Cancel"); ?></a>
      <button type="button" onClick="saveValueEstore();"><?php echo $this->translate("Submit"); ?></button>
    </div>
  </div>
</div>
<script type="application/javascript">
function saveValueEstore(){
  var value = sesJqueryObject('#estore_store_selected').val();
  if(!value)
    return;
    
  sesJqueryObject.post('estore/index/like-as-store/',{store_id:value,type:store,id:<?php echo $this->store->getIdentity(); ?>},function(res){
     if(res){
       var innerhtml="<div class='_header'>Like <?php echo $this->store->getTitle(); ?> as Your Store</div><div class='_content sesbasic_clearfix'>    <div class='_thumb'><img src='<?php echo $this->store->getPhotoUrl('thumb.normal'); ?>' alt='' /></div><div class='_cont'><p><?php echo $this->store->getTitle(); ?><?php echo $this->translate(' has been liked as Your store.');?></p></div></div><div class='_footer sesbasic_clearfix'><div class='floatR'><button onClick='sessmoothboxclose();return false;'>Ok</a></div></div></div>";
			 sesJqueryObject('.estore_profile_likestore_popup_').html(innerhtml);
     } 
  });
  
}
</script>
<?php die; ?>
