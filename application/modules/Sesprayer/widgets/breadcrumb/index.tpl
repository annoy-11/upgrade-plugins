<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'index'), "sesprayer_general"); ?>"><?php echo $this->translate("Browse Prayer"); ?></a>&nbsp;&raquo;
  <?php if($this->prayer->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.enablecategory', 1)) { ?>
    <?php $category = Engine_Api::_()->getItem('sesprayer_category', $this->prayer->category_id); ?>
    <a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$this->prayer->category_id; ?>"><?php echo $category->category_name; ?></a>
    <?php if($this->prayer->subcat_id) { ?>
      &nbsp;&raquo;
      <?php $subcategory = Engine_Api::_()->getItem('sesprayer_category', $this->prayer->subcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$this->prayer->category_id.'&subcat_id='.$this->prayer->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
    <?php } ?>
    <?php if($this->prayer->subsubcat_id) { ?>
      &nbsp;&raquo;
      <?php $subsubcategory = Engine_Api::_()->getItem('sesprayer_category', $this->prayer->subsubcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'sesprayer_general').'?category_id='.$this->prayer->category_id.'&subcat_id='.$this->prayer->subcat_id.'&subsubcat_id='.$this->prayer->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
    <?php } ?>
  <?php } ?>
  <?php echo $this->string()->truncate($this->string()->stripTags($this->prayer->getTitle()), 50) ?> 
</div>
