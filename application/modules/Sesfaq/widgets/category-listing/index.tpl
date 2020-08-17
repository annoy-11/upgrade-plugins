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

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesfaq/externals/styles/styles.css'); ?>

<div class="sesfaq_category_listing_wrapper sesfaq_clearfix sesfaq_bxs">
  <div class="sesfaq_clearfix">
    <?php foreach($this->resultcategories as $resultcategorie): if($resultcategorie->total_faq_categories == 0) continue; ?>
      <div class="sesfaq_category_question_section">
        <div class="sesfaq_category_question_section_title">
          <p>
            <?php if(in_array('viewall', $this->showinformation)): ?>
              <?php $totalCountFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->countFaqs(array('fetchAll' => 1, 'category_id' => $resultcategorie->category_id)); ?> 
              <?php if(count($totalCountFaqs) > 0): ?>
                <span class="seeall_link"><a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($resultcategorie->category_id) ; ?>"><?php echo $this->translate("View all %s", count($totalCountFaqs));?> <i class=" fa fa-angle-right"></i></a>
              <?php endif; ?></span>
            <?php endif; ?>
            <?php if(in_array('caticon', $this->showinformation)): ?>
              <img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" />
            <?php endif; ?>
            <a href="<?php echo $resultcategorie->getHref(); ?>"><?php echo $this->translate($resultcategorie->category_name); ?></a>
          </p>
        </div>
        <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->category_id, 'order' => $this->faqcriteria)); ?>
        <?php if(count($categoriesFaqs) > 0): ?>
          <div class="sesfaq_category_question_section_list">
            <ul>
              <?php foreach($categoriesFaqs as $categoriesFaq): ?>
                <?php $faqpermission = Engine_Api::_()->sesfaq()->faqpermission($categoriesFaq->faq_id); ?>
                <?php if(empty($faqpermission)) continue; ?>
                <li>
                  <a href="<?php echo $categoriesFaq->getHref(); ?>" title="<?php echo $categoriesFaq->title; ?>">
                    <?php if($this->showfaqicon) { ?>
                      <i class=" fa fa-file-text-o"></i>
                    <?php } ?>
                    <span>
                      <?php echo $this->string()->truncate($this->string()->stripTags($categoriesFaq->title), $this->faqtitlelimit); ?>
                    </span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php else: ?>
          <div class="tip">
            <span>
              <?php echo $this->translate("There is no FAQ created in this category yet.") ?>
            </span>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>