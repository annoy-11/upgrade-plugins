<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: linked-business.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $base_url = $this->layout()->staticBaseUrl;?>
<?php $this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');?>
<?php if(!$this->is_ajax){ ?>
<?php echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array('business' => $this->business));?>
	<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<h2><?php echo $this->translate('Linked Businesses') ?></h2>
<p>
  <?php echo $this->translate('You can LInk your businesses to Choose businesses from auto suggest which you want to Link . You can find the list of Businesses which are linked to your Business. You can unlink those Businesses directly from here, without going to their view page.') ?>
</p>
<br />	
<form id="sesbusiness_change_owner" action="<?php echo $this->url(array('business_id' => $this->business->custom_url, 'action'=>'linked-business'), 'sesbusiness_dashboard', true); ?>" method="post">
  <input type="hidden" value="" id="business_id" name="business_id" />
  <input type="text" name="search_text" id="search_text" value="" placeholder="<?php echo $this->translate("What are you planning?"); ?>" />
  <button type="submit"><?php echo $this->translate("Link to Business"); ?></button>
</form><br />
<?php echo $this->paginationControl($this->paginator); ?>
<?php if( count($this->paginator) ): ?>
 <ul class="sesbusiness_business_listing sesbasic_clearfix clear" style="min-height:50px;">
  <?php foreach ($this->paginator as $business): ?>
    <li class="sesbusiness_list_item" id="sesbusiness_manage_listing_item_<?php echo $business->getIdentity(); ?>">
      <article class="sesbasic_clearfix">
        <div class="_thumb sesbusiness_thumb" style="height:;width:;">
          <a href="<?php echo $business->getHref();?>" class="sesbusiness_thumb_img sesbusiness_browse_location_<?php echo $business->getIdentity(); ?>">
            <span style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
          </a>
        </div>
        <div class="_cont">
          <div class="_title">
            <a href="<?php echo $business->getHref();?>" class='sesbusiness_browse_location_<?php echo $business->getIdentity(); ?>'><?php echo $business->getTitle();?></a>
          </div>
          <?php if(!$business->active):?>
            <div class="tip">
              <span>
                <?php echo $this->translate("This Business is pending approval by owner of the Business.") ?>
              </span>
            </div>
          <?php endif;?>
        </div>
      </article>
    </li>
  <?php endforeach;?>
 </ul>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are currently no linked businesses.") ?>
    </span>
  </div>
<?php endif; ?>
    <?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>

<script type='text/javascript'>
 var Searchurl = "<?php echo $this->url(array('business_id' => $this->business->custom_url,'action'=>'search-business'), 'sesbusiness_dashboard', true); ?>";
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
      var to =  selected.retrieve('autocompleteChoice');
      sesJqueryObject('#business_id').val(to.id);
    });
  });
</script>
