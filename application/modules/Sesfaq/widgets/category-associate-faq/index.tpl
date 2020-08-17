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

<?php if($this->viewtype == 'listview'): ?>
  <div class="sesfaq_category_faq_listing sesfaq_clearfix sesfaq_bxs">
    <?php foreach($this->resultcategories as $resultcategorie): ?>
      <?php if($resultcategorie->total_faq_categories == 0) continue; ?>
      <div class="sesfaq_category_faq_listing_head">

        <img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" />
        <a href="<?php echo $resultcategorie->getHref(); ?>" class="sesfaq_linkinherit"><?php echo $this->translate($resultcategorie->category_name); ?></a>
        
        <?php if($this->showviewalllink): ?>
          <?php $totalCountFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->countFaqs(array('fetchAll' => 1, 'category_id' => $resultcategorie->category_id)); ?> 
          <?php if(count($totalCountFaqs) > 0): ?>
            <span class="seeall_link"><a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($resultcategorie->category_id) ; ?>"><?php echo $this->translate("See All FAQs");?> <i class=" fa fa-angle-right"></i></a>
          <?php endif; ?></span>
        <?php endif; ?>
      </div>
      <div class="sesfaq_category_faq_listing_cont sesfaq_clearfix">
        <div class="sesfaq_question_answer_list_content">
          <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->category_id, 'order' => $this->faqcriteria)); ?>
          <?php if(count($categoriesFaqs) > 0): ?>
            <?php foreach($categoriesFaqs as $faq): //print_r($faq->toarray());die; ?>
              <div class="sesfaq_question_answer_section" >	
                <div class="sesfaq_question_answer_content_section">
                  <div class="sesfaq_question_answer_title">
                    <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></a>
                  </div>
                  <?php if(in_array('description', $this->showinformation)): ?>
                    <div class="sesfaq_question_answer_discription">
                      <p> <?php echo $this->string()->truncate($this->string()->stripTags($faq->description), $this->faqdescriptionlimit); ?></p>
                     </div>
                   <?php endif; ?>
                   <div class="sesfaq_question_answer_stats">
                    <ul>
                      <?php if(in_array('commentcount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $faq->comment_count), $this->locale()->toNumber($faq->comment_count)); ?></li>
                      <?php endif; ?>
                      <?php if(in_array('viewcount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $faq->view_count), $this->locale()->toNumber($faq->view_count)); ?></li>
                      <?php endif; ?>
                      <?php if(in_array('likecount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $faq->like_count), $this->locale()->toNumber($faq->like_count)); ?></li>
                      <?php endif; ?>
                      <?php if(in_array('ratingcount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $faq->rating), $this->locale()->toNumber($faq->rating)); ?></li>
                      <?php endif; ?>
                    </ul>
                    <?php if(in_array('readmorelink', $this->showinformation)): ?>
                      <p class="read_more"><a href="<?php echo $faq->getHref(); ?>"><?php echo $this->translate("Read More"); ?><i class="fa fa-angle-right"></i></a></p>
                    <?php endif; ?>
                   </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>  
  </div>
<?php elseif($this->viewtype == 'onlyfaqview'): ?>
  <div class="sesfaq_category_listing_wrapper sesfaq_clearfix sesfaq_bxs">
  	<div class="sesfaq_clearfix">
      <?php foreach($this->resultcategories as $resultcategorie): ?>
        <?php if($resultcategorie->total_faq_categories == 0) continue; ?>
        <div class="sesfaq_category_question_section">	
          <div class="sesfaq_category_question_section_title">
          	<p>
          	
              <?php if($this->showviewalllink): ?>
                <?php $totalCountFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->countFaqs(array('fetchAll' => 1, 'category_id' => $resultcategorie->category_id)); ?> 
                <?php if(count($totalCountFaqs) > 0): ?>
                  <span class="seeall_link"><a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($resultcategorie->category_id) ; ?>"><?php echo $this->translate("See All FAQs");?> <i class=" fa fa-angle-right"></i></a>
                <?php endif; ?></span>
              <?php endif; ?>
              
              <img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" />
              <a href="<?php echo $resultcategorie->getHref(); ?>" class="sesfaq_linkinherit"><?php echo $this->translate($resultcategorie->category_name); ?></a>
            </p>
          </div>
          <div class="sesfaq_category_question_section_list">
          	<ul>
              <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->category_id, 'order' => $this->faqcriteria)); ?>
              <?php if(count($categoriesFaqs) > 0): ?>
                <?php foreach($categoriesFaqs as $faq): //print_r($faq->toarray());die; ?>
                  <li>	
                  	<a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><i class=" fa fa-file-text-o"></i><span><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></span></a>
                  </li>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>
      	</div>    
      <?php endforeach; ?>
    </div>  
  </div>
<?php elseif($this->viewtype == 'gridview'): ?>
  <div class="sesfaq_category_faq_listing sesfaq_clearfix sesfaq_bxs">
    <?php foreach($this->resultcategories as $resultcategorie): ?>
      <?php if($resultcategorie->total_faq_categories == 0) continue; ?>
      <div class="sesfaq_category_faq_listing_head">
        <img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" />
        <a href="<?php echo $resultcategorie->getHref(); ?>" class="sesfaq_linkinherit"><?php echo $this->translate($resultcategorie->category_name); ?></a>
        <?php if($this->showviewalllink): ?>
          <?php $totalCountFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->countFaqs(array('fetchAll' => 1, 'category_id' => $resultcategorie->category_id)); ?> 
          <?php if(count($totalCountFaqs) > 0): ?>
            <span class="seeall_link"><a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($resultcategorie->category_id) ; ?>"><?php echo $this->translate("See All FAQs");?> <i class=" fa fa-angle-right"></i></a>
          <?php endif; ?></span>
        <?php endif; ?>
      </div>
      <div class="sesfaq_category_faq_listing_cont sesfaq_clearfix">
        <div class="sesfaq_question_answer_grid_content">
          <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->category_id, 'order' => $this->faqcriteria)); ?>
          <?php if(count($categoriesFaqs) > 0): ?>
            <?php foreach($categoriesFaqs as $faq): //print_r($faq->toarray());die; ?>
              <div class="sesfaq_question_answer_section">
                <?php if(in_array('photo', $this->showinformation)): ?>
                  <div class="sesfaq_question_answer_img">
                    <a href="<?php echo $faq->getHref(); ?>"><img src="<?php echo $faq->getPhotoUrl(); ?>" /></a>
                  </div>
                <?php endif; ?>
                <div class="sesfaq_question_answer_inner" style="height:<?php echo $this->gridblockheight ?>px;">
                  <div class="sesfaq_question_answer_title">
                    <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></a>
                  </div>
                  <div class="sesfaq_question_answer_stats">
                    <ul>
                      <?php if(in_array('commentcount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $faq->comment_count), $this->locale()->toNumber($faq->comment_count)); ?></li>
                      <?php endif; ?>
                      <?php if(in_array('viewcount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $faq->view_count), $this->locale()->toNumber($faq->view_count)); ?></li>
                      <?php endif; ?>
                      <?php if(in_array('likecount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $faq->like_count), $this->locale()->toNumber($faq->like_count)); ?></li>
                      <?php endif; ?>
                      <?php if(in_array('ratingcount', $this->showinformation)): ?>
                        <li class="sesfaq_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $faq->rating), $this->locale()->toNumber($faq->rating)); ?></li>
                      <?php endif; ?>
                    </ul>
                  </div>
                  <?php if(in_array('readmorelink', $this->showinformation) || in_array('description', $this->showinformation)): ?>
                    <div class="sesfaq_question_answer_discription">
                      <?php if(in_array('description', $this->showinformation)): ?>
                      <p> <?php echo $this->string()->truncate($this->string()->stripTags($faq->description), $this->faqdescriptionlimit); ?></p>
                      <?php endif; ?>
                      <?php if(in_array('readmorelink', $this->showinformation)): ?>
                        <p class="read_more"><a href="<?php echo $faq->getHref(); ?>"><?php echo $this->translate("Read More"); ?></a></p>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>  
  </div>
<?php endif; ?>
