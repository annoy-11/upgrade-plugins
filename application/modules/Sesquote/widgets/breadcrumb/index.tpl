<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $isValid = false;
  if(isset($this->quote->resource_type) && $this->quote->resource_type){
    $item = Engine_Api::_()->getItem($this->quote->resource_type,$this->quote->resource_id);
    if($item)
      $isValid = true;
  }
  $dontShow = true;
  if($isValid && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.other.modulequotes', 0))
    $dontShow = false;
   
?>
<div class="sesbasic_breadcrumb">
  <?php if($dontShow): ?>
  <a href="<?php echo $this->url(array('action' => 'index'), "sesquote_general"); ?>"><?php echo $this->translate("Browse Quote"); ?></a>&nbsp;&raquo;
  <?php if($this->quote->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.enablecategory', 1)) { ?>
    <?php $category = Engine_Api::_()->getItem('sesquote_category', $this->quote->category_id); ?>
    <a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$this->quote->category_id; ?>"><?php echo $category->category_name; ?></a>
    <?php if($this->quote->subcat_id) { ?>
      &nbsp;&raquo;
      <?php $subcategory = Engine_Api::_()->getItem('sesquote_category', $this->quote->subcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$this->quote->category_id.'&subcat_id='.$this->quote->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
    <?php } ?>
    <?php if($this->quote->subsubcat_id) { ?>
      &nbsp;&raquo;
      <?php $subsubcategory = Engine_Api::_()->getItem('sesquote_category', $this->quote->subsubcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'sesquote_general').'?category_id='.$this->quote->category_id.'&subcat_id='.$this->quote->subcat_id.'&subsubcat_id='.$this->quote->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>&nbsp;&raquo; 
    <?php } ?>
  <?php } ?>
  <?php endif; ?>
  <?php if($this->quote->resource_type == 'sesgroup_group' && $isValid):?>
    <?php if($item): ?>
      <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
  <?php endif; ?>
  <?php echo $this->string()->truncate($this->string()->stripTags($this->quote->getTitle()), 50) ?> 
</div>
