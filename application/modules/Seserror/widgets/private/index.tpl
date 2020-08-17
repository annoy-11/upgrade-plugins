<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet">
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seserror/externals/styles/style.css'); ?>
<?php //$photo = Engine_Api::_()->storage()->get($params['photo_id'], '')->getPhotoUrl(); ?>
<div class="private_page_main_container">
  <div class="<?php if($this->default_activate == 1): ?>private_page_two_container<?php elseif($this->default_activate == 2): ?> private_page_one_container <?php elseif($this->default_activate == 3): ?> private_page_three_container <?php elseif($this->default_activate == 4): ?> private_page_four_container full-bradiusalls <?php elseif($this->default_activate == 5): ?> private_page_five_container gost_container <?php elseif($this->default_activate == 6): ?> private_page_six_container <?php elseif($this->default_activate == 7): ?> private_page_seven_container <?php elseif($this->default_activate == 8): ?> private_page_eight_container <?php endif; ?>">
  	<div class="rain_icon">
    	<span class="rain2"></span>
      <span class="rain3"></span>
      <span class="rain4"></span>
      <span class="rain5"></span>
      <span class="rain6"></span>
      <span class="rain7"></span>
      <span class="rain8"></span>
      <span class="rain9"></span>
      <span class="rain10"></span>
      <span class="rain11"></span>
      <span class="rain12"></span>
      
    </div>
      <div class="ghost">
		    <div class="eyes"></div>
		    <div class="eyes"></div>
		    <div class="mouth"></div>
		    <div class="gooey left">
		      <div class="out"></div>
		    </div>
		    <div class="gooey mleft">
		      <div class="out"></div>
		    </div>
		    <div class="gooey mright">
		      <div class="out"></div>
		    </div>
		    <div class="gooey right">
		      <div class="out"></div>
		    </div>
		    <div class="gooey last">
		      <div class="out"></div>
		    </div>
		  </div>
 	 <div>
        <span class="bradius2"></span>
        <span class="bradius3"></span>
        <span class="bradius4"></span> 
        <span class="bradius5"></span>
        <span class="bradius6"></span>
        <span class="bradius7"></span>
        <span class="bradius8"></span>
        <span class="bradius9"></span>
        <span class="bradius10"></span>
        <span class="bradius11"></span>
        <span class="bradius12"></span>
        <span class="bradius13"></span>
        <span class="bradius14"></span>
        <span class="bradius15"></span>
        <span class="bradius16"></span>
        <span class="bradius17"></span>
        <span class="bradius18"></span>
        <span class="bradius19"></span>
        <span class="bradius20"></span>
     </div>
    <div class="container_row">
      <?php if($this->text1): ?>
      	<div class="main_tittle">
        <h2><?php echo $this->translate($this->text1); ?></h2>
      </div>
      <?php endif; ?>
      <?php if($this->text2): ?>
      <div class="small_tittle">
        <p><?php echo $this->translate($this->text2); ?></p>
      </div>
      <?php endif; ?>
      <?php //if($photo): ?>
      <div class="maintenance_icon">
        <?php if($this->privatepagephotoID): ?>
          <?php $photo = Engine_Api::_()->storage()->get($this->privatepagephotoID, '');
                if($photo)
                  $photo = $photo->getPhotoUrl(); ?>
          <img src="<?php echo $photo; ?>">
        <?php else: ?>
            <img src="application/modules/Seserror/externals/images/private/<?php echo $this->default_activate?>.png">
        <?php endif; ?>
      </div>
      <?php //endif; ?>
      <?php if($this->text3): ?>
        <div class="discrtiption">
          <p><?php echo $this->translate($this->text3); ?></p>
        </div>
      <?php  endif; ?>
      <?php if($this->showsearch): ?>
      <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
        <div class="private_page_form">
          <span><input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value=""></span>
          <button type="submit"><i class="fa fa-search"></i></button>
        </div>
      </form>
      <?php endif; ?>
      <?php if($this->showhomebutton || $this->showbackbutton): ?>
        <div class="footer_section">
          <?php if($this->showhomebutton): ?>
            <div class="home_button">
              <a href=""><?php echo $this->translate("Home"); ?></a>
            </div>
          <?php endif; ?>
          <?php if($this->showbackbutton): ?>
            <div class="back_button">
              <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><?php echo $this->translate("Go Back"); ?></a>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<script type="text/javascript">

  //Take refrences from "/application/modules/Blog/views/scripts/index/create.tpl"
  var searchAutocomplete;
  en4.core.runonce.add(function() {

    searchAutocomplete = new Autocompleter.Request.JSON('global_search_field', "<?php echo $this->url(array('module' => 'seserror', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
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
            onclick: 'javascript:showAllSearchResultsError();'
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
    
  sesJqueryObject(document).ready(function() {
    sesJqueryObject('#global_search_field').keydown(function(e) {
      if (e.which === 13) {
        showAllSearchResultsError();
      }
    });
  });
  
  function showAllSearchResultsError() {
  
    if($('all')) {
      $('all').removeEvents('click');
    }
    window.location.href= '<?php echo $this->url(array("controller" => "search"), "default", true); ?>' + "?query=" + $('global_search_field').value;
  }
</script>