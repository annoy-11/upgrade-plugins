

<?php 

if(empty($_SESSION['myCounter'])) {
	$_SESSION['myCounter'] = 1;
} else { 
 $_SESSION['myCounter'] = $_SESSION['myCounter'] + 1;
}
$counter = $_SESSION['myCounter']; 
?>
 <?php if(!is_null($this->widgetName)):?>
  <?php $content = $this->widgetName.$counter;?>
<?php else:?>
  <?php $content = $this->identity.$counter;?>
<?php endif;?>

<?php $base_url = $this->layout()->staticBaseUrl;?>
<div class="header_searchbox">
  <div class="header_searchbox_button">
    <button class="sesadvheader_search_btn"><i class="fa fa-search"></i></button>
  </div>
  <?php if(in_array('search',$this->header_options)): ?>
    <div class="header_searchbox_selectbox">
      <div class="exp_select">
        <span id="<?php echo $counter."_"; ?>exp_select_value" class="sesadvheader_search_optn"><?php echo $this->translate('All');?><i class="fa fa-angle-down"></i></span>
        <div id="<?php echo $counter."_"; ?>exp_select_option" value="<?php //echo $key;?>" class="exp_select_option">
	  <ul class="sesbasic_clearfix search_box_dropdown">
	    <?php foreach($this->types as $key => $type):?>
	      <?php $explodedType = explode('_type_info_',$type); ?>
	      <?php if(!empty($explodedType[2])):?>
		<?php $title = $this->translate($explodedType[2]);?>
	      <?php else:?>
		<?php $title = $this->translate($explodedType[0]);?>
	      <?php endif;?>
	      <li class="sesbasic_clearfix <?php if(isset($_GET['type']) && ($_GET['type'] == $key)):?> selected <?php endif;?> " id="<?php echo $counter."_"; ?>show_type_<?php echo $key;?>" onclick="typevalue<?php echo $counter."_"; ?>('<?php echo $key;?>', '<?php echo $this->translate($title);?>')">
	        <?php if(!empty($explodedType[1])):?>
	          <img src="<?php echo Engine_Api::_()->storage()->get($explodedType[1], '')->getPhotoUrl() ?>" align="left" alt="">
	        <?php else: ?>
	          <?php if($explodedType[0] == 'ITEM_TYPE_VIDEO'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/video.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_ALBUM'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/album.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_ALBUM_PHOTO'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/photo.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_USER'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/user.png'; ?>" align="left" alt="">
					  <?php elseif($explodedType[0] == 'ITEM_TYPE_BLOG'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/blog.png'; ?>" align="left" alt="">
					  <?php elseif($explodedType[0] == 'ITEM_TYPE_BLOG'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/blog.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_CLASSIFIED'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/classified.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_EVENT'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/event.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_GROUP'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/group.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_FORUM_POST'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/topic.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_FORUM_TOPIC'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/topic.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_MUSIC_PLAYLIST'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/music-album.png'; ?>" align="left" alt="">
						<?php elseif($explodedType[0] == 'ITEM_TYPE_MUSIC_PLAYLIST_SONG'): ?>
							<img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search-icons/song.png'; ?>" align="left" alt="">
	          <?php else: ?>
						  <img src="<?php echo $base_url.'application/modules/Sesadvancedheader/externals/images/search.png'; ?>" align="left" alt="">
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
    <input placeholder="<?php echo $this->translate('Search'); ?>" value="<?php echo !empty($_GET['query']) ? $_GET['query'] : ""; ?>" id="<?php echo $counter."_"; ?>sesadvheader_title" type="text" name="name" />
  </div>
</div>
<input type="hidden" class="search_hidden_val" id="<?php echo $counter."_"; ?>exp_type_value" value="">
<script type="text/javascript">
  //Take refrences from "/application/modules/Blog/views/scripts/index/create.tpl"
  var searchAutocomplete;
  en4.core.runonce.add(function() {
    searchAutocomplete = new Autocompleter.Request.JSON('<?php echo $counter."_"; ?>sesadvheader_title', "<?php echo $this->url(array('module' => 'sesadvancedheader', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
      'postVar': 'text',
      'delay' : 250,      
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest',
      'postData': {
        'type': ''
      },
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


  function typevalue<?php echo $counter."_"; ?>(value, mainValue) {
  
    $$('.sesbasic_clearfix').removeClass('selected');
    document.getElementById('<?php echo $counter."_"; ?>show_type_'+value).addClass('selected');
   
    document.getElementById('<?php echo $counter."_"; ?>exp_type_value').value = value;
    document.getElementById('<?php echo $counter."_"; ?>exp_select_value').innerHTML = mainValue+'<i class="fa fa-angle-down sesadvheader_search_optn"></i>';
    document.getElementById('<?php echo $counter."_"; ?>exp_select_option').removeClass('show-options');
    
    searchAutocomplete.setOptions({
      'postData': {
        'type': value
      }
    });
  }
  
  function showAllSearchResults() {
  
    if($('all')) {
      $('all').removeEvents('click');
    }

    if($('<?php echo $counter."_"; ?>exp_type_value').value != 'Everywhere' && typeof $('<?php echo $counter."_"; ?>exp_type_value').value != 'undefined') {
      window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('<?php echo $counter."_"; ?>sesadvheader_title').value+'&type='+$('<?php echo $counter."_"; ?>exp_type_value').value;
    }
    else {
      window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('<?php echo $counter."_"; ?>sesadvheader_title').value;
    }
  }
      
  sesJqueryObject(document).ready(function() {
    sesJqueryObject('#<?php echo $counter."_"; ?>sesadvheader_title').keydown(function(e) {
      if (e.which === 13) {
        showAllSearchResults();
      }
    });
  });
  <?php if(!empty($_GET['type'])){ ?>
   en4.core.runonce.add(function() {
    sesJqueryObject('#<?php echo $counter."_"; ?>show_type_<?php echo $_GET['type'];?>').trigger('click');
   });
  <?php } ?>
</script>