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
<?php $randomId = time().md5(rand(1,100)); ?>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $moduleName = $request->getModuleName();?>
<?php $actionName = $request->getActionName();?>
<div class="advancedsearch_box_wrapper sesbasic_bsx sesbasic_clearfix">
  <div class="advancedsearch_box_inner">
    <div class="advancedsearch_box">
     <div class="advancedsearch_input">

         <?php
             if(($moduleName == 'advancedsearch') && ($actionName == 'index') && ($controllerName == "index")) { ?>
                 <input type="text" id="advancedsearch_title" placeholder="<?php echo $this->translate('Search'); ?>" value="<?php echo !empty($this->text) ? $this->text : ''; ?>" class="search-input"/>
                 <span id="advancedsearch_box_loading_search" class="advancedsearch_box_loader" style="display: none">
                      <img src="application/modules/Advancedsearch/externals/images/loading.gif">
                  </span>
                 <button id="advancedsearch_title_btn" class="advancedsearch_toggle"><i class="fa fa-search"></i></button>
         <?php
             }else{
                $execuredSearchTag = true;
          ?>
                 <input type="text" id="search_box_<?php echo $randomId; ?>" placeholder="<?php echo $this->translate('Search'); ?>" value="<?php echo !empty($this->text) ? $this->text : ''; ?>" class="search-input"/>
                     <span id="search_box_loading<?php echo $randomId; ?>" class="advancedsearch_box_loader" style="display: none">
                          <img src="application/modules/Advancedsearch/externals/images/loading.gif">
                      </span>
                 <button id="search_box_btn_<?php echo $randomId; ?>" class="advancedsearch_toggle"><i class="fa fa-search"></i></button>
         <?php
             }
            ?>
          <?php if(count($this->searchModules)){ ?>
             <div class="advancedsearch_dropdown sesbasic_bg" style="display:none;">
               <ul>
                <?php foreach($this->searchModules as $item){
                    if(!Engine_Api::_()->sesbasic()->isModuleEnable($item->module_name))
                        continue;
                 ?>
                 <li>
                   <a href="javascript:;" data-action="<?php echo $item->resource_type; ?>" class="advancedsearch_select_a">
                     <span class="_icon"><img src="<?php echo $item->getPhotoUrl(); ?>" /></span>
                       <span class="_text"><?php echo $this->translate("Search in %s",$this->translate($item->title)); ?></span>
                    </a>
                 </li>
                <?php } ?>
               </ul>
               <div class="advancedsearch_show_all">
                   <a href="search?type=all" class="all_result_sesadv_search"><?php echo $this->translate("Show All Results"); ?></a>
               </div>
             </div>
         <?php } ?>
     </div>
    </div>
  </div>
</div>
<?php $base_url = $this->layout()->staticBaseUrl;?>
<?php $this->headScript()
            ->appendFile($base_url . 'externals/autocompleter/Observer.js')
            ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
            ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
            ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<script type="application/javascript">
    sesJqueryObject(document).on('mousedown','.all_result_sesadv_search',function (e) {
        window.location.href = "search?type=all";
    })
    sesJqueryObject(document).on('keyup','#search, #search_text, #search_text, #title_name, #title_song, #searchText, #sesteam_title, #query',function () {
        sesJqueryObject('#advancedsearch_title').val(sesJqueryObject(this).val());
    })
<?php if(!empty($execuredSearchTag)){ ?>
    var contentAutocomplete<?php echo $randomId; ?> =  'search_box_<?php echo $randomId; ?>';
    contentAutocomplete<?php echo $randomId; ?> = new Autocompleter.Request.JSON('search_box_<?php echo $randomId; ?>', "<?php echo $this->url(array('module' => 'advancedsearch', 'controller' => 'index', 'action' => 'get-results'), 'default', true) ?>", {
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
            sesJqueryObject('#search_box_loading<?php echo $randomId; ?>').hide();
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
        'onShow':function () {
            sesJqueryObject('#search_box_loading<?php echo $randomId; ?>').hide();
        }
    });

    contentAutocomplete<?php echo $randomId; ?>.addEvent('onSelection', function(element, selected, value, input) {

        var resType =  selected.retrieve('autocompleteChoice').res_type;
        if(resType){
            //search module
            window.location.href = 'search?type='+resType+'&query='+selected.retrieve('autocompleteChoice').text;
        }else{
            window.location.href = selected.retrieve('autocompleteChoice').href;
        }
    });

    sesJqueryObject(document).on('keyup','#search_box_<?php echo $randomId; ?>',function (e) {
        var value = sesJqueryObject('#search_box_<?php echo $randomId; ?>').val();
        if(value) {
            sesJqueryObject('#search_box_loading<?php echo $randomId; ?>').show();
            sesJqueryObject('#search_box_<?php echo $randomId; ?>').parent().find('.advancedsearch_dropdown').hide();
        }else {
            sesJqueryObject('#search_box_loading<?php echo $randomId; ?>').hide();
            sesJqueryObject('#search_box_<?php echo $randomId; ?>').parent().find('.advancedsearch_dropdown').show();
        }
    });

    sesJqueryObject(document).on('focus','#search_box_<?php echo $randomId; ?>',function (e) {
        var value = sesJqueryObject('#search_box_<?php echo $randomId; ?>').val();
        if(!value)
            sesJqueryObject(this).parent().find('.advancedsearch_dropdown').show();
    });
    sesJqueryObject(document).on('click','#search_box_btn_<?php echo $randomId; ?>',function (e) {
        var value = sesJqueryObject('#search_box_<?php echo $randomId; ?>').val();
        if(value)
         window.location.href = "search?type=all&query="+value;
    });
    sesJqueryObject(document).on('blur','#search_box_<?php echo $randomId; ?>',function (e) {
        sesJqueryObject(this).parent().find('.advancedsearch_dropdown').hide();
    });
    sesJqueryObject(document).on('mousedown','.advancedsearch_select_a',function (e) {
        var text = sesJqueryObject(this).find('._text').html();
        sesJqueryObject('#search_box_<?php echo $randomId; ?>').val(text);
        window.location.href = "search?type="+sesJqueryObject(this).attr('data-action');
    });
    <?php } ?>
    //select requested type page
    sesJqueryObject(document).ready(function () {
        sesJqueryObject('.advancedsearch_cnt_li.active').trigger('click');
    })

</script>
