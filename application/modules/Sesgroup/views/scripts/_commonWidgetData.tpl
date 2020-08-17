<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _commonWidgetData.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
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
<ul id="similar-group_<?php echo $randonNumber; ?>" class="sesgroup_group_listing sesbasic_bxs sesbasic_clearfix">
  <?php foreach($this->groups as $group):?>
    <?php if(isset($groupObject)):?>
      <?php $group = Engine_Api::_()->getItem('sesgroup_group',$group->group_id);?>
    <?php endif;?>
    <?php if(isset($this->titleActive)):?>
      <?php if(strlen($group->getTitle()) > $this->params['title_truncation']):?>
        <?php $title = mb_substr($group->getTitle(),0,$this->params['title_truncation']).'...';?>
      <?php else: ?>
        <?php $title = $group->getTitle();?>
      <?php endif; ?>
    <?php endif;?>
    <?php $viewer = Engine_Api::_()->user()->getViewer();?>
    <?php $canComment = $group->authorization()->isAllowed($viewer, 'comment');?>
    <?php if (!empty($group->category_id)):?>
      <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sesgroup')->find($group->category_id)->current();?>
    <?php endif;?>
    <?php if($this->params['viewType'] == 'list'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/sidebar/_listView.tpl';?>
    <?php elseif($this->params['viewType'] == 'horrizontallist'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/sidebar/_horrizontallistView.tpl';?>
    <?php elseif($this->params['viewType'] == 'grid'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/group/_gridView.tpl';?>
    <?php elseif($this->params['viewType'] == 'advgrid'):?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/group/_advgridView.tpl';?>
    <?php else:?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/group/_pinboardView.tpl';?>
    <?php endif;?>
  <?php endforeach;?>
</ul>

<script type="text/javascript">
  var wookmark = undefined;
  //Code for Pinboard View
  var wookmark<?php echo $randonNumber ?>;
  function pinboardLayout_<?php echo $randonNumber ?>(force){
      sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
      var imgLoad = imagesLoaded('#similar-group_<?php echo $randonNumber; ?>');
      imgLoad.on('progress',function(instance,image){
          sesJqueryObject(image.img).parent().parent().parent().parent().parent().show();
          sesJqueryObject(image.img).parent().parent().parent().parent().parent().removeClass('new_image_pinboard_<?php echo $randonNumber; ?>');
          imageLoadedAll<?php echo $randonNumber ?>(force);
      });
  }
  function imageLoadedAll<?php echo $randonNumber ?>(force){ 
    sesJqueryObject('#similar-group_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
    sesJqueryObject('#similar-group_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard');
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
