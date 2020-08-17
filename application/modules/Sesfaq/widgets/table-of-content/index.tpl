<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $widgetParams = $this->widgetParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesfaq/externals/styles/styles.css'); ?>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $moduleName = $request->getModuleName();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName(); ?>
<?php $faq_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('faq_id', null); ?>
<script>

 function faqhideShow(id, param) {
  if(param == 'cat') {
    if($('main_category_'+id).style.display == 'block' || $('main_category_'+id).style.display == '') {
      $('main_category_'+id).style.display = 'none';
      $('maincategory_'+id).innerHTML = '<i class="fa fa-plus-square-o"></i>';
    } else {
      $('main_category_'+id).style.display = 'block';
      $('maincategory_'+id).innerHTML = '<i class="fa fa-minus-square-o"></i>';
    }
  } else if(param == 'subcat') {
    if($('sub_category_'+id).style.display == 'block' || $('sub_category_'+id).style.display == '') {
      $('sub_category_'+id).style.display = 'none';
      $('subf_category_'+id).style.display = 'none';
      $('subcategory_'+id).innerHTML = '<i class="fa fa-caret-right"></i>';
    } else {
      $('sub_category_'+id).style.display = 'block';
      $('subf_category_'+id).style.display = 'block';
      $('subcategory_'+id).innerHTML = '<i class="fa fa-caret-down"></i>';
    }
  } else if(param == 'subsubcat') {
    if($('subsubf_category_'+id).style.display == 'block' || $('subsubf_category_'+id).style.display == '') {
      $('subsubf_category_'+id).style.display = 'none';
      $('subsubcategory_'+id).innerHTML = '<i class="fa fa-caret-right"></i>';
    } else {
      $('subsubf_category_'+id).style.display = 'block';
      $('subsubcategory_'+id).innerHTML = '<i class="fa fa-caret-down"></i>';
    }
  }
 }
</script>
<div class="sesfaq_clearfix sesfaq_bxs sesfaq_tags_cloud_faq sesfaq_content_table">
  <?php $i = 1; ?>
  <?php foreach($this->resultcategories as $resultcategorie): ?>
      <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getCategoryFaqSelect(array('onlyFaq' => 1, 'category_id' => $resultcategorie->category_id)); //if(count($categoriesFaqs) == 0) continue; 
      
      $faqsCount = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->countFaqs(array('category_id' => $resultcategorie->category_id, 'fetchAll' => 1));
      
      ?>
      <div class="maincat">
        <?php if(count($faqsCount) > 0) { ?>
      	<a <?php if(@$this->widgetParams['viewType'] == 'expanded' && !@$this->widgetParams['showicons']) { ?> style="display:none;" <?php } ?> class="sesfaq_hideshow_btn" id="maincategory_<?php echo $resultcategorie->getIdentity(); ?>" href="javascript:void(0);" onclick="faqhideShow('<?php echo $resultcategorie->getIdentity() ?>', 'cat');"><i class="<?php if($this->widgetParams['viewType'] == 'collapsed') { ?> fa fa-plus-square-o <?php } else { ?> fa fa-minus-square-o <?php } ?>"></i></a>
      	<?php } ?>
      	<span><?php echo $this->translate($resultcategorie->category_name); ?></span>
      </div>  
      <div <?php if(count($faqsCount) > 0) { ?><?php if($this->widgetParams['viewType'] == 'collapsed') { ?> style="display:none" <?php } } else { ?> style="display:none" <?php } ?>  class="maincat_cont" id="main_category_<?php echo $resultcategorie->getIdentity(); ?>">
        
        <?php if(count($categoriesFaqs) > 0) { ?>
          <?php $j = 1; ?>
          <?php foreach($categoriesFaqs as $faq) { ?>
          	<div class="table_cont 1st-lavel <?php if($controllerName == 'index' && $actionName == 'view' && $faq_id == $faq->getIdentity()) { ?> _faq_active <?php } ?>">
            	<span>
            		<span class="sesfaq_no"><?php echo $i.'.'.$j; ?></span><span class="sesfaq_label"><a href="<?php echo $faq->getHref(); ?>"><?php echo $faq->getTitle(); ?></a></span>
              </span>
          	</div>
          <?php $j++; } ?>
        <?php } ?>
        <?php //subcategory work ?>
        <?php $subCategories = Engine_Api::_()->getDbTable('categories', 'sesfaq')->getModuleSubcategory(array('category_id' => $resultcategorie->getIdentity(), 'column_name' => '*')); ?>
        <?php $g = !empty($j) ? $j : 1; ?>
        <?php foreach($subCategories as $subCategory) { ?>
          <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getCategoryFaqSelect(array('onlyFaq' => 2, 'category_id' => $resultcategorie->category_id, 'subcat_id' => $subCategory->getIdentity())); ?>
          <?php if(count($categoriesFaqs) > 0) { ?>
          	<div class="table_cont first-lavel">
            	<a <?php if($this->widgetParams['viewType'] == 'expanded' && !$this->widgetParams['showicons']) { ?> style="display:none;" <?php } ?>  class="sesfaq_hideshow_btn" id="subcategory_<?php echo $subCategory->getIdentity(); ?>" href="javascript:void(0);" onclick="faqhideShow('<?php echo $subCategory->getIdentity() ?>', 'subcat');"><i class="fa fa-caret-down"></i></a>
              <span>
            		<span class="sesfaq_no"><?php echo $i . '.'.$g; ?></span><span class="sesfaq_label"><?php echo $this->translate($subCategory->category_name); ?></span>
              </span>
            	</div>
            <?php $t = 1; ?>
            <div id="subf_category_<?php echo $subCategory->getIdentity(); ?>">
              <?php foreach($categoriesFaqs as $faq) { ?>
              	<div class="table_cont second-lavel <?php if($controllerName == 'index' && $actionName == 'view' && $faq_id == $faq->getIdentity()) { ?> _faq_active <?php } ?>">
                	<span>
                		<span class="sesfaq_no"><?php echo $i . '.'.$g.'.'.$t; ?></span><span class="sesfaq_label"><a href="<?php echo $faq->getHref(); ?>"><?php echo $faq->getTitle(); ?></a></span>
                  </span>
              	</div>
              <?php $t++; } ?>
            </div>
          <?php } ?>
          <div id="sub_category_<?php echo $subCategory->getIdentity(); ?>">
            <?php //subsubcategory work ?>
            <?php $subsubCategories = Engine_Api::_()->getDbTable('categories', 'sesfaq')->getModuleSubsubcategory(array('category_id' => $subCategory->getIdentity(), 'column_name' => '*')); ?>
            <?php $p = !empty($t) ? $t : 1; ?>
            <?php foreach($subsubCategories as $subsubCategory) { ?>
              <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getCategoryFaqSelect(array('onlyFaq' => 3, 'category_id' => $resultcategorie->category_id, 'subcat_id' => $subCategory->getIdentity(), 'subsubcat_id' => $subsubCategory->getIdentity())); ?>
              <?php if(count($categoriesFaqs) > 0) { ?>
              	<div class="table_cont second-lavel">
                <a <?php if($this->widgetParams['viewType'] == 'expanded' && !$this->widgetParams['showicons']) { ?> style="display:none;" <?php } ?>  class="sesfaq_hideshow_btn" id="subsubcategory_<?php echo $subsubCategory->getIdentity(); ?>" href="javascript:void(0);" onclick="faqhideShow('<?php echo $subsubCategory->getIdentity() ?>', 'subsubcat');"><i class="fa fa-caret-down"></i></a>
                	<span><span class="sesfaq_no"><?php echo $i . '.'.$g.'.'.$p; ?></span><span class="sesfaq_label"><?php echo $this->translate($subsubCategory->category_name); ?></span>
                	</span>
                </div>
                <?php $h = 1; ?>
                <div id="subsubf_category_<?php echo $subsubCategory->getIdentity(); ?>">
                  <?php foreach($categoriesFaqs as $faq) { ?>
                  	<div class="table_cont third-lavel <?php if($controllerName == 'index' && $actionName == 'view' && $faq_id == $faq->getIdentity()) { ?> _faq_active <?php } ?>">
                    	<span><span class="sesfaq_no"><?php echo $i . '.'.$g.'.'.$p.'.'.$h; ?></span><span class="sesfaq_label"><a href="<?php echo $faq->getHref(); ?>"><?php echo $faq->getTitle(); ?></a></span></span>
                    </div>
                  <?php $h++; } ?>
                </div>
              <?php } ?>
            <?php $p++; } ?>
          </div>
        <?php $g++; } ?>
      </div>
    <?php $i++; ?>
  <?php endforeach; ?>
</div>
