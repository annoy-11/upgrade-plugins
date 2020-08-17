<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gif.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

?>
<?php 
$getImages = Engine_Api::_()->getDbTable('images', 'sesfeedgif')->getImages(array('fetchAll' => 1, 'limit' => 10)); 


$show = 1; //Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedcomment.enablestickers', 1);
$enablesearch = 1; //Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedcomment.enablesearch', 1);
$enableattachement = array('stickers'); //unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvancedcomment.enableattachement', ''));
?>
<?php if(!$this->edit && !empty($show) && $enablesearch && in_array('stickers', $enableattachement)) { ?>
<!-- Sickers Search Box -->
<div class="ses_emoji_search_container sesbasic_clearfix gif_content" <?php if(!empty($show) && in_array('stickers', $enableattachement)):?><?php if(count($getImages) == 0 || empty($enablesearch)): ?> style="display:none;" <?php endif; ?> <?php else: ?> style="display:none;" <?php endif; ?>>
  <?php if(!empty($show) && in_array('stickers', $enableattachement)): ?>
    <div class="ses_emoji_search_bar">
      <div class="ses_emoji_search_input fa fa-search sesbasic_text_light" <?php if(empty($enablesearch)): ?> style="display:none;" <?php endif; ?>>
        <input type="text" placeholder='<?php echo $this->translate("Search GIF");?>' class="search_sesgif" />
        <!--<button type="reset" value="Reset" class="fa fa-close sesadvcnt_reset_gif"></button>-->
      </div>	
    </div>
  <?php endif; ?>
  
  <div class="ses_emoji_search_content sesbasic_custom_scroll sesbasic_clearfix main_search_category_srn">
  	<ul class="">
     <?php 
      foreach($getImages as $getImage) {
      $photo = Engine_Api::_()->storage()->get($getImage->file_id, '');
      if($photo) {
        $photo = $photo->getPhotoUrl();
     ?>
      <li rel="<?php echo $getImage->image_id; ?>">
        <a href="javascript:;" class="_sesadvgif_gif_polloption">
          <img src="<?php echo $photo; ?>" data-url="<?php echo $getImage->file_id ?>" alt="" />
        </a>
      </li>
      <?php } 
      } ?>
    </ul>
  </div>
  
  <div style="display:none;position:relative;height:255px;" class="main_search_cnt_srn" id="main_search_cnt_srn">
    <div class="sesgifsearch sesbasic_loading_container" style="height:100%;"></div>
  </div>
</div>
<?php } ?>

