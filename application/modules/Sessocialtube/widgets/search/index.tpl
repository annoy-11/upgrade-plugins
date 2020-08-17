<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $base_url = $this->layout()->staticBaseUrl;?>
<div class="header_searchbox">
  <div class="header_searchbox_button">
    <button onclick="javascript:showAllSearchResults();"><i class="fa fa-search"></i></button>
  </div>
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialtube.searchleftoption', 1) && count($this->types) > 0): ?>
    <div class="header_searchbox_selectbox">
      <div class="socialtube_select">
	<span id="socialtube_select_value"><?php echo $this->translate('Everywhere');?><i class="fa fa-angle-down"></i></span>
	<div id="socialtube_select_option" value="<?php //echo $key;?>" class="socialtube_select_option">
	  <ul class="sesbasic_clearfix">
	    <?php foreach($this->types as $key => $type):?>
	      <?php $explodedType = explode('_type_info_',$type); //print_R($explodedType[0]); ?>
	      <?php if(!empty($explodedType[2])):?>
		<?php $title = $this->translate($explodedType[2]);?>
	      <?php else:?>
		<?php $title = $this->translate($explodedType[0]);?>
	      <?php endif;?>
	      <li class="sesbasic_clearfix <?php if(isset($_GET['type']) && ($_GET['type'] == $key)):?> selected <?php endif;?> " id="show_type_<?php echo $key;?>" onclick="typevalue('<?php echo $key;?>', '<?php echo $this->translate($title);?>')">
	        <?php if(!empty($explodedType[1])):?>
	          <img src="<?php echo Engine_Api::_()->storage()->get($explodedType[1], '')->getPhotoUrl() ?>" align="left" alt="">
	        <?php else: ?>
	          <?php if($explodedType[0] == 'ITEM_TYPE_VIDEO'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/video.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_ALBUM'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/album.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_ALBUM_PHOTO'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/photo.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_USER'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/user.png'; ?>" align="left" alt="">
					  <?php elseif($explodedType[0] == 'ITEM_TYPE_BLOG'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/blog.png'; ?>" align="left" alt="">
					  <?php elseif($explodedType[0] == 'ITEM_TYPE_BLOG'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/blog.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_CLASSIFIED'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/classified.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_EVENT'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/event.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_GROUP'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/group.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_FORUM_POST'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/topic.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_FORUM_TOPIC'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/topic.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_MUSIC_PLAYLIST'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/music-album.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_MUSIC_PLAYLIST_SONG'): ?>
							<img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search-icons/song.png'; ?>" align="left" alt="">
	          <?php else: ?>
						  <img src="<?php echo $base_url.'application/modules/Sessocialtube/externals/images/search.png'; ?>" align="left" alt="">
					  <?php endif;?>
					<?php endif;?>
		<div><?php echo $this->translate($title);?></div>
	      </li>
	    <?php endforeach;?>
	  </ul>
	</div>
      </div>
    </div>
  <?php endif; ?>
  <div class="header_searchbox_input">
      <input placeholder="<?php echo $this->translate('Search'); ?>" id="sessocialtube_title" type="text" name="name" />
  </div>
</div>
<div id="socialtube_type_value"></div>
<script type="text/javascript">

  function typevalue(value, mainValue) {
    $$('.sesbasic_clearfix').removeClass('selected');
    document.getElementById('show_type_'+value).addClass('selected');
    document.getElementById('socialtube_type_value').value = value;
    document.getElementById('socialtube_select_value').innerHTML = mainValue+'<i class="fa fa-angle-down"></i>';
    setCookieSessocialtube("sessocialtube_commonsearch", value, 1);
    document.getElementById('socialtube_select_option').removeClass('show-options');
  }

  //Take refrences from "/application/modules/Blog/views/scripts/index/create.tpl"
  en4.core.runonce.add(function() {
    setCookieSessocialtube("sessocialtube_commonsearch", "", -3600);
    var searchAutocomplete = new Autocompleter.Request.JSON('sessocialtube_title', "<?php echo $this->url(array('module' => 'sessocialtube', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
      'postVar': 'text',
      'delay' : 250,      
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest',
			'indicatorClass':'input_loading',
      'injectChoice': function(token) {
        if(token.url != 'all') {
	  var choice = new Element('li', {
	    'class': 'autocompleter-choices',
	    'html': token.photo,
	    'id': token.label
	  });
	  new Element('div', {
	    'html': this.markQueryValue(token.label),
	    'class': 'autocompleter-choice'
	  }).inject(choice);
	  new Element('div', {
	    'html': this.markQueryValue(token.resource_type),
	    'class': 'autocompleter-choice bold'
	  }).inject(choice);
	  choice.inputValue = token;
	  this.addChoiceEvents(choice).inject(this.choices);
	  choice.store('autocompleteChoice', token);
        }
        else {
         var choice = new Element('li', {
	    'class': 'autocompleter-choices',
	    'html': '',
	    'id': 'all'
	  });
	  new Element('div', {
	    'html': 'Show All Results',
	    'class': 'autocompleter-choice',
	    onclick: 'javascript:showAllSearchResults();'
	  }).inject(choice);
	  choice.inputValue = token;
	  this.addChoiceEvents(choice).inject(this.choices);
	  choice.store('autocompleteChoice', token);
        }
      }
    });
    searchAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
      var url = selected.retrieve('autocompleteChoice').url;
      window.location.href = url;
    });
  });
  function showAllSearchResults() {
  
    if($('all')) {
      $('all').removeEvents('click');
    }
    if($('socialtube_type_value').value != 'Everywhere' && typeof $('socialtube_type_value').value != 'undefined') {
      window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('sessocialtube_title').value+'&type='+$('socialtube_type_value').value;
    }
    else
    window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('sessocialtube_title').value;
  }
</script>
<script>
if($('socialtube_select_value')) {
  $('socialtube_select_value').addEvent('click', function(event){
    event.stop();
    //if($('socialtube_select_option')) {
	    if($('socialtube_select_option').hasClass('show-options'))
		    $('socialtube_select_option').removeClass('show-options');
    //} else {
	    if($('socialtube_select_option'))
		    $('socialtube_select_option').addClass('show-options');
    //}
    return false;
  });
}

window.addEvent('domready', function() {
  $(document.body).addEvent('click', function(event){
		if(document.getElementById('socialtube_select_option'))
   	 document.getElementById('socialtube_select_option').removeClass('show-options');
  });
});
</script>