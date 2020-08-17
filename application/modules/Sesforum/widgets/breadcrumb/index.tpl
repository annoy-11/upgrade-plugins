<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_breadcrumb" style="font-size:<?php echo is_numeric($this->fontSize) ? $this->fontSize.'px' : $this->fontSize ?>;">
  <a href="<?php echo $this->url(array('action' => 'index'), 'sesforum_general'); ?>"><?php echo $this->translate("Forums"); ?></a>
   <?php if(!empty($this->subjectCategory) && $this->subjectCategory->getType() == 'sesforum_category') { ?>&nbsp;&raquo;
    <?php if($this->subjectCategory->subcat_id) { ?>
        <?php $category = Engine_Api::_()->getItem('sesforum_category',$this->subjectCategory->subcat_id); ?>
          <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a>&nbsp;&raquo;
    <?php } ?>
   <?php if($this->subjectCategory->subsubcat_id) { ?>
        <?php $subcategory = Engine_Api::_()->getItem('sesforum_category',$this->subjectCategory->subsubcat_id); ?>
        <?php if($subcategory->subcat_id) { ?>
            <?php $category = Engine_Api::_()->getItem('sesforum_category',$subcategory->subcat_id); ?>
            <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a>&nbsp;&raquo;
        <?php } ?>
         <a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->getTitle(); ?></a>&nbsp;&raquo;
    <?php } ?>
        <?php echo $this->subjectCategory->getTitle(); ?>
  <?php }  ?>
  
  <?php if(!empty($this->subject) && $this->subject->getType() == 'sesforum_forum') { ?> &nbsp;&raquo;
    <?php $category_id = $this->subject->category_id;
      $category = Engine_Api::_()->getItem('sesforum_category', $category_id); ?>
    <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a>&nbsp;&raquo;
    <?php echo $this->subject->getTitle(); ?>
  <?php } ?>
  <?php if(!empty($this->subjectTopic) && $this->subjectTopic->getType() == 'sesforum_topic') {  ?> &nbsp;&raquo;
    <?php $forum = Engine_Api::_()->getItem('sesforum_forum', $this->subjectTopic->forum_id); ?>
      <?php $category_id = $forum->category_id;
        $category = Engine_Api::_()->getItem('sesforum_category', $category_id); ?>
      <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a>&nbsp;&raquo;
      <a href="<?php echo $forum->getHref(); ?>"><?php echo $forum->getTitle(); ?></a>
      &nbsp;&raquo; <?php echo $this->subjectTopic->getTitle(); ?>
  <?php } ?>
</div>
