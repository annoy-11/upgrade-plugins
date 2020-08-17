<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: linked-group.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
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
<?php echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array('group' => $this->group));?>
	<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<h2><?php echo $this->translate('Linked Groups') ?></h2>
<p>
  <?php echo $this->translate('You can LInk your groups to Choose groups from auto suggest which you want to Link . You can find the list of Groups which are linked to your Group. You can unlink those Groups directly from here, without going to their view group.') ?>
</p>
<br />	
<form id="sesgroup_change_owner" action="<?php echo $this->url(array('group_id' => $this->group->custom_url, 'action'=>'linked-group'), 'sesgroup_dashboard', true); ?>" method="post">
  <input type="hidden" value="" id="group_id" name="group_id" />
  <input type="text" name="search_text" id="search_text" value="" placeholder="<?php echo $this->translate("What are you planning?"); ?>" />
  <button type="submit"><?php echo $this->translate("Link to Group"); ?></button>
</form><br />
<?php echo $this->paginationControl($this->paginator); ?>
<?php if( count($this->paginator) ): ?>
 <ul class="sesgroup_group_listing sesbasic_clearfix clear" style="min-height:50px;">
  <?php foreach ($this->paginator as $group): ?>
    <li class="sesgroup_list_item" id="sesgroup_manage_listing_item_<?php echo $group->getIdentity(); ?>">
      <article class="sesbasic_clearfix">
        <div class="_thumb sesgroup_thumb" style="height:;width:;">
          <a href="<?php echo $group->getHref();?>" class="sesgroup_thumb_img sesgroup_browse_location_<?php echo $group->getIdentity(); ?>">
            <span style="background-image:url(<?php echo $group->getPhotoUrl('thumb.profile'); ?>);"></span>
          </a>
        </div>
        <div class="_cont">
          <div class="_title">
            <a href="<?php echo $group->getHref();?>" class='sesgroup_browse_location_<?php echo $group->getIdentity(); ?>'><?php echo $group->getTitle();?></a>
          </div>
          <?php if(!$group->active):?>
            <div class="tip">
              <span>
                <?php echo $this->translate("This Group is pending approval by owner of the Group.") ?>
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
      <?php echo $this->translate("There are currently no linked groups.") ?>
    </span>
  </div>
<?php endif; ?>
    <?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>

<script type='text/javascript'>
 var Searchurl = "<?php echo $this->url(array('group_id' => $this->group->custom_url,'action'=>'search-group'), 'sesgroup_dashboard', true); ?>";
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
      sesJqueryObject('#group_id').val(to.id);
    });
  });
</script>