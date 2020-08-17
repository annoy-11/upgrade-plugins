<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if($this->widgetIdentity){ 
  	$randonnumber = $this->widgetIdentity;
	}else{
  	$randonnumber = $this->identity;
 	}
?>
<?php if($this->view_type == 'list'): ?>
  <ul class="sesbasic_sidebar_block sesmember_side_block sesbasic_bxs sesbasic_clearfix" id="widget_sesmember_<?php echo $randonnumber; ?>" style="position:relative;">
<?php else: ?>
  <ul class="sesmember_side_block sesbasic_bxs sesbasic_clearfix" id="widget_sesmember_<?php echo $randonnumber; ?>" style="position:relative;">
<?php endif; ?>
<div class="sesbasic_loading_cont_overlay" id="sesmember_widget_overlay_<?php echo $randonnumber; ?>"></div>
  <?php include APPLICATION_PATH . '/application/modules/Sesmember/views/scripts/_sidebarWidgetData.tpl'; ?>

<?php if(isset($this->widgetName)){ ?>
  <div class="sidebar_privew_next_btns">
    <div class="sidebar_previous_btn">
      <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
        'id' => "widget_previous_".$randonnumber,
        'onclick' => "widget_previous_$randonnumber()",
        'class' => 'buttonlink previous_icon'
      )); ?>
    </div>
    <div class="Sidebar_next_btns">
      <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Next'), array(
        'id' => "widget_next_".$randonnumber,
        'onclick' => "widget_next_$randonnumber()",
        'class' => 'buttonlink_right next_icon'
      )); ?>
    </div>
  </div>
<?php } ?>
</ul>
<?php if(isset($this->widgetName)){ ?>
<script type="application/javascript">
 		var anchor_<?php echo $randonnumber ?> = sesJqueryObject('#widget_sesmember_<?php echo $randonnumber; ?>').parent();
    function showHideBtn<?php echo $randonnumber ?> (){
			sesJqueryObject('#widget_previous_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->results->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>');
    	sesJqueryObject('#widget_next_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->results->count() == $this->results->getCurrentPageNumber() ? 'none' : '' ) ?>');	
		}
		showHideBtn<?php echo $randonnumber ?> ();
    function widget_previous_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesmember_widget_overlay_<?php echo $randonnumber; ?>').show();
      new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/mod/sesmember/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>', 
          page : <?php echo sprintf('%d', $this->results->getCurrentPageNumber() - 1) ?>
        },
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					<?php if(isset($this->view_type) && $this->view_type == 'gridOutside'){ ?>
					jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({theme:"minimal-dark"});
				<?php } ?>
					sesJqueryObject('#sesmember_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
      }).send()
		};

    function widget_next_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesmember_widget_overlay_<?php echo $randonnumber; ?>').show();
      new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/mod/sesmember/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>' , 
          page : <?php echo sprintf('%d', $this->results->getCurrentPageNumber() + 1) ?>
        },
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					<?php if(isset($this->view_type) && $this->view_type == 'gridOutside'){ ?>
					jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({theme:"minimal-dark"});
				<?php } ?>
					sesJqueryObject('#sesmember_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
      }).send();
		};
var tabId_fm9 = <?php echo $this->identity; ?>;
  window.addEvent('domready', function() {
    tabContainerHrefSesbasic(tabId_fm9);	
  });
</script>
<?php } ?>