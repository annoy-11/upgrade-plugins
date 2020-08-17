<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if($this->widgetIdentity):?>
	<?php $randonnumber = $this->widgetIdentity;?> 
<?php else:?>
	<?php $randonnumber = $this->identity;?>
<?php endif;?>

<?php if($this->view_type == 'list'): ?>
  <ul id="widget_sesproduct_<?php echo $randonnumber; ?>" class="sesbasic_sidebar_block sesbasic_sidebar_block sesproduct_side_block sesbasic_bxs sesbasic_clearfix" style="position:relative;">
<?php else: ?>
  <ul id="widget_sesproduct_<?php echo $randonnumber; ?>" class="sesproduct_products_listing sesbasic_bxs sesbasic_clearfix" style="position:relative;">
<?php endif; ?>
  <div class="sesbasic_loading_cont_overlay" id="sesproduct_widget_overlay_<?php echo $randonnumber; ?>"></div>
  <?php include APPLICATION_PATH . '/application/modules/Sesproduct/views/scripts/_sidebarWidgetData.tpl'; ?>
  <?php if(isset($this->widgetName)){ ?>
		<div class="sidebar_privew_next_btns">
			<div class="sidebar_previous_btn">
				<?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
					'id' => "widget_previous_".$randonnumber,
					'onclick' => "widget_previous_$randonnumber()",
					'class' => 'buttonlink previous_icon'
				)); ?>
			</div>
			<div class="sidebar_next_btns">
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
		var anchor_<?php echo $randonnumber ?> = sesJqueryObject('#widget_sesproduct_<?php echo $randonnumber; ?>').parent();
		function showHideBtn<?php echo $randonnumber ?> (){
			sesJqueryObject('#widget_previous_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->results->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>');
			sesJqueryObject('#widget_next_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->results->count() == $this->results->getCurrentPageNumber() ? 'none' : '' ) ?>');	
		}
		showHideBtn<?php echo $randonnumber ?> ();
		function widget_previous_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/sesproduct/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
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
					sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send()
		};

		function widget_next_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/sesproduct/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
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
					sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send();
		};
	</script>
<?php } ?>
