<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: profile-field.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<style>
  .tag img{
    float:left;height:25px;width:25px;
  }
  #category_id-wrapper, #subcat_id-wrapper, #subsubcat_id-wrapper {
    display: none;
  }
</style>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php if(!$this->is_ajax){ ?>
<?php echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array('business' => $this->business));?>
	<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    <div class="sesbusiness_dashboard_form <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.create.form', 1)):?>sesbusiness_create_form<?php endif;?>">
      <?php echo $this->form->render() ?>
    </div>
		<?php if(!$this->is_ajax){ ?>
	</div>
</div>
</div>
<?php  } ?>
<script type="text/javascript">
  jqueryObjectOfSes(document).ready(function(){
    jqueryObjectOfSes('#subcat_id-wrapper').css('display' , 'none');
    jqueryObjectOfSes('#subsubcat_id-wrapper').css('display' , 'none');
  });
</script>
<?php $defaultProfileFieldId = "0_0_$this->defaultProfileId";$profile_type = 2;?>
<?php echo $this->partial('_customFields.tpl', 'sesbasic', array()); ?>
<script type="text/javascript">
  var defaultProfileFieldId = '<?php echo $defaultProfileFieldId ?>';
  var profile_type = '<?php echo $profile_type ?>';
  var previous_mapped_level = 0;
  function showFields(cat_value, cat_level,typed,isLoad) {
    if(isLoad == 'custom'){
      var type = typed;
    }else{
      var categoryId = getProfileType($('category_id').value);
      var subcatId = getProfileType($('subcat_id').value);
      var subsubcatId = getProfileType($('subsubcat_id').value);
      var type = categoryId+','+subcatId+','+subsubcatId;
    }
    if (cat_level == 1 || (previous_mapped_level >= cat_level && previous_mapped_level != 1) || (profile_type == null || profile_type == '' || profile_type == 0)) {
      profile_type = getProfileType(cat_value);
      if (profile_type == 0) {
        profile_type = '';
      } else {
        previous_mapped_level = cat_level;
      }
      $(defaultProfileFieldId).value = profile_type;
      changeFields($(defaultProfileFieldId),null,isLoad,type);
    }
  }
  var getProfileType = function(category_id) {
    var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getMapping(array('category_id', 'profile_type'))); ?>;
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
  
  function showCustom(value,isLoad){
    var categoryId = getProfileType($('category_id').value);
    var subcatId = getProfileType($('subcat_id').value);
    var id = categoryId+','+subcatId;
    if(isLoad != 'yes')
    showFields(value,1,id,isLoad);
    if(value == 0)
    document.getElementsByName("0_0_1")[0].value=subcatId;	
    return false;
  }
  function showCustomOnLoad(value,isLoad){
    <?php if(isset($this->category_id) && $this->category_id != 0){ ?>
    var categoryId = getProfileType(<?php echo $this->category_id; ?>)+',';
    <?php }else{ ?>
    var categoryId = '0';
    <?php } ?>
    <?php if(isset($this->subcat_id) && $this->subcat_id != 0){ ?>
    var subcatId = getProfileType(<?php echo $this->subcat_id; ?>)+',';
    <?php  }else{ ?>
    var subcatId = '0';
    <?php } ?>
    <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
    var subsubcat_id = getProfileType(<?php echo $this->subsubcat_id; ?>)+',';
    <?php  }else{ ?>
    var subsubcat_id = '0';
    <?php } ?>
    var id = (categoryId+subcatId+subsubcat_id).replace(/,+$/g,"");;
    showFields(value,1,id,'custom');
    if(value == 0)
    document.getElementsByName("0_0_1")[0].value=subcatId;	
    return false;	
  }
  window.addEvent('domready', function() {
    showCustomOnLoad('','no');
  });
</script>
