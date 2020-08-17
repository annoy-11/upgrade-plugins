<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->widgetIdentity):?>
	<?php $randonnumber = $this->widgetIdentity;?> 
<?php else:?>
	<?php $randonnumber = $this->identity;?>
<?php endif;?>
<div class="sesarticle_top_article_writers_list" style="position:relative;">
  <?php if($this->view_type == 'Vertical'):?>
		<ul id="widget_sesarticle_<?php echo $randonnumber; ?>" class="sesbasic_sidebar_block  sesbasic_clearfix sesbasic_bxs">
			<div class="sesbasic_loading_cont_overlay" id="sesarticle_widget_overlay_<?php echo $randonnumber; ?>"></div>
			<?php foreach( $this->paginator as $articleger ): ?>
				<?php $item = Engine_Api::_()->getItem('user',$articleger->user_id);?>
				<li class="sesarticle_writers_top_sidebar_list">
						<?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.icon'), array('class' => 'sesarticle_top_article_thumb')) ?>
					<div class="sesarticle_top_article_info">
					  <?php if(isset($this->ownernameActive)):?>
							<div class="sesarticle_top_article_title">
								<?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
							</div>
						<?php endif;?>
						<?php if(isset($this->countActive)):?>
							<div class="sesarticle_top_article_list_stats">
								<?php echo $this->translate('Total Article:');?>
								<b><?php echo $articleger->article_count; ?></b>
							</div>
						<?php endif;?>
					</div>
				</li>
			<?php endforeach; ?>
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
	<?php else:?>
		<ul id="widget_sesarticle_<?php echo $randonnumber; ?>" class="sesbasic_sidebar_block  sesbasic_clearfix sesbasic_bxs">
			<div class="sesbasic_loading_cont_overlay" id="sesarticle_widget_overlay_<?php echo $randonnumber; ?>"></div>
			<?php foreach( $this->paginator as $articleger ): ?>
				<?php $item = Engine_Api::_()->getItem('user',$articleger->user_id);?>
				<li class="sesarticle_writers_top_gird_list" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
				<div class="sesarticle_writers_top_gird_thumb_article" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
					<?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.profile'), array('class' => 'sesarticle_top_article_thumb')) ?>
					<?php if(isset($this->ownernameActive) || isset($this->countActive)):?>
						<div class="sesarticle_top_article_info">
							<?php if(isset($this->ownernameActive)):?>
								<div class="sesarticle_top_article_title">
									<?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
								</div>
							<?php endif;?>
							<?php if(isset($this->countActive)):?>
								<div class="sesarticle_top_article_list_stats">
									<?php echo $this->translate('Total Article:');?>
									<b><?php echo $articleger->article_count; ?></b>
								</div>
						<?php endif;?>
						</div>
					<?php endif;?>
					</div>
				</li>
			<?php endforeach; ?>
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
	<?php endif;?>
</div>
<?php if(isset($this->widgetName)){ ?>
  <script type="application/javascript">
		var anchor_<?php echo $randonnumber ?> = sesJqueryObject('#widget_sesarticle_<?php echo $randonnumber; ?>').parent();
		function showHideBtn<?php echo $randonnumber ?> (){
			sesJqueryObject('#widget_previous_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>');
			sesJqueryObject('#widget_next_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' ) ?>');	
		}
		showHideBtn<?php echo $randonnumber ?> ();
		function widget_previous_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesarticle_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/sesarticle/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
				data : {
					format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>', 
					page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() - 1) ?>
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					sesJqueryObject('#sesarticle_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send()
		};

		function widget_next_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesarticle_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/sesarticle/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
				data : {
					format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>' , 
					page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					sesJqueryObject('#sesarticle_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send();
		};
	</script>
<?php } ?>