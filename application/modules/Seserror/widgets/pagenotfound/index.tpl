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
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seserror/externals/styles/page_not_found_css.css'); ?>

<?php
//   $photo_id = $params['photo_id'];
//   if($photo_id) {
//     $img_path = Engine_Api::_()->storage()->get($photo_id, '')->getPhotoUrl();
//     $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
//   }
  ?>
<div class="ses_page_not_found_main">
  <div class="ses_page_not_found_container">
  
    <?php if($this->default_activate == 1): ?>
      <!--Error page tamepate one -->
      <div class="ses_page_not_found_one_row">
        <?php if($this->text1): ?>
          <div class="ses_not_found_main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="ses_not_found_mini_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <div class="ses_not_found_img">
          <?php if($this->pagenotfoundphotoID): ?>
            <?php $photo = Engine_Api::_()->storage()->get($this->pagenotfoundphotoID, '');
              if($photo)
                $photo = $photo->getPhotoUrl(); ?>
            <img src="<?php echo $photo; ?>">
          <?php else: ?>
              <img src="application/modules/Seserror/externals/images/pagenotfound/4.png" />
          <?php endif; ?>
        </div>
        <?php if($this->text1 || $this->showsearch || $this->showhomebutton): ?>
          <div class="ses_not_found_main_content">
            <div class="ses_not_found_main_content_inner">
              <?php if($this->text1): ?>
                <p class="small_tittle"><?php echo $this->translate($this->text3); ?></p>
              <?php endif; ?>
              <?php if($this->showsearch): ?>
                <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
                  <div class="ses_not_found_form">                    
                    <span><input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value=""></span>
                    <button type="submit" class=""><?php echo $this->translate("Search"); ?></button>
                  </div>
                </form>
              <?php endif; ?>
              <?php if($this->showhomebutton): ?>
                <p class="home_link">
                  <a href='javascript:void(0);' onClick='history.go(-1);'><?php echo $this->translate("Go Back"); ?></a>
                </p>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    <?php elseif($this->default_activate == 2): ?>
     <?php if($this->pagenotfoundphotoID): ?>
        <?php $photo = Engine_Api::_()->storage()->get($this->pagenotfoundphotoID, '');
          if($photo)
            $photo = $photo->getPhotoUrl(); ?>
      <?php endif; ?>
      <!--Error page tamepate two-->
      <div class="ses_page_not_found_two_row" <?php if(!empty($photo)): ?> style="background-image:url(<?php echo $photo; ?>);" <?php endif; ?>>
        <div class="ses_page_not_found_center">
         <?php if($this->text1): ?>
            <div class="ses_not_found_main_tittle">
              <p><?php echo $this->translate($this->text1); ?></p>
            </div>
        <?php endif; ?>
          <?php if($this->text2): ?>
            <div class="ses_not_found_mini_tittle">
              <p><?php echo $this->translate($this->text2); ?></p>
            </div>
          <?php endif; ?>
          <?php if($this->text3): ?>
            <div class="ses_not_found_discrtiption">
              <p><?php echo $this->translate($this->text3); ?></p>
            </div>
          <?php endif; ?>
          <?php if($this->showsearch): ?>
            <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
              <div class="ses_not_found_form">
                <input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value="">
                <button type="submit" class=""><?php echo $this->translate("Search"); ?></button>
              </div>
            </form>
          <?php endif; ?>
          <?php if($this->showbackbutton): ?>
            <p class="home_link">
              <a href='javascript:void(0);' onClick='history.go(-1);'>
                <?php echo $this->translate("Go Back"); ?>
              </a>
            </p>
          <?php endif; ?>
        </div>
      </div>
    <?php elseif($this->default_activate == 3): ?>
      <?php if($this->pagenotfoundphotoID): ?>
        <?php $photo = Engine_Api::_()->storage()->get($this->pagenotfoundphotoID, '');
          if($photo)
            $photo = $photo->getPhotoUrl(); ?>
      <?php endif; ?>
      <div class="ses_page_not_found_three_row" <?php if(!empty($photo)): ?> style="background-image:url(<?php echo $photo; ?>);" <?php endif; ?>>
        <?php if($this->text1): ?>
          <div class="ses_not_found_main_tittle">
            <p><?php echo $this->translate($this->text1); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="ses_not_found_discrtiption">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        
        <div class="ses_not_found_form">
          <?php if($this->text3): ?>
            <p><?php echo $this->translate($this->text3); ?></p>
          <?php endif; ?>
          <?php if($this->showsearch): ?>
            <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
              <input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value="">
              <button type="submit" class=""><?php echo $this->translate("Search"); ?></button>
            </form>
          <?php endif; ?>
        </div>
        <?php if($this->showbackbutton): ?>
          <p class="home_link">
            <a href='javascript:void(0);' onClick='history.go(-1);'><i class="fa fa-arrow-circle-o-left"></i>&nbsp;<?php echo $this->translate("Go Back"); ?></a>
          </p>
        <?php endif; ?>
      </div>
    <?php elseif($this->default_activate == 4): ?>
      <?php if($this->pagenotfoundphotoID): ?>
        <?php $photo = Engine_Api::_()->storage()->get($this->pagenotfoundphotoID, '');
          if($photo)
            $photo = $photo->getPhotoUrl(); ?>
      <?php endif; ?>
      <div class="ses_page_not_found_four_row" <?php if(!empty($photo)): ?> style="background-image:url(<?php echo $photo; ?>);" <?php endif; ?>>
        <?php if($this->text1): ?>
          <div class="ses_not_found_main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="ses_not_found_mini_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <div class="ses_not_found_main_content">
          <div class="ses_not_found_main_content_inner">
            <p class="small_tittle"><?php echo $this->translate($this->text3); ?></p>
            <?php if($this->showsearch): ?>
              <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
                <div class="ses_not_found_form">
                  <span><input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value=""></span>
                  <button type="submit" class=""><?php echo $this->translate("Search"); ?></button>
                </div>
              </form>
            <?php endif; ?>
            <?php if($this->showbackbutton): ?>
              <p class="home_link">
                <a href='javascript:void(0);' onClick='history.go(-1);'>
                 <?php echo $this->translate("Go Back"); ?>
                </a>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php elseif($this->default_activate == 5): ?>
      <div class="ses_page_not_found_five_row">
        <?php //if($path): ?>
          <div class="ses_not_found_main_tittle">
            <h2>
              <?php if($this->pagenotfoundphotoID): ?>
                <?php $photo = Engine_Api::_()->storage()->get($this->pagenotfoundphotoID, '');
                  if($photo)
                    $photo = $photo->getPhotoUrl(); ?>
                <img src="<?php echo $photo; ?>">
              <?php else: ?>
                <img src="application/modules/Seserror/externals/images/pagenotfound/1.png" />
              <?php endif; ?>
            </h2>
          </div>
        <?php //endif; ?>
        <?php if($this->text2): ?>
          <div class="ses_not_found_mini_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <div class="ses_not_found_main_content">
          <div class="ses_not_found_main_content_inner">
            <?php if($this->text3): ?>
              <p class="small_tittle"><?php echo $this->translate($this->text3); ?></p>
            <?php endif; ?>
            <?php if($this->showbackbutton || $this->showsearch): ?>
              <div class="ses_not_found_form">
                <?php if($this->showbackbutton): ?>
                  <p class="home_link"><a href='javascript:void(0);' onClick='history.go(-1);'><?php echo $this->translate("Go Back"); ?></a></p>
                <?php endif; ?>
                <?php if($this->showsearch): ?>
                  <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
                  <input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value="">
                  </form>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php elseif($this->default_activate == 6): ?>
      <?php if($this->pagenotfoundphotoID): ?>
        <?php $photo = Engine_Api::_()->storage()->get($this->pagenotfoundphotoID, '');
          if($photo)
            $photo = $photo->getPhotoUrl(); ?>
      <?php endif; ?>
      <div class="ses_page_not_found_six_row" <?php if(!empty($photo)): ?> style="background-image:url(<?php echo $photo; ?>);" <?php endif; ?>>
        <?php if($this->text1): ?>
          <div class="ses_not_found_main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
        <div class="ses_not_found_mini_tittle">
          <p><?php echo $this->translate($this->text2); ?></p>
        </div>
        <?php endif; ?>
        <div class="ses_not_found_main_content">
          <div class="ses_not_found_main_content_inner">
            <?php if($this->text3): ?>
              <p class="small_tittle"><?php echo $this->translate($this->text3); ?></p>
            <?php endif; ?>
            <?php if($this->showhomebutton || $this->showsearch): ?>
              <div class="ses_not_found_form">
                <?php if($this->showhomebutton): ?>
                  <p class="home_link"><a href='javascript:void(0);' onClick='history.go(-1);'><?php echo $this->translate("Go Back"); ?></a></p>
                <?php endif; ?>
                <?php if($this->showsearch): ?>
                  <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
                  <input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value="">
                  </form>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php elseif($this->default_activate == 7): ?>
      <div class="ses_page_not_found_seven_row">
        <div class="ses_not_found_top_content">
          <?php if($this->text1): ?>
            <div class="ses_not_found_main_tittle">
              <h2><?php echo $this->translate($this->text1); ?></h2>
            </div>
          <?php endif; ?>
          <?php if($this->text2): ?>
            <div class="ses_not_found_mini_tittle">
              <p><?php echo $this->translate($this->text2); ?></p>
            </div>
          <?php endif; ?>
          <?php if($this->text3): ?>
            <p class="small_tittle"><?php echo $this->translate($this->text3); ?></p>
          <?php endif; ?>
        </div>
        <?php if($this->showhomebutton): ?>
          <p class="home_link"><a href='javascript:void(0);' onClick='history.go(-1);'><?php echo $this->translate("Go Back"); ?></a></p>
        <?php endif; ?>
      </div>
      <?php elseif($this->default_activate == 8): ?>
      <div class="ses_page_not_found_eight_row">
        <div class="ses_not_found_img">
          <?php if($this->pagenotfoundphotoID): ?>
            <?php $photo = Engine_Api::_()->storage()->get($this->pagenotfoundphotoID, '');
              if($photo)
                $photo = $photo->getPhotoUrl(); ?>
            <img src="<?php echo $photo; ?>">
          <?php else: ?>
            <img src="application/modules/Seserror/externals/images/pagenotfound/5.png" />
          <?php endif; ?>
        </div>
        <?php if($this->text1): ?>
          <div class="ses_not_found_main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="ses_not_found_mini_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <div class="ses_not_found_main_content">
          <div class="ses_not_found_main_content_inner">
            <p class="small_tittle"><?php echo $this->translate($this->text3); ?></p>
            <?php if($this->showsearch): ?>
              <form class="searchform" id="global_search_form" action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get">
                <div class="ses_not_found_form">
                  <span><input id="global_search_field" type="search" data-required="required" name="query" placeholder="Search" value=""></span>
                  <button type="submit" class=""><?php echo $this->translate("Search"); ?></button>
                </div>
              </form>
            <?php endif; ?>
            <?php if($this->showbackbutton): ?>
              <p class="home_link">
                <a href='javascript:void(0);' onClick='history.go(-1);'>
                 <i class="fa fa-arrow-circle-o-left"></i>&nbsp;<?php echo $this->translate("Go Back"); ?>
                </a>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
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