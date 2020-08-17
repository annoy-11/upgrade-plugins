<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestutorial
 * @package    Sestutorial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $widgetParams = $this->widgetParams;  ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestutorial/externals/styles/styles.css'); ?>
<?php if($widgetParams[autosuggest]) { ?>
  <?php
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()
      ->appendFile($base_url . 'externals/autocompleter/Observer.js')
      ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
      ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
      ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
  ?>
<?php } ?>
<?php if($widgetParams['template'] == 1) { ?>
<div class="sestutorial_search_banner_wrapper sestutorial_clearfix sestutorial_bxs">
	<div class="sestutorial_search_banner_container sestutorial_clearfix <?php if($widgetParams['showfullwidth'] == 'full'): ?> search_banner_bg_full <?php endif; ?>" style="height:<?php echo $widgetParams['height'];?>px;">
  	<div class="sestutorial_search_banner type1" style="height:<?php echo $widgetParams['height'];?>px;">
    	<div class="sestutorial_search_banner_inner" style="background-image:url(<?php echo $widgetParams['backgroundimage']; ?>);">
        <div class="sestutorial_search_banner_content_left">
          <?php if($widgetParams['bannertext']) { ?>
            <div class="sestutorial_search_banner_heading">
              <h2><?php if(isset($widgetParams['logo']) && !empty($widgetParams['logo'])) { ?><img src="<?php echo $widgetParams['logo']; ?>" /><?php } ?><span><?php echo $this->translate($widgetParams['bannertext']); ?></span></h2>
            </div>
          <?php } ?>
          <?php if($widgetParams['description']) { ?>
            <div class="sestutorial_search_banner_des">
              <p><?php echo $this->translate($widgetParams['description']); ?></p>
            </div>
          <?php } ?>
          <div class="sestutorial_search_banner_form">
            <input type="text" id="tutorial_title" placeholder="<?php echo $this->translate($widgetParams['textplaceholder']); ?>" />
            <button name="submit" id="submit" type="submit" onclick="searchTutorial()" class="fa fa-search"></button>
          </div>
          <?php if($widgetParams['limit'] > 0) { ?>
            <div class="sestutorial_search_banner_ques">
              <?php foreach($this->tutorials as $tutorial) { ?>
                <div class="sestutorial_sidebar_list_title">
                  <a href="<?php echo $tutorial->getHref(); ?>" title="<?php echo $tutorial->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->title), 90); ?></a>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } elseif($widgetParams['template'] == 2) { ?>
  <div class="sestutorial_search_banner_wrapper sestutorial_clearfix sestutorial_bxs">
    <div class="sestutorial_search_banner_container sestutorial_clearfix sestutorial_search_banner_bg <?php if($widgetParams['showfullwidth'] == 'full'): ?> search_banner_bg_full <?php endif; ?>" style="height:<?php echo $widgetParams['height'];?>px;">
      <div class="sestutorial_search_banner type2" style="height:<?php echo $widgetParams['height'];?>px;">
      	<div class="sestutorial_search_banner_inner" style="background-image:url(<?php echo $widgetParams['backgroundimage']; ?>);">
          <div class="sestutorial_search_banner_content">
            <div>
              <?php if($widgetParams['bannertext']) { ?>
                <div class="sestutorial_search_banner_heading">
                  <h2><?php if(isset($widgetParams['logo']) && !empty($widgetParams['logo'])) { ?><img src="<?php echo $widgetParams['logo']; ?>" /><?php } ?><span><?php echo $this->translate($widgetParams['bannertext']); ?></span></h2>
                </div>
              <?php } ?>
              <?php if($widgetParams['description']) { ?>
                <div class="sestutorial_search_banner_des">
                  <p><?php echo $this->translate($widgetParams['description']); ?></p>
                </div>
              <?php } ?>
              <div class="sestutorial_search_banner_form">
                <div>
                  <input type="text" id="tutorial_title" placeholder="<?php echo $this->translate($widgetParams['textplaceholder']); ?>" />
                  <button name="submit" id="submit" type="submit" onclick="searchTutorial()" class="fa fa-search"></button>
                </div>
              </div>
              <?php if($widgetParams['limit'] > 0) { ?>
                <div class="sestutorial_search_banner_ques">	 
                  <?php foreach($this->tutorials as $tutorial) { ?>
                    <a href="<?php echo $tutorial->getHref(); ?>" title="<?php echo $tutorial->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->title), 30); ?></a>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } elseif($widgetParams['template'] == 3) { ?>
  <div class="sestutorial_search_banner_wrapper sestutorial_clearfix sestutorial_bxs">
    <div class="sestutorial_search_banner_container sestutorial_clearfix <?php if($widgetParams['showfullwidth'] == 'full'): ?> search_banner_bg_full <?php endif; ?>" style="height:<?php echo $widgetParams['height'];?>px;">
      <div class="sestutorial_search_banner type3" style="height:<?php echo $widgetParams['height'];?>px;">
      	<div class="sestutorial_search_banner_inner" style="background-image:url(<?php echo $widgetParams['backgroundimage']; ?>);">
          <div class="sestutorial_search_banner_content">
            <div>
              <?php if($widgetParams['bannertext']) { ?>
              <div class="sestutorial_search_banner_heading">
                <h2><?php if(isset($widgetParams['logo']) && !empty($widgetParams['logo'])) { ?><img src="<?php echo $widgetParams['logo']; ?>" /><?php } ?><span><?php echo $this->translate($widgetParams['bannertext']); ?></span></h2>
              </div>
              <?php } ?>
              <?php if($widgetParams['description']) { ?>
                <div class="sestutorial_search_banner_des">
                  <p><?php echo $this->translate($widgetParams['description']); ?></p>
                </div>
              <?php } ?>
              <div class="sestutorial_search_banner_form">
                <div>
                  <input type="text" id="tutorial_title" placeholder="<?php echo $this->translate($widgetParams['textplaceholder']); ?>" />
                  <button name="submit" id="submit" type="submit" onclick="searchTutorial()" class="fa fa-search"></button>
                </div>
              </div>
              <?php if($widgetParams['limit'] > 0) { ?>
                <div class="sestutorial_search_banner_ques">	 
                  <?php foreach($this->tutorials as $tutorial) { ?>
                    <a href="<?php echo $tutorial->getHref(); ?>" title="<?php echo $tutorial->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->title), 30); ?></a>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>


<script>

  function searchTutorial() {
    window.location.href= '<?php echo $this->url(array("controller" => "index", "action" => "browse"), "sestutorial_general", true); ?>' + "?title_name=" + $('tutorial_title').value;
  }
  
  <?php if($widgetParams[autosuggest]) { ?>
    //Take refrences from "/application/modules/Blog/views/scripts/index/create.tpl"
    en4.core.runonce.add(function() {
      var searchAutocomplete = new Autocompleter.Request.JSON('tutorial_title', "<?php echo $this->url(array('module' => 'sestutorial', 'controller' => 'index', 'action' => 'search'), 'default', true) ?>", {
        'postVar': 'text',
        'delay' : 250,      
        'minLength': 1,
        'selectMode': 'pick',
        'autocompleteType': 'tag',
        'customChoices': true,
        'filterSubset': true,
        'multiple': false,
        'className': 'tag-autosuggest',
        'injectChoice': function(token) {
          var choice = new Element('li', {
            'class': 'autocompleter-choices',
            'html': token.photo,
            'id': token.label
          });
          new Element('div', {
            'html': this.markQueryValue(token.label),
            'class': 'autocompleter-choice'
          }).inject(choice);
          choice.inputValue = token;
          this.addChoiceEvents(choice).inject(this.choices);
          choice.store('autocompleteChoice', token);
        }
      });
      searchAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
        var url = selected.retrieve('autocompleteChoice').url;
        window.location.href = url;
      });
    });
  <?php } ?>
  
  sesJqueryObject(document).ready(function() {
    sesJqueryObject('#tutorial_title').keydown(function(e) {
      if (e.which === 13) {
        searchTutorial();
      }
    });
  });
  
</script>


<?php if($widgetParams['showfullwidth'] == 'full'): ?>
  <script type="text/javascript">
    sesJqueryObject(function() {
      sesJqueryObject('body').addClass('sestutorial_search_banner_full');
    });
  </script>
<?php endif; ?>