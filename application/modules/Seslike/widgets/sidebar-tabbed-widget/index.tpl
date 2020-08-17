<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>

<?php if(!$this->is_ajax){ ?>
  <div class="sesbasic_clearfix sesbasic_bxs sesbasic_sidebar_block">
    <div class="seslike_small_tabs seslike_sidewidget_tabs sesbasic_clearfix" <?php if(count($this->defaultOptions) ==1){ ?> style="display:none" <?php } ?>> 
    	<ul id="tab-widget-seslike-<?php echo $randonNumber; ?>" class="sesbasic_clearfix">
       <?php 
         $defaultOptionArray = array();
         foreach($this->defaultOptions as $key=>$valueOptions){ 
         $defaultOptionArray[] = $key;
       ?>
       <li <?php if($this->defaultOpenTab == $key){ ?> class="active"<?php } ?> id="sesTabContainer_<?php echo $randonNumber; ?>_<?php echo $key; ?>">
         <a href="javascript:;" data-src="<?php echo $key; ?>" onclick="changeTabSes_<?php echo $randonNumber; ?>('<?php echo $key; ?>')"><?php echo $this->translate(($valueOptions)); ?></a>
       </li>
       <?php } ?>
      </ul>
    </div>
  <div class="sesbasic_tabs_content sesbasic_clearfix">
<?php } ?>

<?php  if(!$this->is_ajax): ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslike/externals/styles/styles.css'); ?>
<?php endif;?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>

<?php  if(isset($this->defaultOptions) && count($this->defaultOptions) == 1): ?>
  <script type="application/javascript">
    sesJqueryObject('#tab-widget-seslike-<?php echo $randonNumber; ?>').parent().css('display','none');
  </script>
<?php endif;?>

<?php if(!$this->is_ajax){ ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="seslike_side_widgetsesbasic_clearfix sesbasic_bxs clear">
    <div class="seslike_side_widget_inner">
      <ul class="seslike_side_widget_cont sesbasic_clearfix clear" id="sidebar-tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>
        <?php foreach($this->paginator as $result) { ?>
          <?php $resource = Engine_Api::_()->getItem($result->resource_type, $result->resource_id); ?>
          <?php if($resource) { ?>
            <?php $like_count = Engine_Api::_()->seslike()->likeCount($result->resource_type, $result->resource_id); ?>
            <li class="seslike_side_widget_item sesbasic_bg">
              <div class="top_cont">
                <div class="left_cont">
                  <a href="<?php echo $resource->getHref(); ?>" title="<?php echo $resource->getTitle(); ?>">
                    <div class="_img">
                      <?php echo $this->itemPhoto($resource, 'thumb.profile', true); ?>
                    </div>
                  </a>
                </div>
                <div class="right_cont">
                  <div class="_title"><a href="<?php echo $resource->getHref(); ?>" title="<?php echo $resource->getTitle(); ?>"><?php echo $resource->getTitle(); ?></a></div>
                  <div class="_user"><?php echo $this->translate("by "); ?><a href="<?php echo $resource->getOwner()->getHref(); ?>" class="_posted_by"><?php echo $resource->getOwner()->getTitle(); ?></a></div>
                </div>
              </div>
              <div class="_bottom sesbasic_clearfix">
                <div class="_left">
                  <?php if($result->resource_type == 'user') { ?>
                    <span class="_likes sesbasic_text_light" title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)) ?>"><i class="fa fa-thumbs-o-up"></i><?php echo $result->like_count; ?></span>
                  <?php } else { ?>
                    <span class="_likes sesbasic_text_light" title="<?php echo $this->translate(array('%s like', '%s likes', $like_count), $this->locale()->toNumber($like_count)) ?>"><i class="fa fa-thumbs-o-up"></i><?php echo $like_count; ?></span>
                  <?php } ?>
                </div>
                
                <?php $is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($resource, $viewer); ?>
                <?php if (!empty($viewer->getIdentity())) { ?>
                  <?php
                  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($resource->getIdentity(), $resource->getType());
                  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
                  $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like');
                  ?>
                  <div class="_right">
                    <a href="javascript:;" data-id="<?php echo $resource->getIdentity() ; ?>" data-type="<?php echo $resource->getType() ; ?>" data-widget="1" data-url="<?php echo $resource->getIdentity() ; ?>" class="sesbasic_animation seslike_like_btn seslike_like_content_view  seslike_like_<?php echo $resource->getType() ?>_<?php echo $resource->getIdentity() ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $likeText;?></span></a>
                  </div>
                <?php } ?>
              </div>
            </li>
          <?php } ?>
        <?php } ?>
        <?php if($this->paginator->getTotalItemCount() == 0) { ?>
          <div class="tip"><span><?php echo $this->translate('There are no content.');?></span></div>
        <?php } ?>
    <?php if(!$this->is_ajax) { ?>
      </ul>
        <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Core/externals/images/loading.gif" /></div>
    </div>
  </div>
<?php } ?>
<?php if(isset($this->loadJs)){ ?>
	<script type="text/javascript">
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
	</script>
<?php } ?>

<?php if(!$this->is_ajax){ ?>
    </div>
  </div>
<?php } ?>

<?php if(!$this->is_ajax):?>
  <script type="application/javascript"> 
    var availableTabs_<?php echo $randonNumber; ?>;
    var requestTab_<?php echo $randonNumber; ?>;
    <?php if(isset($defaultOptionArray)){ ?>
      availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($defaultOptionArray); ?>;
    <?php  } ?>
    var defaultOpenTab ;
    function changeTabSes_<?php echo $randonNumber; ?>(valueTab){
      if(sesJqueryObject("#sesTabContainer_<?php echo $randonNumber; ?>_"+valueTab).hasClass('active'))
      return;
      var id = '_<?php echo $randonNumber; ?>';
      var length = availableTabs_<?php echo $randonNumber; ?>.length;
      for (var i = 0; i < length; i++){
        if(availableTabs_<?php echo $randonNumber; ?>[i] == valueTab){
          document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('active');
          sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('sesbasic_tab_selected');
        } else{
          sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('sesbasic_tab_selected');
          document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('active');
        }
      }
      if(valueTab){
        if(document.getElementById("error-message_<?php echo $randonNumber;?>"))
        document.getElementById("error-message_<?php echo $randonNumber;?>").style.display = 'none';
        
        if(document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>'))
        document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML ='';
        
        document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = '<div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="margin-top:30px;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>';
        
        if(typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined')
        requestTab_<?php echo $randonNumber; ?>.cancel();
        
        defaultOpenTab = valueTab;
        requestTab_<?php echo $randonNumber; ?> = new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl+"widget/index/mod/seslike/name/<?php echo $this->widgetName; ?>/openTab/"+valueTab,
          'data': {
            format: 'html',  
            params : params<?php echo $randonNumber; ?>, 
            is_ajax : 1,
            identity : '<?php echo $randonNumber; ?>',
            height:'<?php echo $this->height;?>'
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            
            if(sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').length)
            sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','none');
            else
            sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide();
              
            sesJqueryObject('#error-message_<?php echo $randonNumber;?>').remove();
            var check = true;
            if(document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>'))
              document.getElementById('sidebar-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;

            sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
          }
        });
        requestTab_<?php echo $randonNumber; ?>.send();
        return false;			
      }
    }
  </script> 
<?php endif;?>
