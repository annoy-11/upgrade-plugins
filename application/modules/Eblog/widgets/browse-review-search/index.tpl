<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?>
<?php $base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php if(!$this->widgetIdentity) { ?>
	<div class="eblog_browse_reviews_search sesbasic_bxs sesbasic_clearfix <?php echo $this->view_type == 'horizontal' ? 'eblog_browse_review_search_horizontal' : 'eblog_browse_review_search_vertical'; ?>">
<?php } ?>
<?php echo $this->form->render($this) ?>
<?php if(!$this->widgetIdentity) { ?>
	</div>
<?php } ?>
<script type="application/javascript">
  sesJqueryObject('#loadingimgeblogreview-wrapper').hide();
</script>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php if($controllerName == 'review' && $actionName == 'browse'){ ?>
  <?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget('eblog.browse-reviews','widget','eblog_review_browse'); ?>
	<?php if($identity):?>
		<script type="application/javascript">
			sesJqueryObject(document).ready(function(){
				sesJqueryObject('#filter_form_review').submit(function(e){	
					if(sesJqueryObject('.eblog_review_listing').length > 0){
						e.preventDefault();
						sesJqueryObject('#loadingimgeblogreview-wrapper').show();
						is_search_<?php echo $identity; ?> = 1;
						if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
							sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $identity?>').css('display', 'block');
							isSearch = true;
							e.preventDefault();
							searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
							sesJqueryObject('#loadingimgeblogreview-wrapper').show();
							paggingNumber<?php echo $identity; ?>(1);
						}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
							sesJqueryObject('#eblog_review_listing').html('');
							sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
							isSearch = true;
							e.preventDefault();
							searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
							page<?php echo $identity; ?> = 1;
							sesJqueryObject('#loadingimgeblogreview-wrapper').show();
							viewMore_<?php echo $identity; ?>();
						}
					}
					return true;
				});	
			});
		</script>
	<?php endif;?>
<?php }else if($controllerName == 'index' && $actionName == 'view'){?>
	<script type="application/javascript">
		sesJqueryObject(document).ready(function(){
			sesJqueryObject('#filter_form_review').submit(function(e){
				e.preventDefault();
				var error = false;
				searchParams = sesJqueryObject(this).serialize();
				sesJqueryObject('#loadingimgeblogreview-wrapper').show();
				<?php $identity = $this->widgetIdentity; ?>
				if(sesJqueryObject('.eblog_review_listing').length > 0){	
					e.preventDefault();
					sesJqueryObject('#loadingimgeblogreview-wrapper').show();
					is_search_<?php echo $identity; ?> = 1;
					if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
						sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $identity?>').css('display', 'block');
						searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
						sesJqueryObject('#loadingimgeblogreview-wrapper').show();
						paggingNumber<?php echo $identity; ?>(1);
					}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
						sesJqueryObject('#eblog_review_listing').html('');
						sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
						searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
						page<?php echo $identity; ?> = 1;
						sesJqueryObject('#loadingimgeblogreview-wrapper').show();
						viewMore_<?php echo $identity; ?>();
					}
				}
				return true;
			});	
	  });
	</script>
<?php } ?>
<script type="text/javascript">
	var Searchurl = "<?php echo $this->url(array('module' =>'eblog','controller' => 'index', 'action' => 'get-review'),'default',true); ?>";
	en4.core.runonce.add(function() {
		var contentAutocomplete = new Autocompleter.Request.JSON('search_text', Searchurl, {
			'postVar': 'text',
			'minLength': 1,
			'selectMode': 'pick',
			'autocompleteType': 'tag',
			'customChoices': true,
			'filterSubset': true,
			'multiple': false,
			'className': 'sesbasic-autosuggest',
			'injectChoice': function(token) {
			var choice = new Element('li', {
				'class': 'autocompleter-choices', 
				'html': token.photo, 
				'id':token.label
				});
				new Element('div', {
					'html': this.markQueryValue(token.label),
					'class': 'autocompleter-choice'
				}).inject(choice);
				this.addChoiceEvents(choice).inject(this.choices);
				choice.store('autocompleteChoice', token);
		  }
		});
		contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
		});
	});
	sesJqueryObject('#loadingimgeblogreview-wrapper').hide();
</script>