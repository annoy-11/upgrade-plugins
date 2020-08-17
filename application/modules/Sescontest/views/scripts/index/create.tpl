<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php 
      if($this->resource_id && $this->resource_type){ ?> 
        <?php
          $tabid = "";
          if($this->widget_id)
            $tabid = "/tab/".$this->widget_id;
          echo $this->htmlLink($this->item->getHref().$tabid, $this->translate('Go Back'), array(
            'class' => 'sesbasic_button sesbasic_icon_add'
            ));
      ?>
        
<?php }
?>

<?php if($this->createLimit == 1):?>
  <?php if(!$this->typesmoothbox){ ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/styles.css'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/moment.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/flexcroll.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/moment-timezone.js'); ?>
     <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/moment-timezone-with-data.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Observer.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Local.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Request.js'); ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/jquery.timepicker.css'); ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/bootstrap-datepicker.css'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/jquery.timepicker.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/bootstrap-datepicker.js'); ?>
  <?php }else{ ?>
    <script type="application/javascript">
      Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/styles.css'; ?>");
      Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'; ?>");
      Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/moment.js'; ?>");
       Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/moment-timezone.js'; ?>");
       Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/scripts/moment-timezone-with-data.js'; ?>");
    </script>
  <?php } ?>
  <?php if(count($_POST) == 0 && Engine_Api::_()->getApi('settings','core')->getSetting('sescontest.category.selection', 1)):?>
      <div class="sescontest_create_step_container sesbasic_bxs sesbasic_clearfix">
        <h3><?php echo $this->translate('Create New Contest');?></h3>
        <p><?php echo $this->translate("It's easy to set up. Just choose a Contest category to get started.");?></p>
        <?php $iconType = Engine_Api::_()->getApi('settings','core')->getSetting('sescontest.category.icon');?>
        <?php if($iconType == 0):?>
          <?php $icon = 'colored_icon';?>
        <?php elseif($iconType == 1):?>
          <?php $icon = 'cat_icon';?>
        <?php elseif($iconType == 2):?>
          <?php $icon = 'thumbnail';?>
        <?php endif;?>
        <div class="sescontest_create_categories_listing">
          <?php foreach($this->categories as $category):?>
            <div class="sescontest_create_category">
              <section class="">
                <div class="_inner">
                  <div class="_step1">
                    <a href="javascript:;" class="sesbasic_linkinherit" onClick="selectCat(<?php echo $category->category_id;?>);return false;">
                      <?php if($category->$icon):?>
                        <i style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($category->$icon)->getPhotoUrl();?>);"></i>
                      <?php else:?>
                        <i style="background-image:url(application/modules/Sescontest/externals/images/contest-icon-big.png);"></i>
                      <?php endif;?>
                      <span><?php echo $category->category_name;?></span>
                    </a>
                  </div>
                </div>
              </section>
            </div>   
          <?php endforeach;?>
        </div>
      </div>
    <?php endif; ?>
    <div class="sescontest_create_container <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.create.form', 1)):?>sescontest_create_form<?php endif;?>">
        <?php echo $this->form->render();?>
        <div class="sescontest_join_loading sescontest_join_overlay">
          <div class="sescontest_join_overlay_cont">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>
            <span class="_text"><?php echo $this->translate('Creating Contest ...');?></span>
          </div>
        </div>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.guidelines', 1) && !empty(Engine_Api::_()->getApi('settings','core')->getSetting('sescontest.message.guidelines', ''))):?>
          <div id="sescontest_create_tips" class="sescontest_create_tips">
            <div class="create_tips_top_sec">
              <h3><?php echo $this->translate('Tips');?></h3>
            </div>
            <div class="create_tips_bottom_sec">
              <div class="sesbasic_html_block">
                <?php echo Engine_Api::_()->getApi('settings','core')->getSetting('sescontest.message.guidelines', '');?>
              </div>
            </div>
          </div>
        <?php endif;?>
      </div>
   
    <script type="application/javascript">
      
      en4.core.runonce.add(function(){
         if(sesJqueryObject('.sescontest_create_step_container').length > 0){
           sesJqueryObject('.sescontest_create_container').hide();
           sesJqueryObject('.sescontest_create_step_container').show();
           sesJqueryObject('.sescontest_create_tips').hide();
         }else{
           sesJqueryObject('.sescontest_create_tips').show();
           sesJqueryObject('.sescontest_create_container').show();
           sesJqueryObject('.sescontest_create_step_container').hide();
         }
      });
      function selectCat(value){
        sesJqueryObject('.sescontest_create_tips').show();
       sesJqueryObject('#category_id').val(value);
       sesJqueryObject('#category_id').trigger('change');
       sesJqueryObject('.sescontest_create_container').show();
       sesJqueryObject('.sescontest_create_step_container').hide();
      }
      sesJqueryObject(function() {
        sesJqueryObject.fn.scrollBottom = function() {
             return sesJqueryObject(document).height() - this.scrollTop() - this.height();
        };
        var $el = sesJqueryObject('#sescontest_create_tips');
        var positionInitial = sesJqueryObject('#title').offsetTop;
        sesJqueryObject('<style>#sescontest_create_tips{top:'+positionInitial+'px;}</style>').appendTo(document.head);
        var $window = sesJqueryObject(window);

        $window.bind("scroll resize", function() {
          var positionInitialTitle = sesJqueryObject('#title-element').offsetTop;
          var position = $el.offset().top - $window.scrollTop();
          if($window.scrollTop() < positionInitial){
             $el.css('top',positionInitial);
          }else{
             $el.css('top',$window.scrollTop());
          }
        });
      });
    
    </script>

    <script type="text/javascript">
    //trim last -
    function removeLastMinus (myUrl)
    {
        if (myUrl.substring(myUrl.length-1) == "-")
        {
            myUrl = myUrl.substring(0, myUrl.length-1);
        }
        return myUrl;
    }
    var changeTitle = true;
    var validUrl = true;
      en4.core.runonce.add(function()
      {
        if(sesJqueryObject('#editor_type') && sesJqueryObject('#contest_type option:selected').val() == '1')
        sesJqueryObject('#editor_type-wrapper').show();
        else
        sesJqueryObject('#editor_type-wrapper').hide();

        if(sesJqueryObject('#sescontest_announcement_date') && sesJqueryObject('#vote_type').val() == '1')
        sesJqueryObject('#sescontest_announcement_date').show();
        else
        sesJqueryObject('#sescontest_announcement_date').hide();

            //auto fill custom url value
    sesJqueryObject("#title").keyup(function(){
            var Text = sesJqueryObject(this).val();
          if(!changeTitle)
                return;
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            Text = removeLastMinus(Text);
            sesJqueryObject("#custom_url").val(Text);        
    });
    sesJqueryObject("#title").blur(function(){
            if(sesJqueryObject(this).val()){
                    changeTitle = false;
            }
    });
    sesJqueryObject("#custom_url").blur(function(){
      validUrl = false;
      sesJqueryObject('#check_custom_url_availability').trigger('click');
    });
    //function ckeck url availability
    sesJqueryObject('#check_custom_url_availability').click(function(){
        var custom_url_value = sesJqueryObject('#custom_url').val();
        if(!custom_url_value)
            return;
        sesJqueryObject('#sescontest_custom_url_wrong').hide();
        sesJqueryObject('#sescontest_custom_url_correct').hide();
        sesJqueryObject('#sescontest_custom_url_loading').css('display','inline-block');
        sesJqueryObject.post('<?php echo $this->url(array('controller' => 'ajax','module'=>'sescontest', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response){
                    sesJqueryObject('#sescontest_custom_url_loading').hide();
                    response = sesJqueryObject.parseJSON(response);
                    if(response.error){
                        validUrl = false;
                        sesJqueryObject('#sescontest_custom_url_correct').hide();
                        sesJqueryObject('#sescontest_custom_url_wrong').css('display','inline-block');
                    }else{
                            validUrl = true;
                            sesJqueryObject('#custom_url').val(response.value);
                            sesJqueryObject('#sescontest_custom_url_wrong').hide();
                            sesJqueryObject('#sescontest_custom_url_correct').css('display','inline-block');
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
        var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'sescontest')->getMapping(array('category_id', 'profile_type'))); ?>;
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
        }
      });
      function showSubCategory(cat_id,selectedId) {
            var selected;
            if(selectedId != ''){
                var selected = selectedId;
            }
        var url = en4.core.baseUrl + 'sescontest/ajax/subcategory/category_id/' + cat_id;
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
                    //showFields(cat_id,1);
          }
        }).send(); 
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
        var url = en4.core.baseUrl + 'sescontest/ajax/subsubcategory/subcategory_id/' + cat_id;
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
                formObj = sesJqueryObject('#sescontest_create_form').find('div').find('div').find('div');
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
        $('contest_main_photo_preview-wrapper').style.display = 'none';
        $('photo-wrapper').style.display = 'none';

    var obj = sesJqueryObject('#dragandrophandlerbackground');
    obj.click(function(e){
        sesJqueryObject('#photo').val('');
        sesJqueryObject('#contest_main_photo_preview').attr('src','');
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
         handleFileBackgroundUpload(files,'contest_main_photo_preview');
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
    function handleFileBackgroundUpload(input,id) {
      var url = input.value; 
      if(typeof url == 'undefined')
        url = input.files[0]['name'];
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
        var reader = new FileReader();
        reader.onload = function (e) {
         // $(id+'-wrapper').style.display = 'block';
          $(id).setAttribute('src', e.target.result);
        }
        $('photouploader-element').style.display = 'none';
        $('removeimage-wrapper').style.display = 'block';
        $('removeimage1').style.display = 'inline-block';
        $('contest_main_photo_preview').style.display = 'block';
        $('contest_main_photo_preview-wrapper').style.display = 'block';
        reader.readAsDataURL(input.files[0]);
      }
    }
    function removeImage() {
        $('photouploader-element').style.display = 'block';
        $('removeimage-wrapper').style.display = 'none';
        $('removeimage1').style.display = 'none';
        $('contest_main_photo_preview').style.display = 'none';
        $('contest_main_photo_preview-wrapper').style.display = 'none';
        $('contest_main_photo_preview').src = '';
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
            sesJqueryObject('#sescontest_create_form input, #sescontest_create_form select,#sescontest_create_form checkbox,#sescontest_create_form textarea,#sescontest_create_form radio').each(
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
        sesJqueryObject('#sescontest_create_form').submit(function(e){
          var validationFm = validateForm();
          if(validationFm) {
            alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
            if(typeof objectError != 'undefined'){
             var errorFirstObject = sesJqueryObject(objectError).parent().parent();
             <?php if(!$this->typesmoothbox){ ?>
              sesJqueryObject('html, body').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php }else{ ?>
              sesJqueryObject('#sescontest_create_form').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php } ?>
            }
            return false;	
          }
          else{
            var showErrorMessage = checkAllDateFields();
            if(showErrorMessage != ''){
              sesJqueryObject('#contest_error_time-wrapper').show();
              sesJqueryObject('#contest_error_time-element').text(showErrorMessage);
              var errorFirstObject = sesJqueryObject('.sescontest_choose_date');
              <?php if(!$this->typesmoothbox){ ?>
              sesJqueryObject('html, body').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php }else{ ?>
              sesJqueryObject('#sessmoothbox_container').animate({scrollTop: errorFirstObject.offset().top}, 2000);
             <?php } ?>
              return false;
            }else{
              sesJqueryObject('#contest_error_time-wrapper').hide();
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
              sesJqueryObject('.sescontest_join_loading').show();
              sesJqueryObject('.sescontest_create_form').addClass('_success');
              sesJqueryObject('#submit').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
              return true;
            }
          }			
        });
      });
      function showEditorOption(value) {
        if(value == '1')
        jqueryObjectOfSes('#editor_type-wrapper').show();
        else
        jqueryObjectOfSes('#editor_type-wrapper').hide();
      }
      function showResultDate(value) {
        if(value == '1')
        jqueryObjectOfSes('#sescontest_announcement_date').show();
        else
        jqueryObjectOfSes('#sescontest_announcement_date').hide();
      }
    </script>

    <?php if($this->typesmoothbox) { ?>
      <script type="application/javascript">
        executetimesmoothboxTimeinterval = 200;
        executetimesmoothbox = true;
        en4.core.runonce.add(function() {
          sesJqueryObject('#sescontest_create_form').attr('action',sesJqueryObject('#sescontest_create_form').attr('action').replace('?format=html&typesmoothbox=sessmoothbox',''));   
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
        function showPreview(value) {
          if(value == 1)
          en4.core.showError('<a class="icon_close" onclick="parent.Smoothbox.close();"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 1")+'</p><img class="popup_img" src="./application/modules/Sescontest/externals/images/layout_1.jpg" alt="" />');
          else if(value == 2)
          en4.core.showError('<a class="icon_close" onclick="parent.Smoothbox.close();"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 2")+'</p><img src="./application/modules/Sescontest/externals/images/layout_2.jpg" alt="" />');
          else if(value == 3)
          en4.core.showError('<a class="icon_close" onclick="parent.Smoothbox.close();"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 3")+'</p><img src="./application/modules/Sescontest/externals/images/layout_3.jpg" alt="" />');
          else if(value == 4)
          en4.core.showError('<a class="icon_close" onclick="parent.Smoothbox.close();"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 4")+'</p><img src="./application/modules/Sescontest/externals/images/layout_4.jpg" alt="" />');
          return;
        }
      </script>	
    <?php die;} ?>
<?php else:?>
  <div class="sesbasic_tip clearfix sescontest_error">
    <img src="application/modules/Sescontest/externals/images/contest-icon-error.png" alt="">
    <span><?php echo $this->translate("You have reached the limit of contest creation. Please contact to the site administrator.");?></span>
  </div>
<?php endif;?>