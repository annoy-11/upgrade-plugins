<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'index'), "seswishe_general"); ?>"><?php echo $this->translate("Browse Wishe"); ?></a>&nbsp;&raquo;
  <?php if($this->wishe->category_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.enablecategory', 1)) { ?>
    <?php $category = Engine_Api::_()->getItem('seswishe_category', $this->wishe->category_id); ?>
    <a href="<?php echo $this->url(array('action' => 'index'), 'seswishe_general').'?category_id='.$this->wishe->category_id; ?>"><?php echo $category->category_name; ?></a>
    <?php if($this->wishe->subcat_id) { ?>
      &nbsp;&raquo;
      <?php $subcategory = Engine_Api::_()->getItem('seswishe_category', $this->wishe->subcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'seswishe_general').'?category_id='.$this->wishe->category_id.'&subcat_id='.$this->wishe->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
    <?php } ?>
    <?php if($this->wishe->subsubcat_id) { ?>
      &nbsp;&raquo;
      <?php $subsubcategory = Engine_Api::_()->getItem('seswishe_category', $this->wishe->subsubcat_id); ?>
      <a href="<?php echo $this->url(array('action' => 'index'), 'seswishe_general').'?category_id='.$this->wishe->category_id.'&subcat_id='.$this->wishe->subcat_id.'&subsubcat_id='.$this->wishe->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
    <?php } ?>
  <?php } ?>
  <?php echo $this->string()->truncate($this->string()->stripTags($this->wishe->getTitle()), 50) ?> 
</div>
