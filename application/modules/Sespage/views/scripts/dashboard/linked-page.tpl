<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: linked-page.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
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
<?php echo $this->partial('dashboard/left-bar.tpl', 'sespage', array('page' => $this->page));?>
	<div class="sespage_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<h2><?php echo $this->translate('Linked Pages') ?></h2>
<p>
  <?php echo $this->translate('You can LInk your pages to Choose pages from auto suggest which you want to Link . You can find the list of Pages which are linked to your Page. You can unlink those Pages directly from here, without going to their view page.') ?>
</p>
<br />	
<form id="sespage_change_owner" action="<?php echo $this->url(array('page_id' => $this->page->custom_url, 'action'=>'linked-page'), 'sespage_dashboard', true); ?>" method="post">
  <input type="hidden" value="" id="page_id" name="page_id" />
  <input type="text" name="search_text" id="search_text" value="" placeholder="<?php echo $this->translate("What are you planning?"); ?>" />
  <button type="submit"><?php echo $this->translate("Link to Page"); ?></button>
</form><br />
<?php echo $this->paginationControl($this->paginator); ?>
<?php if( count($this->paginator) ): ?>
 <ul class="sespage_page_listing sesbasic_clearfix clear" style="min-height:50px;">
  <?php foreach ($this->paginator as $page): ?>
    <li class="sespage_list_item" id="sespage_manage_listing_item_<?php echo $page->getIdentity(); ?>">
      <article class="sesbasic_clearfix">
        <div class="_thumb sespage_thumb" style="height:;width:;">
          <a href="<?php echo $page->getHref();?>" class="sespage_thumb_img sespage_browse_location_<?php echo $page->getIdentity(); ?>">
            <span style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile'); ?>);"></span>
          </a>
        </div>
        <div class="_cont">
          <div class="_title">
            <a href="<?php echo $page->getHref();?>" class='sespage_browse_location_<?php echo $page->getIdentity(); ?>'><?php echo $page->getTitle();?></a>
          </div>
          <?php if(!$page->active):?>
            <div class="tip">
              <span>
                <?php echo $this->translate("This Page is pending approval by owner of the Page.") ?>
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
      <?php echo $this->translate("There are currently no linked pages.") ?>
    </span>
  </div>
<?php endif; ?>
    <?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>

<script type='text/javascript'>
 var Searchurl = "<?php echo $this->url(array('page_id' => $this->page->custom_url,'action'=>'search-page'), 'sespage_dashboard', true); ?>";
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
      sesJqueryObject('#page_id').val(to.id);
    });
  });
</script>