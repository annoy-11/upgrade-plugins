<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if($this->createLimit == 1): ?>
  <?php if(!$this->typesmoothbox){ ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Observer.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Local.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Request.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
  <?php }else{ ?>
    <script type="application/javascript">
      Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'; ?>");
      Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'; ?>");
    </script>
  <?php } ?>
  <?php if(count($_POST) == 0 && Engine_Api::_()->getApi('settings','core')->getSetting('estore.category.selection', 0)):?>
    <?php if (Engine_Api::_()->core()->hasSubject('stores')):  ?>
      <?php $store = Engine_Api::_()->core()->getSubject();?>
    <?php endif;?>
    <div class="estore_create_step_container sesbasic_bxs sesbasic_clearfix">
      <h3><?php echo $this->translate('Create New Store');?></h3>
      <p><?php echo $this->translate("It's easy to set up. Just choose a Store category to get started.");?></p>
      <?php $iconType = Engine_Api::_()->getApi('settings','core')->getSetting('estore.category.icon');?>
      <?php if($iconType == 0):?>
        <?php $icon = 'colored_icon';?>
      <?php elseif($iconType == 1):?>
        <?php $icon = 'cat_icon';?>
      <?php elseif($iconType == 2):?>
        <?php $icon = 'thumbnail';?>
      <?php endif;?>
      <div class="estore_create_categories_listing">
        <?php foreach($this->categories as $category):?>
          <div class="estore_create_category">
            <section class="">
              <div class="_inner">
                <div class="_step1">
                  <?php if($this->quickCreate):?>
                    <a href="javascript:;" class="sesbasic_linkinherit estore_create_category_toggle">
                  <?php else:?>
                    <a href="javascript:;" class="sesbasic_linkinherit" onClick="selectCat(<?php echo $category->category_id;?>);return false;">
                  <?php endif;?>
                  <?php if($category->$icon):?>
                      <i style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($category->$icon)->getPhotoUrl();?>);"></i>
                  <?php else:?>
                    <i style="background-image:url(application/modules/Estore/externals/images/store-icon-big.png);"></i>
                  <?php endif;?>
                  <span><?php echo $category->category_name;?></span>
                  </a>
                </div>
                <?php if($this->quickCreate):  ?>
                  <div class="_step2">
                    <form class='quick_store_create' action="estore/index/create/parent_id/<?php echo $this->parent_id;?>" id="quick_store_create_<?php echo $category->category_id;?>" method="post" enctype="multipart/form-data">
                    <p class="_subcate"><?php echo $category->category_name;?></p>
                    <p><?php echo $this->translate('Get started by filling the details in the form below.');?></p>
                    <input type='hidden' name='category_id' value="<?php echo $category->category_id;?>"/>
                    <div><input type="text" class="estore_title" id="estore_title_<?php echo $category->category_id;?>" name='estore_title' class="reset_form_value" placeholder="Store Title" /></div>
                    <?php $custom_url_value = isset($store->custom_url) ? $store->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");;?>
                    <div class="_url">
                      <input type="text" class="estore_custom_url reset_form_value" name="custom_url" id="custom_url_<?php echo $category->category_id;?>" value="<?php echo $custom_url_value;?>">
                      <span class="estore_check_availability_btn">
                          <button id="check_custom_url_availability" class="check_custom_url_availability" type="button" name="check_availability" ><i class="fa fa-check" id="estore_custom_url_correct" style=""></i><i class="fa fa-close" id="estore_custom_url_wrong" style="display:none;"></i><img src="application/modules/Core/externals/images/loading.gif" id="estore_custom_url_loading" alt="Loading" style="display:none;" />
                        <samp class="availability_tip"><?php echo $this->translate("Check Availability");?></samp></button>
                      </span>
                     </div>
                    <?php $subcategory = Engine_Api::_()->getDbTable('categories','estore')->getModuleSubcategory(array('category_id' => $category->category_id, 'column_name' => '*'));?>
                    <?php $count_subcat = count($subcategory->toarray());?>
                    <?php if (isset($_POST['selected'])):?>
                      <?php $selected = $_POST['selected'];?>
                    <?php else:?>
                      <?php $selected = '';?>
                    <?php endif;?>
                    <?php $data = '';?>
                    <?php if ($subcategory && $count_subcat):?>
                      <div>
                        <select class="reset_form_value" onchange="showQuickSubSubCategory(this.value,this)">
                          <option value=""><?php echo $this->translate('2nd-level Category');?></option>
                          <?php foreach ($subcategory as $categorysub):?>
                            <option ($selected == $categorysub['category_id'] ? 'selected = selected' : '') value="<?php echo $categorysub['category_id'];?>"><?php echo $this->translate($categorysub['category_name']);?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    <?php endif;?>
                    <div style='display:none;' class='quick_store_subsubcat'><select></select></div>
                    <div style='display:none;' class="_loading" id='estore_sussubcat_loading'><i class="fa fa-spinner fa-spin"></i></div>
                    <div class="btn"><button type='submit'><?php echo $this->translate("Get Started");?></button></div>
                    </form>
                  </div>
                <?php endif;?>
              </div>
            </section>
          </div>   
        <?php endforeach;?>
      </div>
    </div>
    <script type="text/javascript">
      sesJqueryObject(document).ready(function(){
        sesJqueryObject(document).on('click',".estore_create_category_toggle",function(){
          checkTitleChnage = false; 
          changeTitle = true;
          sesJqueryObject('.reset_form_value').val('');
          sesJqueryObject('.reset_form_value').trigger('change');
          sesJqueryObject('.estore_create_category').removeClass('openbox');
          sesJqueryObject(this).closest('.estore_create_category').toggleClass("openbox");
        });
      });
    </script>    
  <?php endif; ?>
  <div class="estore_create_container <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.create.form', 1)):?>estore_create_form<?php endif;?>">
    <?php echo $this->form->render();?>
    <div class="estore_create_loading estore_create_overlay">
      <div class="estore_create_overlay_cont">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>
        <span class="_text"><?php echo $this->translate('Creating Store ...');?></span>
      </div>
    </div>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.guidelines', 1) && !empty(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.message.guidelines', ''))):?>
      <div id="estore_create_tips" class="estore_create_tips">
        <div class="create_tips_top_sec">
          <h3><?php echo $this->translate('Tips');?></h3>
        </div>
        <div class="create_tips_bottom_sec">
          <div class="sesbasic_html_block">
            <?php echo Engine_Api::_()->getApi('settings','core')->getSetting('estore.message.guidelines', '');?>
          </div>
        </div>
      </div>
    <?php endif;?>
  </div>
    <script type="application/javascript">
      executetimesmoothboxTimeinterval = 700;
      en4.core.runonce.add(function(){
         if(sesJqueryObject('.estore_create_step_container').length > 0){
           sesJqueryObject('.estore_create_container').hide();
           sesJqueryObject('.estore_create_step_container').show();
         }else{
           sesJqueryObject('.estore_create_tips').show();
           sesJqueryObject('.estore_create_container').show();
           sesJqueryObject('.estore_create_step_container').hide();
         }
      });
      function selectCat(value){ 
       sesJqueryObject('#estore_create_form').find('#category_id').val(value);
       sesJqueryObject('#estore_create_form').find('#category_id').trigger('change');
       sesJqueryObject('.estore_create_container').show();
       sesJqueryObject('.estore_create_step_container').hide();
      }
      sesJqueryObject(function() {
        sesJqueryObject.fn.scrollBottom = function() {
             return sesJqueryObject(document).height() - this.scrollTop() - this.height();
        };
        var $el = sesJqueryObject('#estore_create_tips');
        var positionInitial = sesJqueryObject('#title').offsetTop;
        sesJqueryObject('<style>#estore_create_tips{top:'+positionInitial+'px;}</style>').appendTo(document.head);
        var $window = sesJqueryObject(window);
      if($el.length){
        $window.bind("scroll resize", function() {
          var positionInitialTitle = sesJqueryObject('#title-element').offsetTop;
          var position = $el.offset().top - $window.scrollTop();
          if($window.scrollTop() < positionInitial){
             $el.css('top',positionInitial);
          }else{
             $el.css('top',$window.scrollTop());
          }
        });
      }
      });
      //trim last -
      function removeLastMinus (myUrl) {
        if (myUrl.substring(myUrl.length-1) == "-") {
          myUrl = myUrl.substring(0, myUrl.length-1);
        }
        return myUrl;
      }
      var changeTitle = true;
      var validUrl = true;
      en4.core.runonce.add(function() {
        //auto fill custom url value
        sesJqueryObject("#title, .estore_title").keyup(function(){
          var Text = sesJqueryObject(this).val();
          if(!changeTitle)
              return;
          Text = Text.toLowerCase();
          Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
          Text = removeLastMinus(Text);
          if(sesJqueryObject(this).closest('.quick_store_create').length){
              sesJqueryObject(sesJqueryObject(this).closest('.quick_store_create').find('._url').find('.estore_custom_url')).val(Text);
      }
      else {
          sesJqueryObject("#custom_url").val(Text);
      }
        });
        sesJqueryObject("#custom_url, .estore_custom_url").keydown(function(){
         checkTitleChnage = true;
         changeTitle = false;
        });
        var checkTitleChnage = false;
        sesJqueryObject("#title,.estore_title").blur(function(){
          if(sesJqueryObject(this).val()){
        checkTitleChnage = true;
        sesJqueryObject(this).parent().parent().find('._url').find('input').trigger('blur');

          }
        });
        sesJqueryObject("#custom_url, .estore_custom_url").blur(function(){
          validUrl = false;
          if(!checkTitleChnage)
           changeTitle = false;
           if(sesJqueryObject(this).parent().find('span').find('button').length){
             sesJqueryObject(this).parent().find('span').find('button').trigger('click');
           }
           else {
            sesJqueryObject('#check_custom_url_availability').trigger('click');
           }

        });
      //function ckeck url availability
      sesJqueryObject('#check_custom_url_availability, .check_custom_url_availability').click(function(){
        var custom_url_value = sesJqueryObject(this).parent().parent().find('input').val();
        if(!custom_url_value)
            return;
        sesJqueryObject(this).find('#estore_custom_url_wrong').hide();
        sesJqueryObject(this).find('#estore_custom_url_correct').hide();
        sesJqueryObject(this).find('#estore_custom_url_loading').css('display','inline-block');
        var obj = this;
        sesJqueryObject.post('<?php echo $this->url(array('controller' => 'ajax','module'=>'estore', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response){
                    sesJqueryObject(obj).find('#estore_custom_url_loading').hide();
                    response = sesJqueryObject.parseJSON(response);
                    if(response.error){
                        validUrl = false;
                        sesJqueryObject(obj).find('#estore_custom_url_correct').hide();
                        sesJqueryObject(obj).find('#estore_custom_url_wrong').css('display','inline-block');
												sesJqueryObject(obj).addClass('_notavailable').removeClass('_available');
                    }else{
                            validUrl = true;
                            sesJqueryObject(obj).parent().parent().find('input').val(response.value);
                            sesJqueryObject(obj).find('#estore_custom_url_wrong').hide();
                            sesJqueryObject(obj).find('#estore_custom_url_correct').css('display','inline-block');
														sesJqueryObject(obj).addClass('_available').removeClass('_notavailable');
                    }
            });
    });
        //tags
        new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
          'postVar' : 'text',
          'minLength': 1,
          'selectMode': 'pick',
          'autocompleteType': 'tag',
          'className': 'tag-autosuggest',
          'customChoices' : true,
          'filterSubset' : true,
          'multiple' : true,
          'injectChoice': function(token){
            var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
            new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
            choice.inputValue = token;
            this.addChoiceEvents(choice).inject(this.choices);
            choice.store('autocompleteChoice', token);
          }
        });
      });
    //custom term and condition
    function customTermAndCondition(){
        if(sesJqueryObject("#is_custom_term_condition").is(':checked'))
        sesJqueryObject("#custom_term_condition-wrapper").show();  // checked
        else
        sesJqueryObject("#custom_term_condition-wrapper").hide();  // unchecked
    }
     en4.core.runonce.add(function()
      {
    sesJqueryObject('#is_custom_term_condition').bind('change', function () {
        customTermAndCondition();
    });
    customTermAndCondition();
    });
    </script>
    <?php 
    $defaultProfileFieldId = "0_0_$this->defaultProfileId";
    $profile_type = 2;
    ?>
    <?php echo $this->partial('_customFields.tpl', 'sesbasic', array()); ?>
    <script type="text/javascript">
      var validation = false;
      sesJqueryObject(document).on('submit','.quick_store_create',function(e) {
        var cat_id = sesJqueryObject(this).attr('id').replace('quick_store_create_','');
        if(validation == true) {
          return true;
        }
        e.preventDefault();
        if(sesJqueryObject('#estore_title_'+cat_id).val() == "") {
          alert('Pleae complete the title field, it is required.');
          return false;
        }
        if(sesJqueryObject('#custom_url_'+cat_id).val() == "") {
          alert('Pleae complete the custom URl field, it is required.');
          return false;
        }
        var custom_url_value = sesJqueryObject('#custom_url_'+cat_id).val();
        sesJqueryObject.post('<?php echo $this->url(array('controller' => 'ajax','module'=>'estore', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response){
          response = sesJqueryObject.parseJSON(response);
          if(response.error) {
            alert('Cutom URL not available. Please choose another..');      
          }
          else {
           validation = true;
           sesJqueryObject('#quick_store_create_'+cat_id).trigger('submit');
           return true;
          }
        });
        return false;
       });
      var defaultProfileFieldId = '<?php echo $defaultProfileFieldId ?>';
      var profile_type = '<?php echo $profile_type ?>';
      var previous_mapped_level = 0;

      function showFields(cat_value, cat_level,typed,isLoad) {
            var categoryId = getProfileType(formObj.find('#category_id-wrapper').find('#category_id-element').find('#category_id').val());
            var subcatId = getProfileType(formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').val());
            var subsubcatId = getProfileType(formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').val());
            var type = categoryId+','+subcatId+','+subsubcatId;
        if (cat_level == 1 || (previous_mapped_level >= cat_level && previous_mapped_level != 1) || (profile_type == null || profile_type == '' || profile_type == 0)) {
          profile_type = getProfileType(cat_value);
          if (profile_type == 0) {
            profile_type = '';
          } else {
            previous_mapped_level = cat_level;
          }
          if($(defaultProfileFieldId))
          $(defaultProfileFieldId).value = profile_type;
          changeFields($(defaultProfileFieldId),null,isLoad,type);
        }
      }
      var getProfileType = function(category_id) {
        var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'estore')->getMapping(array('category_id', 'profile_type'))); ?>;
              for (i = 0; i < mapping.length; i++) {	
            if (mapping[i].category_id == category_id)
            return mapping[i].profile_type;
            }
        return 0;
      }
      en4.core.runonce.add(function() {
        var defaultProfileId = '<?php echo '0_0_' . $this->defaultProfileId ?>' + '-wrapper';
         if ($type($(defaultProfileId)) && typeof $(defaultProfileId) != 'undefined') {
          $(defaultProfileId).setStyle('display', 'none');
          if(sesJqueryObject('#sessmoothbox_main').length){
            sesJqueryObject('#estore_create_form').find('div').find('div').find('.form-elements').find('.parent_0').closest('.form-wrapper').hide() ;
          }
        }
      });
      function showSubCategory(cat_id,selectedId) {
            var selected;
            if(selectedId != ''){
                var selected = selectedId;
            }
        var url = en4.core.baseUrl + 'estore/ajax/subcategory/category_id/' + cat_id;
        new Request.HTML({
          url: url,
          data: {
                    'selected':selected
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if (formObj.find('#subcat_id-wrapper').length && responseHTML) {
              formObj.find('#subcat_id-wrapper').show();
              formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').html(responseHTML);
            } else {
              if (formObj.find('#subcat_id-wrapper').length) {
                formObj.find('#subcat_id-wrapper').hide();
                formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').html( '<option value="0"></option>');
              }
            }
                  if (formObj.find('#subsubcat_id-wrapper').length) {
                formObj.find('#subsubcat_id-wrapper').hide();
                formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
              }
                    showFields(cat_id,1);
          }
        }).send(); 
      }
      function showQuickSubSubCategory(cat_id,object) {
       sesJqueryObject('#estore_sussubcat_loading').show();
        var url = en4.core.baseUrl + 'estore/ajax/subsubcategory/subcategory_id/' + cat_id;
        (new Request.HTML({
          url: url,
          data: {
            'selected':'',
            'quickStore':1
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if(responseHTML != ''){
              sesJqueryObject('.quick_store_subsubcat').show();
              sesJqueryObject(object).parent().parent().find('.quick_store_subsubcat').html("<select><option value=''>"+en4.core.language.translate("3rd-level Category")+"</option>"+responseHTML+"></select>");
            }
            else {
              sesJqueryObject(object).parent().parent().find('.quick_store_subsubcat').html("");
              sesJqueryObject('.quick_store_subsubcat').hide();
            }
            sesJqueryObject('#estore_sussubcat_loading').hide();
          }
        })).send();  
      }
        function showSubSubCategory(cat_id,selectedId,isLoad) {
            var categoryId = getProfileType($('category_id').value);
            if(cat_id == 0){
                if (formObj.find('#subsubcat_id-wrapper').length) {
                formObj.find('#subsubcat_id-wrapper').hide();
                formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
                            document.getElementsByName("0_0_1")[0].value=categoryId;		
          }
                showFields(cat_id,1,categoryId);
                return false;
            }
            showFields(cat_id,1,categoryId);
            var selected;
            if(selectedId != ''){
                var selected = selectedId;
            }
          var url = en4.core.baseUrl + 'estore/ajax/subsubcategory/subcategory_id/' + cat_id;
        (new Request.HTML({
          url: url,
          data: {
                    'selected':selected
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if (formObj.find('#subsubcat_id-wrapper').length && responseHTML) {
              formObj.find('#subsubcat_id-wrapper').show();
              formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html(responseHTML);
            } else {
              if (formObj.find('#subsubcat_id-wrapper').length) {
                formObj.find('#subsubcat_id-wrapper').hide();
                formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
              }
            }				
                }
        })).send();  
      }
        function showCustom(value,isLoad){
            var categoryId = getProfileType(formObj.find('#category_id-wrapper').find('#category_id-element').find('#category_id').val());
            var subcatId = getProfileType(formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').val());
            var id = categoryId+','+subcatId;
                showFields(value,1,id,isLoad);
            if(value == 0)
                document.getElementsByName("0_0_1")[0].value=subcatId;	
                return false;
        }
        function showCustomOnLoad(value,isLoad){
         <?php if(isset($this->category_id) && $this->category_id != 0){ ?>
            var categoryId = getProfileType(<?php echo $this->category_id; ?>)+',';
            <?php if(isset($this->subcat_id) && $this->subcat_id != 0){ ?>
            var subcatId = getProfileType(<?php echo $this->subcat_id; ?>)+',';
            <?php  }else{ ?>
            var subcatId = '';
            <?php } ?>
            <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
            var subsubcat_id = getProfileType(<?php echo $this->subsubcat_id; ?>)+',';
            <?php  }else{ ?>
            var subsubcat_id = '';
            <?php } ?>
            var id = (categoryId+subcatId+subsubcat_id).replace(/,+$/g,"");;
                showFields(value,1,id,isLoad);
            if(value == 0)
                document.getElementsByName("0_0_1")[0].value=subcatId;	
                return false;
            <?php }else{ ?>
                showFields(value,1,'',isLoad);
            <?php } ?>
        }
       en4.core.runonce.add(function(){
                formObj = sesJqueryObject('#estore_create_form').find('div').find('div').find('div');
                var sesdevelopment = 1;
                <?php if((isset($this->category_id) && $this->category_id != 0) || (isset($_GET['category_id']) && $_GET['category_id'] != 0)){ ?>
                        <?php if(isset($this->subcat_id)){$catId = $this->subcat_id;}else $catId = ''; ?>
                        showSubCategory('<?php echo isset($_GET['category_id'])? $_GET['category_id']:$this->category_id; ?>','<?php echo $catId; ?>','yes');
                 <?php  }else{ ?>
                    formObj.find('#subcat_id-wrapper').hide();
                 <?php } ?>
                 <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
                    if (<?php echo isset($this->subcat_id) && intval($this->subcat_id) > 0 ? $this->subcat_id : 'sesdevelopment' ?> == 0) {
                     formObj.find('#subsubcat_id-wrapper').hide();
                    } else {
                        <?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
                        showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
                    }
                 <?php }else{ ?>
                         formObj.find('#subsubcat_id-wrapper').hide();
                 <?php } ?>
                showCustomOnLoad('','no');
      });

    //drag drop photo upload
     en4.core.runonce.add(function()
      {
        if(sesJqueryObject('#dragandrophandlerbackground').hasClass('requiredClass')){
            sesJqueryObject('#dragandrophandlerbackground').parent().parent().find('#photouploader-label').find('label').addClass('required').removeClass('optional');	
        }
        $('photouploader-wrapper').style.display = 'block';
        $('store_main_photo_preview-wrapper').style.display = 'none';
        $('photo-wrapper').style.display = 'none';

    var obj = sesJqueryObject('#dragandrophandlerbackground');
    obj.click(function(e){
        sesJqueryObject('#photo').val('');
        sesJqueryObject('#store_main_photo_preview').attr('src','');
      sesJqueryObject('#photo').trigger('click');
    });
    obj.on('dragenter', function (e) 
    {
        e.stopPropagation();
        e.preventDefault();
        sesJqueryObject (this).addClass("sesbd");
    });
    obj.on('dragover', function (e) 
    {
         e.stopPropagation();
         e.preventDefault();
    });
    obj.on('drop', function (e) 
    {
             sesJqueryObject (this).removeClass("sesbd");
             sesJqueryObject (this).addClass("sesbm");
         e.preventDefault();
         var files = e.originalEvent.dataTransfer;
         handleFileBackgroundUpload(files,'store_main_photo_preview');
    });
    sesJqueryObject (document).on('dragenter', function (e) 
    {
        e.stopPropagation();
        e.preventDefault();
    });
    sesJqueryObject (document).on('dragover', function (e) 
    {
      e.stopPropagation();
      e.preventDefault();
    });
        sesJqueryObject (document).on('drop', function (e) 
        {
                e.stopPropagation();
                e.preventDefault();
        });
    });
     var rotation = {
       1: 'rotate(0deg)',
       3: 'rotate(180deg)',
       6: 'rotate(90deg)',
       8: 'rotate(270deg)'
     };
     function _arrayBufferToBase64(buffer) {
       var binary = ''
       var bytes = new Uint8Array(buffer)
       var len = bytes.byteLength;
       for (var i = 0; i < len; i++) {
         binary += String.fromCharCode(bytes[i])
       }
       return window.btoa(binary);
     }
   var orientation = function(file, callback) {
     var fileReader = new FileReader();
     fileReader.onloadend = function() {
       var base64img = "data:" + file.type + ";base64," + _arrayBufferToBase64(fileReader.result);
       var scanner = new DataView(fileReader.result);
       var idx = 0;
       var value = 1; // Non-rotated is the default
       if (fileReader.result.length < 2 || scanner.getUint16(idx) != 0xFFD8) {
         // Not a JPEG
         if (callback) {
           callback(base64img, value);
         }
         return;
       }
       idx += 2;
       var maxBytes = scanner.byteLength;
       while (idx < maxBytes - 2) {
         var uint16 = scanner.getUint16(idx);
         idx += 2;
         switch (uint16) {
           case 0xFFE1: // Start of EXIF
             var exifLength = scanner.getUint16(idx);
             maxBytes = exifLength - idx;
             idx += 2;
             break;
           case 0x0112: // Orientation tag
             // Read the value, its 6 bytes further out
             // See store 102 at the following URL
             // http://www.kodak.com/global/plugins/acrobat/en/service/digCam/exifStandard2.pdf
             value = scanner.getUint16(idx + 6, false);
             maxBytes = 0; // Stop scanning
             break;
         }
       }
       if (callback) {
         callback(base64img, value);
       }
     }
     fileReader.readAsArrayBuffer(file);
   };
   var estoreidparam = "";
    function handleFileBackgroundUpload(input,id) {
      var files = sesJqueryObject(input)[0].files[0];
      var url = input.value;
      if(typeof url == 'undefined')
        url = input.files[0]['name'];
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
       /* var reader = new FileReader();
        reader.onload = function (e) {  
         // $(id+'-wrapper').style.display = 'block';
          $(id).setAttribute('src', e.target.result);
        }*/
        estoreidparam = id;
        if (files) {
           orientation(files, function(base64img, value) {
             //$(id+'-wrapper').attr('src', base64img);
             sesJqueryObject(estoreidparam).closest('.form-wrapper').show();;
             var rotated = sesJqueryObject(estoreidparam).attr('src', base64img);
             if (value) {
               sesJqueryObject(estoreidparam).css('transform', rotation[value]);
             }
           });
         }
        
        $('photouploader-element').style.display = 'none';
        $('removeimage-wrapper').style.display = 'block';
        $('removeimage1').style.display = 'inline-block';
        $('store_main_photo_preview').style.display = 'block';
        $('store_main_photo_preview-wrapper').style.display = 'block';
        //reader.readAsDataURL(input.files[0]);
      }
    }
    function removeImage() {
        $('photouploader-element').style.display = 'block';
        $('removeimage-wrapper').style.display = 'none';
        $('removeimage1').style.display = 'none';
        $('store_main_photo_preview').style.display = 'none';
        $('store_main_photo_preview-wrapper').style.display = 'none';
        $('store_main_photo_preview').src = '';
        $('MAX_FILE_SIZE').value = '';
        $('removeimage2').value = '';
        $('photo').value = '';
    }
    //validate form
    //Ajax error show before form submit
    var error = false;
    var objectError ;
    var counter = 0;
    function validateForm(){
            var errorPresent = false;
            counter = 0;
            sesJqueryObject('#estore_create_form input, #estore_create_form select,#estore_create_form checkbox,#estore_create_form textarea,#estore_create_form radio').each(
                    function(index){
                            var input = sesJqueryObject(this);
                            if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
                              if(sesJqueryObject(this).prop('type') == 'checkbox'){
                                    value = '';
                                    if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
                                            value = 1;
                                    };
                                    if(value == '')
                                        error = true;
                                    else
                                        error = false;
                                }else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
                                    if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                                        error = true;
                                    else
                                        error = false;
                                }else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
                                    if(sesJqueryObject(this).val() === '')
                                        error = true;
                                    else
                                        error = false;
                                }else if(sesJqueryObject(this).prop('type') == 'radio'){
                                    if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
                                        error = true;
                                    else
                                        error = false;
                                }else if(sesJqueryObject(this).prop('type') == 'textarea'){
                                    if(sesJqueryObject(this).css('display') == 'none'){
                                     var	content = tinymce.get(sesJqueryObject(this).attr('id')).getContent();
                                     if(!content)
                                        error= true;
                                     else
                                        error = false;
                                    }else	if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                                        error = true;
                                    else
                                        error = false;
                                }else{
                                    if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
                                        error = true;
                                    else
                                        error = false;
                                }
                                if(error){
                                 if(counter == 0){
                                    objectError = this;
                                 }
                                    counter++
                                }else{
                                        if(sesJqueryObject('#photo').length && sesJqueryObject('#photo').val() === '' && sesJqueryObject('#photouploader-label').find('label').hasClass('required')){
                                                objectError = sesJqueryObject('#dragandrophandlerbackground');
                                                error = true;
                                        }
                                }
                                if(error)
                                    errorPresent = true;
                                error = false;
                            }
                    }
                );
                return errorPresent ;
    }
      en4.core.runonce.add(function() {
        sesJqueryObject('#estore_create_form').submit(function(e){
          var validationFm = validateForm();
          if(validationFm) {
            alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
            if(typeof objectError != 'undefined'){
             var errorFirstObject = sesJqueryObject(objectError).parent().parent();
             <?php if(!$this->typesmoothbox){ ?>
              sesJqueryObject('html, body').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php }else{ ?>
              sesJqueryObject('#estore_create_form').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php } ?>
            }
            return false;	
          }
          else{
            var showErrorMessage = checkAllDateFields();
            if(showErrorMessage != ''){
              sesJqueryObject('#store_error_time-wrapper').show();
              sesJqueryObject('#store_error_time-element').text(showErrorMessage);
              var errorFirstObject = sesJqueryObject('.estore_choose_date');
              <?php if(!$this->typesmoothbox){ ?>
              sesJqueryObject('html, body').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php }else{ ?>
              sesJqueryObject('#sessmoothbox_container').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php } ?>
              return false;
            }else{
              sesJqueryObject('#store_error_time-wrapper').hide();
            }
            if(!validUrl){
              objectError = sesJqueryObject('#custom_url');
              alert('<?php echo $this->translate("Invalid Custom URL"); ?>');
              if(typeof objectError != 'undefined'){
               var errorFirstObject = sesJqueryObject(objectError).parent().parent();
               <?php if(!$this->typesmoothbox){ ?>
              sesJqueryObject('html, body').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php }else{ ?>
              sesJqueryObject('#sessmoothbox_container').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php } ?>
              }
              return false;	
            }else{
              sesJqueryObject('#submit').attr('disabled',true);
              sesJqueryObject('.estore_create_loading').show();
              sesJqueryObject('.estore_create_form').addClass('_success');
              sesJqueryObject('#submit').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
              return true;
            }
          }			
        });
      });
  sesJqueryObject(document).on('change','input[type=radio][name=enable_lock]',function(){
    if (this.value == 1)
    sesJqueryObject('#store_password-wrapper').show();
    else
    sesJqueryObject('#store_password-wrapper').hide();
  });
  
    sesJqueryObject(document).on('change','input[type=radio][name=can_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#approval-wrapper').show();
      sesJqueryObject('#member_title_singular-wrapper').show();
      sesJqueryObject('#member_title_plural-wrapper').show();
    }
    else {
      sesJqueryObject('#approval-wrapper').hide();
      sesJqueryObject('#member_title_singular-wrapper').hide();
      sesJqueryObject('#member_title_plural-wrapper').hide();
    }
  });
  
  en4.core.runonce.add(function() {
    var valueStyle = sesJqueryObject('input[name=enable_lock]:checked').val();
    if(valueStyle == 1) 
    sesJqueryObject('#store_password-wrapper').show();
    else 
    sesJqueryObject('#store_password-wrapper').hide();
    var valueStyle = sesJqueryObject('input[name=can_join]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#approval-wrapper').show();
      sesJqueryObject('#member_title_singular-wrapper').show();
      sesJqueryObject('#member_title_plural-wrapper').show();
    }
    else { 
      sesJqueryObject('#approval-wrapper').hide();
      sesJqueryObject('#member_title_singular-wrapper').hide();
      sesJqueryObject('#member_title_plural-wrapper').hide();
    }
  });
 </script>
  <?php if($this->typesmoothbox) { ?>
   <script type="application/javascript">
     executetimesmoothboxTimeinterval = 700;
     executetimesmoothbox = true;
     en4.core.runonce.add(function() {
       sesJqueryObject('#estore_create_form').attr('action',sesJqueryObject('#estore_create_form').attr('action').replace('?format=html&typesmoothbox=sessmoothbox',''));   
       tinymce.init({
         mode: "specific_textareas",
         plugins: "table,fullscreen,media,preview,paste,code,image,textcolor,jbimages,link",
         theme: "modern",
         menubar: false,
         statusbar: false,
         toolbar1:  "undo,redo,removeformat,pastetext,|,code,media,image,jbimages,link,fullscreen,preview",
         toolbar2: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,forecolor,backcolor,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,outdent,indent,blockquote",
         toolbar3: "",
         element_format: "html",
         height: "225px",
   content_css: "bbcode.css",
   entity_encoding: "raw",
   add_unload_trigger: "0",
   remove_linebreaks: false,
         convert_urls: false,
         language: "<?php echo $this->language; ?>",
         directionality: "<?php echo $this->direction; ?>",
         upload_url: "<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'index', 'action' => 'upload-image'), 'default', true); ?>",
         editor_selector: "tinymce"
       });
     });
   </script>	
 <?php die;} ?>
<?php else:?>
  <div class="sesbasic_tip clearfix estore_error">
    <img src="application/modules/Estore/externals/images/store-icon-error.png" alt="">
    <span><?php echo $this->translate("You have reached the limit of store creation. Please contact to the site administrator.");?></span>
  </div>
<?php endif;?>
