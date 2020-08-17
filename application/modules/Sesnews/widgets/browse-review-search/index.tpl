<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesnews
 * @package    Sesnews
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesnews/externals/styles/styles.css'); ?>
<?php $base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php if(!$this->widgetIdentity) { ?>
	<div class="sesnews_browse_reviews_search sesbasic_bxs sesbasic_clearfix <?php echo $this->view_type == 'horizontal' ? 'sesnews_browse_review_search_horizontal' : 'sesnews_browse_review_search_vertical'; ?>">
<?php } ?>
<?php echo $this->form->render($this) ?>
<?php if(!$this->widgetIdentity) { ?>
	</div>
<?php } ?>
<script type="application/javascript">
  sesJqueryObject('#loadingimgsesnewsreview-wrapper').hide();
</script>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php if($controllerName == 'review' && $actionName == 'browse'){ ?>
  <?php $identity = Engine_Api::_()->sesbasic()->getIdentityWidget('sesnews.browse-reviews','widget','sesnews_review_browse'); ?>
	<?php if($identity):?>
		<script type="application/javascript">
			sesJqueryObject(document).ready(function(){
				sesJqueryObject('#filter_form_review').submit(function(e){	
					if(sesJqueryObject('.sesnews_review_listing').length > 0){
						e.preventDefault();
						sesJqueryObject('#loadingimgsesnewsreview-wrapper').show();
						is_search_<?php echo $identity; ?> = 1;
						if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
							sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $identity?>').css('display', 'block');
							isSearch = true;
							e.preventDefault();
							searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
							sesJqueryObject('#loadingimgsesnewsreview-wrapper').show();
							paggingNumber<?php echo $identity; ?>(1);
						}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
							sesJqueryObject('#sesnews_review_listing').html('');
							sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
							isSearch = true;
							e.preventDefault();
							searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
							page<?php echo $identity; ?> = 1;
							sesJqueryObject('#loadingimgsesnewsreview-wrapper').show();
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
				sesJqueryObject('#loadingimgsesnewsreview-wrapper').show();
				<?php $identity = $this->widgetIdentity; ?>
				if(sesJqueryObject('.sesnews_review_listing').length > 0){	
					e.preventDefault();
					sesJqueryObject('#loadingimgsesnewsreview-wrapper').show();
					is_search_<?php echo $identity; ?> = 1;
					if(typeof paggingNumber<?php echo $identity; ?> == 'function'){
						sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $identity?>').css('display', 'block');
						searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
						sesJqueryObject('#loadingimgsesnewsreview-wrapper').show();
						paggingNumber<?php echo $identity; ?>(1);
					}else if(typeof viewMore_<?php echo $identity; ?> == 'function'){
						sesJqueryObject('#sesnews_review_listing').html('');
						sesJqueryObject('#loading_image_<?php echo $identity; ?>').show();
						searchParams<?php echo $identity; ?> = sesJqueryObject(this).serialize();
						page<?php echo $identity; ?> = 1;
						sesJqueryObject('#loadingimgsesnewsreview-wrapper').show();
						viewMore_<?php echo $identity; ?>();
					}
				}
				return true;
			});	
	  });
	</script>
<?php } ?>
<script type="text/javascript">
	var Searchurl = "<?php echo $this->url(array('module' =>'sesnews','controller' => 'index', 'action' => 'get-review'),'default',true); ?>";
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
	sesJqueryObject('#loadingimgsesnewsreview-wrapper').hide();
</script>
