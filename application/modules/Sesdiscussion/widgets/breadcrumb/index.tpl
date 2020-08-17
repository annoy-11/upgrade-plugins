<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'index'), "sesdiscussion_general"); ?>"><?php echo $this->translate("Browse Discussion"); ?></a>&nbsp;&raquo;
  <?php if($this->discussion->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1)) { ?>
    <?php $category = Engine_Api::_()->getItem('sesdiscussion_category', $this->discussion->category_id); ?>
    <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$this->discussion->category_id; ?>"><?php echo $category->category_name; ?></a>
    <?php if($this->discussion->subcat_id) { ?>
      &nbsp;&raquo;
      <?php $subcategory = Engine_Api::_()->getItem('sesdiscussion_category', $this->discussion->subcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$this->discussion->category_id.'&subcat_id='.$this->discussion->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
    <?php } ?>
    <?php if($this->discussion->subsubcat_id) { ?>
      &nbsp;&raquo;
      <?php $subsubcategory = Engine_Api::_()->getItem('sesdiscussion_category', $this->discussion->subsubcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'sesdiscussion_general').'?category_id='.$this->discussion->category_id.'&subcat_id='.$this->discussion->subcat_id.'&subsubcat_id='.$this->discussion->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
    <?php } ?>
    &nbsp;&raquo;
  <?php } ?>
  <?php echo $this->string()->truncate($this->string()->stripTags($this->discussion->getTitle()), 50) ?> 
</div>
