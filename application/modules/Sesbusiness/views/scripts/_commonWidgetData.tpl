<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _commonWidgetData.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $widgetType = '';?>
<?php $randonNumber = $this->identity;?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
<?php if($this->params['viewType'] == 'pinboard'):?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
<?php endif;?>
<?php $height = $this->params['height'];?>
<?php $width = $this->params['width'];?>
<?php $pinbordWidth = is_numeric($this->params['width_pinboard']) ? $this->params['width_pinboard'].'px' : $this->params['width_pinboard'];?>
<?php $title= '';?>
<ul id="similar-business_<?php echo $randonNumber; ?>" class="sesbusiness_business_listing sesbasic_bxs sesbasic_clearfix">
  <?php foreach($this->businesses as $business):?>
    <?php if(isset($businessObject)):?>
      <?php $business = Engine_Api::_()->getItem('businesses',$business->business_id);?>
    <?php endif;?>
    <?php if(isset($this->titleActive)):?>
      <?php if(strlen($business->getTitle()) > $this->params['title_truncation']):?>
        <?php $title = mb_substr($business->getTitle(),0,$this->params['title_truncation']).'...';?>
      <?php else: ?>
        <?php $title = $business->getTitle();?>
      <?php endif; ?>
    <?php endif;?>
    <?php $viewer = Engine_Api::_()->user()->getViewer();?>
    <?php $canComment = $business->authorization()->isAllowed($viewer, 'comment');?>
    <?php if (!empty($business->category_id)):?>
      <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sesbusiness')->find($business->category_id)->current();?>
    <?php endif;?>
    <?php if($this->params['viewType'] == 'list'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/sidebar/_listView.tpl';?>
    <?php elseif($this->params['viewType'] == 'horrizontallist'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/sidebar/_horrizontallistView.tpl';?>
    <?php elseif($this->params['viewType'] == 'grid'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/business/_gridView.tpl';?>
    <?php elseif($this->params['viewType'] == 'advgrid'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/business/_advgridView.tpl';?>
    <?php else:?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/business/_pinboardView.tpl';?>
    <?php endif;?>
  <?php endforeach;?>
</ul>

<script type="text/javascript">
  var wookmark = undefined;
  //Code for Pinboard View
  var wookmark<?php echo $randonNumber ?>;
  function pinboardLayout_<?php echo $randonNumber ?>(force){
      sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
      var imgLoad = imagesLoaded('#similar-business_<?php echo $randonNumber; ?>');
      imgLoad.on('progress',function(instance,image){
          sesJqueryObject(image.img).parent().parent().parent().parent().parent().show();
          sesJqueryObject(image.img).parent().parent().parent().parent().parent().removeClass('new_image_pinboard_<?php echo $randonNumber; ?>');
          imageLoadedAll<?php echo $randonNumber ?>(force);
      });
  }
  function imageLoadedAll<?php echo $randonNumber ?>(force){ 
    sesJqueryObject('#similar-business_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
    sesJqueryObject('#similar-business_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard');
    if (typeof wookmark<?php echo $randonNumber ?> == 'undefined' || typeof force != 'undefined') {
      (function() {
        function getWindowWidth() {
          return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
        }				
        wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {
          itemWidth: <?php echo isset($pinbordWidth) ? str_replace(array('px','%'),array(''),$pinbordWidth) : '300'; ?>, // Optional min width of a grid item
          outerOffset: 0, // Optional the distance from grid to parent
          align:'left',
          flexibleWidth: function () {
            // Return a maximum width depending on the viewport
            return getWindowWidth() < 1024 ? '100%' : '30%';
          }
        });
      })();
    } else {
        wookmark<?php echo $randonNumber ?>.initItems();
        wookmark<?php echo $randonNumber ?>.layout(true);
    }
  }
   sesJqueryObject(window).resize(function(e){
    pinboardLayout_<?php echo $randonNumber ?>('',true);
   });
  <?php if($this->params['viewType'] == 'pinboard'):?>
    sesJqueryObject(document).ready(function(){pinboardLayout_<?php echo $randonNumber ?>();});
  <?php endif;?>
</script>
