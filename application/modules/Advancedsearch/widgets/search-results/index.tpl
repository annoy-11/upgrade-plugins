<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php //include module css ?>
<?php
 $baseUrl = $this->layout()->staticBaseUrl;
 foreach($this->modules as $module){
    if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled($module->module_name))
        continue;
    if(file_exists(APPLICATION_PATH . '/application/modules/'.ucfirst($module->module_name).'/externals/styles/styles.css')){
        $this->headLink()->prependStylesheet($baseUrl . 'application/modules/'.ucfirst($module->module_name).'/externals/styles/styles.css');
    }
 }

$this->headLink()->prependStylesheet($baseUrl . 'application/modules/Sesbasic/externals/styles/pinboard.css');
?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/marker.js'); ?>

<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled("sesmember")){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php } ?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled("exhibition")){ ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Exhibition/externals/scripts/Picker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Exhibition/externals/scripts/Picker.Attach.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Exhibition/externals/scripts/Picker.Date.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Exhibition/externals/scripts/Picker.Date.Range.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Exhibition/externals/styles/picker-style.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Exhibition/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Exhibition/externals/styles/datepicker.css'); ?>
<?php } ?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled("sescontest")){ ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.Attach.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.Date.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/Picker.Date.Range.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/picker-style.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/datepicker.css'); ?>
<?php } ?>

<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled("sesqa")){ ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Attach.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Date.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/Picker.Date.Range.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/picker-style.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/datepicker.css'); ?>
<?php } ?>

<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled("sesevent")){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/bootstrap-datepicker.js'); ?>
<?php } ?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled("sesmember")){
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/scripts/jQuery-1.8.2.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/scripts/jquery.carouFredSel-6.2.1-packed.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/scripts/jquery.mousewheel.min.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/scripts/jquery.touchSwipe.min.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/scripts/jquery.transit.min.js');
 } ?>

<?php $randonNumber = time().md5(time()); ?>
<div class="advancedsearch_results_main">
  <div class="advancedsearch_results_inner">
    <!--<div class="advancedsearch_box">
      <h2><?php echo $this->translate($this->title); ?></h2>
      <input type="text" placeholder="<?php echo $this->translate('Search'); ?>" id="advancedsearch_title" value="<?php echo $this->text; ?>" />
      <button id="advancedsearch_title_btn"><i class="fa fa-search"></i></button>
        <span id="advancedsearch_box_loading_search" style="display: none">
              <img src="application/modules/Advancedsearch/externals/images/loading.gif">
          </span>
    </div> -->
    <div class="advancedsearch_tabs">
      <ul class="advancedsearch_ul_cnt sesbasic_bg">
        <li data-action="all" class="advancedsearch_cnt_li <?php echo empty($this->resType) ? 'active' : ''; ?>">
          <a href="javascript:;"><?php echo $this->translate("All Results"); ?></a>
        </li>
        <?php
          $counter = 1;
          $runMore = false;
          foreach($this->modules as $module){
            if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled($module->module_name))
                continue;

          ?>
          <?php if($counter <= $this->more){ ?>
            <li data-action="<?php echo $module->resource_type; ?>" class="advancedsearch_cnt_li <?php echo $module->resource_type == ($this->resType) ? 'active' : ''; ?>">
              <a href="javascript:;"><?php echo $this->translate($module->title); ?></a>
            </li>
          <?php }else{ ?>
            <?php if(!$runMore){ ?>
            <li><a href="javascript:;"><?php echo $this->translate("More +"); ?></a>
              <ul class="tabs_submenu">
                <?php $runMore = true; ?>
               <?php } ?>
                <li data-action="<?php echo $module->resource_type; ?>" class="advancedsearch_cnt_li <?php echo $module->resource_type == ($this->resType) ? 'active' : ''; ?>">
                  <a href="javascript:;"><?php echo $this->translate($module->title); ?></a>
                </li>
            <?php if($counter == count($this->modules)){ ?>
              </ul>
            </li>
            <?php } ?>
        <?php } ?>
        <?php $counter = $counter + 1; ?>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
<div id="advancedsearch-content-<?php echo $randonNumber; ?>" class="advancedsearch_tab_content"></div>
<script type="application/javascript">
  //core search
  sesJqueryObject(document).on('click','#advancedsearch_title_btn',function (e) {
      e.preventDefault();
      sesJqueryObject('.advancedsearch_ul_cnt li.active').trigger('click');
  })
<?php $randomId = "advsearchRESULT"; ?>
  var contentAutocomplete<?php echo $randomId; ?> =  'advancedsearch_title';
  contentAutocomplete<?php echo $randomId; ?> = new Autocompleter.Request.JSON('advancedsearch_title', "<?php echo $this->url(array('module' => 'advancedsearch', 'controller' => 'index', 'action' => 'get-results','direct'=>1), 'default', true) ?>", {
      'postVar': 'query',
      'minLength': 1,
      'selectMode': '',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'maxChoices': 20,
      'cache': false,
      'multiple': false,

      'className': 'sesbasic-autosuggest advancedsearch-autosuggest',
      'indicatorClass':'input_loading',
      'injectChoice': function(token) {
          sesJqueryObject('#advancedsearch_box_loading_search').hide();
          var choice = new Element('li', {
              'class': 'autocompleter-choices',
              'html': token.icon,
              'id':token.title
          });
          new Element('div', {
              'html': this.markQueryValue(token.label),
              'class': 'autocompleter-choice'
          }).inject(choice);
          if(token.shortType) {
              new Element('div', {
                  'html': token.shortType,
                  'class': 'autocompleter-choice'
              }).inject(choice);
          }
          this.addChoiceEvents(choice).inject(this.choices);
          choice.store('autocompleteChoice', token);
      },
      'emptyChoices':function (token) {
          sesJqueryObject('#advancedsearch_box_loading_search').hide();
      },
      'onShow':function () {
          sesJqueryObject('#advancedsearch_box_loading_search').hide();
      }
  });
  sesJqueryObject(document).on('keyup','#advancedsearch_title',function (e) {
      var value = sesJqueryObject(this).val();
      if(value) {
          sesJqueryObject('#advancedsearch_box_loading_search').show();
      }else {
          sesJqueryObject('#advancedsearch_box_loading_search').hide();
      }
  });
  contentAutocomplete<?php echo $randomId; ?>.addEvent('onSelection', function(element, selected, value, input) {
      sesJqueryObject('#advancedsearch_title').val(selected.retrieve('autocompleteChoice').label);
      sesJqueryObject('.advancedsearch_ul_cnt li.active').trigger('click');
  });

  var requestTab_<?php echo $randonNumber; ?>;
  sesJqueryObject(document).on('click','.advancedsearch_cnt_li',function (e) {
     var res = sesJqueryObject(this).attr('data-action');
      if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
          requestTab_<?php echo $randonNumber; ?>.cancel();
      }
      sesJqueryObject('.advancedsearch_ul_cnt').find('.active').removeClass('active');
      sesJqueryObject(this).addClass('active');
      sesJqueryObject('#advancedsearch-content-<?php echo $randonNumber; ?>').html('<div class="sesbasic_loading_container"></div>');
      updateHashValue('type',res);
      requestTab_<?php echo $randonNumber; ?> =
      new Request.HTML({
          method: 'post',
          'url': 'advancedsearch/index/all-results',
          'data': {
            format: 'html',
            query:sesJqueryObject('#advancedsearch_title').val(),
            resource_type:res,
              randonNumber: "<?php echo $randonNumber; ?>",
            searchParams : <?php echo json_encode($this->show_criteria); ?>,
            loadmore : "<?php echo $this->loadmore; ?>",
            limit : <?php echo $this->limit; ?>,
          },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          sesJqueryObject('#advancedsearch-content-<?php echo $randonNumber; ?>').html(responseHTML);
          en4.core.runonce.trigger();
      }
      }).send();
  });
  window.addEventListener("popstate", function(e) {console.log(window);
    window.location.href = window.location.href;
  });
  function updateHashValue(type,res){
      var newUrl = updateQueryStringParameter(window.location.href,type,res);
      if (history.pushState) {
          history.pushState({}, document.title, newUrl);
      } else {
          window.location.hash = newUrl;
      }
  }
  en4.core.runonce.add(function() {
<?php if(!empty($this->resType)){ ?>
    sesJqueryObject('.advancedsearch_ul_cnt li[data-action="<?php echo $this->resType; ?>"]').trigger('click');
<?php } ?>
      });
  function updateQueryStringParameter(uri, key, value) {
      var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
      var separator = uri.indexOf('?') !== -1 ? "&" : "?";
      if (uri.match(re)) {
          return uri.replace(re, '$1' + key + "=" + value + '$2');
      }
      else {
          return uri + separator + key + "=" + value;
      }
  }
</script>