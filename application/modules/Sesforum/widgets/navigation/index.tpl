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

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>

<div class="sesforum_quick_navigation_container sesbasic_bxs sesbasic_clearfix">
	<div class="sesforum_quick_navigation floatL">
    <?php if(!empty($this->subjectCategory) && $this->subjectCategory->getType() == 'sesforum_category') { ?>
      <a href="javascript:vois(0);" class="sesbasic_pulldown_toggle sesbasic_bg"><span><?php echo !empty($this->subjectCategory) ? $this->translate($this->subjectCategory->title) : $this->translate("Quick Navigation"); ?></span><i class="fa fa-angle-down"></i></a>
  	<?php } elseif($this->subject && $this->subject->getType() == 'sesforum_forum') { ?>
      <a href="javascript:vois(0);" class="sesbasic_pulldown_toggle sesbasic_bg"><span><?php echo !empty($this->subject) ? $this->translate($this->subject->title) : $this->translate("Quick Navigation"); ?></span><i class="fa fa-angle-down"></i></a>
  	<?php } else { ?>
      <a href="javascript:vois(0);" class="sesbasic_pulldown_toggle sesbasic_bg"><span><?php echo $this->translate("Quick Navigation"); ?></span><i class="fa fa-angle-down"></i></a>
  	<?php } ?>
    <div class="sesforum_quick_navigation_content sesbasic_bg">
    	<ul>
        <?php foreach($this->categories as $category) { ?>
          <li class="_cat">
            <a href="<?php echo $category->getHref(); ?>" class="sesbasic_lbg"><?php echo $category->title; ?></a>
            <ul>
              <?php foreach ($category->getChildren('sesforum_forum', array('order'=>'order')) as $sesforum):?>
                <li class="_forum">
                  <a href="<?php echo $sesforum->getHref(); ?>"><?php echo $sesforum->title; ?></a>
                </li>
              <?php endforeach; ?>
              <?php $subCategories = Engine_Api::_()->getItemTable('sesforum_category')->fetchAll(Engine_Api::_()->getItemTable('sesforum_category')->select()->where('subcat_id = ?', $category->category_id)->order('order ASC'));?>
              <?php if(count($subCategories) > 0) { ?>
                <?php foreach($subCategories as $subcategory) { ?>
                  <li class="_subcat">
                    <a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->title; ?></a>
                    <ul>
                      <?php foreach ($subcategory->getChildren('sesforum_forum', array('order'=>'order')) as $sesforum):?>
                        <li class="_forum"><a href="<?php echo $sesforum->getHref(); ?>"><?php echo $sesforum->title; ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </li>
                   <?php $subsubCategories = Engine_Api::_()->getItemTable('sesforum_category')->fetchAll(Engine_Api::_()->getItemTable('sesforum_category')->select()->where('subsubcat_id = ?', $subcategory->category_id)->order('order ASC'));?>
                  <?php if(count($subsubCategories) > 0) { ?>
                    <?php foreach($subsubCategories as $subsubcategory) { ?>
                      <li class="_thirdcat">
                        <a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->title; ?></a>
                        <ul>
                          <?php foreach ($subsubcategory->getChildren('sesforum_forum', array('order'=>'order')) as $sesforum):?>
                          	<li class="_forum"><a href="<?php echo $sesforum->getHref(); ?>"><?php echo $sesforum->title; ?></a></li>
                          <?php endforeach; ?>
                        </ul>
                      </li>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
            	</ul>
            <?php } ?>
          </li>
        <?php } ?>
      </ul>
  	</div>    
  </div>
  <?php if(!empty($this->viewer_id) && $this->urlType) { ?>
    <div class="sesforum_dashboard_button_box floatR">
      <a href="<?php echo $this->url(array('action' => 'dashboard','type'=>$this->urlType), 'sesforum_extend', true); ?>" class="sesbasic_link_btn" title="<?php echo $this->translate("Dashboard")?>"><i class="fa fa-tachometer"></i><span><?php echo $this->translate("Dashboard")?></span></a>
    </div>
  <?php } ?>
</div>
