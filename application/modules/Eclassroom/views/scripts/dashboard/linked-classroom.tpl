<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: linked-classroom.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
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
<?php echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array('classroom' => $this->classroom));?>
	<div class="classroom_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<h2><?php echo $this->translate('Linked Classrooms') ?></h2>
<p>
  <?php echo $this->translate('You can Link your Classrooms to Choose Classrooms from auto suggest which you want to Link . You can find the list of Classrooms which are linked to your Classroom. You can unlink those Classrooms directly from here, without going to their view page.') ?>
</p>
<br />	
<form id="classroom_change_owner" action="<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url, 'action'=>'linked-classroom'), 'eclassroom_dashboard', true); ?>" method="post">
  <input type="hidden" value="" id="classroom_id" name="classroom_id" />
  <input type="text" name="search_text" id="search_text" value="" placeholder="<?php echo $this->translate("What are you planning?"); ?>" />
  <button type="submit"><?php echo $this->translate("Link to Classroom"); ?></button>
</form><br />
<?php echo $this->paginationControl($this->paginator); ?>
<?php if( count($this->paginator) ): ?>
 <ul class="classroom_store_listing sesbasic_clearfix clear" style="min-height:50px;">
  <?php foreach ($this->paginator as $classroom): ?>
    <li class="classroom_list_item" id="classroom_manage_listing_item_<?php echo $classroom->getIdentity(); ?>">
      <article class="sesbasic_clearfix">
        <div class="_thumb classroom_thumb">
          <a href="<?php echo $classroom->getHref();?>" class="classroom_thumb_img classroom_browse_location_<?php echo $classroom->getIdentity(); ?>">
            <span style="background-image:url(<?php echo $classroom->getPhotoUrl('thumb.profile'); ?>);"></span>
          </a>
        </div>
        <div class="_cont">
          <div class="_title">
            <a href="<?php echo $classroom->getHref();?>" class='classroom_browse_location_<?php echo $classroom->getIdentity(); ?>'><?php echo $classroom->getTitle();?></a>
          </div>
          <?php if(!$classroom->active):?>
            <div class="tip">
              <span>
                <?php echo $this->translate("This Classroom is pending approval by owner of the Classroom.") ?>
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
      <?php echo $this->translate("There are currently no linked Classrooms.") ?>
    </span>
  </div>
<?php endif; ?>
    <?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>

<script type='text/javascript'>
 var Searchurl = "<?php echo $this->url(array('classroom_id' => $this->classroom->custom_url,'action'=>'search-classroom'), 'eclassroom_dashboard', true); ?>";
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
      sesJqueryObject('#classroom_id').val(to.id);
    });
  });
</script>
