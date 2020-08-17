<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: unlike-as-page.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sespage_profile_likepage_popup sesbasic_bxs sespage_profile_unlikepage_popup_">
	<div class="_header">Remove <?php echo $this->page->getTitle(); ?> from my Page's favorites?</div>
	<div class="_content sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $this->page->getPhotoUrl('thumb.normal'); ?>" alt="" />
    </div>
  	<div class="_cont">
    	<p>For which page would you like to remove  <?php echo $this->page->getTitle(); ?> from favorites?</p>
      <p>
        <select name="page" id="sespage_page_selected">
          <option value="">Select a Page</option>
          <?php foreach($this->myPages as $page){
                $page = Engine_Api::_()->getItem('sespage_page',$page->page_id);
           ?>
            <option value="<?php echo $page->getIdentity(); ?>"><?php echo $page->getTitle(); ?></option>
          <?php } ?>
        </select>
      </p>
    </div>
  </div>
  <div class="_footer">
  	<div class="floatR">
    	<a href="javascript:;" class="sesbasic_button" onClick="sessmoothboxclose();return false;">Cancel</a>
      <button type="button" onClick="saveValueSespage();">Submit</button>
    </div>
  </div>
</div>
<script type="application/javascript">
function saveValueSespage(){
  var value = sesJqueryObject('#sespage_page_selected').val();
  if(!value)
    return;
    
  sesJqueryObject.post('sespage/index/unlike-as-page/',{page_id:value,type:'sespage_page',id:<?php echo $this->page->getIdentity(); ?>},function(res){
     if(res){
       var innerhtml="<div class='_header'>Remove <?php echo $this->page->getTitle(); ?> from my Page's favorites?</div><div class='_content sesbasic_clearfix'>    <div class='_thumb'><img src='<?php echo $this->page->getPhotoUrl('thumb.normal'); ?>' alt='' /></div><div class='_cont'><p><?php echo $this->page->getTitle(); ?> has been removed from favorites.</p></div></div><div class='_footer sesbasic_clearfix'><div class='floatR'><button onClick='sessmoothboxclose();return false;'>Ok</a></div></div></div>";
			 sesJqueryObject('.sespage_profile_unlikepage_popup_').html(innerhtml);
     } 
  });
  
}
</script>
<?php die; ?>