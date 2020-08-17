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

<div class="sesfaq_category_faq_listing_head">
	<img src="<?php echo $this->subject->getCategoryIconUrl(); ?>" />
  <span><?php echo $this->subject->category_name; ?></span>
</div>
<?php if(count($this->resultcategories) > 0 && $this->viewType == 'subcategoryview' && empty($this->thirdlevelcategory)): ?>
  <?php if($this->viewtype == 'onlyfaqview') { ?>
    <div class="sesfaq_category_listing_wrapper sesfaq_clearfix sesfaq_bxs sesfaq_catview_list">
      <div class="sesfaq_clearfix">
        <?php foreach($this->resultcategories as $resultcategorie): //if($resultcategorie->total_faqs_categories == 0) continue; ?>
          <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->subcat_id, 'subcat_id' => $resultcategorie->category_id,'order' => $this->faqcriteria)); ?>
          <div class="sesfaq_category_question_section">
            <div class="sesfaq_category_question_section_title">
              <p>
                <?php if(in_array('viewall', $this->showinformation)): ?>
                  <span class="seeall_link"><a href="<?php echo $resultcategorie->getHref(); ?>"><?php echo $this->translate("View All"); ?><i class=" fa fa-angle-right"></i></a></span>
                <?php endif; ?>
                <?php if(in_array('caticon', $this->showinformation)): ?><img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" /><?php endif; ?>
                <a href="<?php echo $resultcategorie->getHref(); ?>"><?php echo $this->translate($resultcategorie->category_name); ?></a>
              </p>
            </div>
            <?php if(count($categoriesFaqs) > 0): ?>
              <div class="sesfaq_category_question_section_list">
                <ul>
                  <?php foreach($categoriesFaqs as $categoriesFaq): ?>
                  <li><a href="<?php echo $categoriesFaq->getHref(); ?>"><i class=" fa fa-file-text-o"></i> <span><?php echo $this->string()->truncate($this->string()->stripTags($categoriesFaq->title), $this->faqtitlelimit); ?></span></a></li>
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
  <?php } else if($this->viewtype == 'listview') { ?>
    <div class="sesfaq_clearfix sesfaq_bxs">
      <div class="sesfaq_clearfix">
        <?php foreach($this->resultcategories as $resultcategorie): //if($resultcategorie->total_faqs_categories == 0) continue; ?>
          <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->subcat_id, 'subcat_id' => $resultcategorie->category_id,'order' => $this->faqcriteria)); ?>
          <div class="sesfaq_clearfix">
            <div class="sesfaq_category_question_section_title">
              <p>
                <?php if(in_array('caticon', $this->showinformation)): ?><img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" /><?php endif; ?>
                <a href="<?php echo $resultcategorie->getHref(); ?>"><?php echo $this->translate($resultcategorie->category_name); ?></a>
              </p>
            </div>
            <?php if(count($categoriesFaqs) > 0): ?>
              <ul class="sesfaq_question_answer_list_content">
                <?php foreach($categoriesFaqs as $faq): ?>
                  <div class="sesfaq_question_answer_section" >	
                    <div class="sesfaq_question_answer_content_section">
                      <div class="sesfaq_question_answer_title">
                        <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></a>
                      </div>
                      <?php if(in_array('description', $this->showinformation1)): ?>
                        <div class="sesfaq_question_answer_discription">
                          <p> <?php echo $this->string()->truncate($this->string()->stripTags($faq->description), $this->faqdescriptionlimit); ?></p>
                        </div>
                      <?php endif; ?>
                      <div class="sesfaq_question_answer_stats">
                        <ul>
                          <?php if(in_array('commentcount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $faq->comment_count), $this->locale()->toNumber($faq->comment_count)); ?></li>
                          <?php endif; ?>
                          <?php if(in_array('viewcount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $faq->view_count), $this->locale()->toNumber($faq->view_count)); ?></li>
                          <?php endif; ?>
                          <?php if(in_array('likecount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $faq->like_count), $this->locale()->toNumber($faq->like_count)); ?></li>
                          <?php endif; ?>
                          <?php if(in_array('ratingcount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $faq->rating), $this->locale()->toNumber($faq->rating)); ?></li>
                          <?php endif; ?>
                        </ul>
                        <?php if(in_array('readmorelink', $this->showinformation1)): ?>
                          <p class="read_more"><a href="<?php echo $faq->getHref(); ?>"><?php echo $this->translate("Read Artical"); ?><i class="fa fa-angle-right"></i></a></p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </ul>
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
  <?php } else if($this->viewtype == 'gridview') { ?>
    <div class="sesfaq_clearfix sesfaq_bxs">
      <div class="sesfaq_clearfix">
        <?php foreach($this->resultcategories as $resultcategorie): //if($resultcategorie->total_faqs_categories == 0) continue; ?>
          <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->subcat_id, 'subcat_id' => $resultcategorie->category_id,'order' => $this->faqcriteria)); ?>
          <div class="sesfaq_clearfix">
            <div class="sesfaq_category_question_section_title">
              <p>
                <?php if(in_array('caticon', $this->showinformation)): ?><img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" /><?php endif; ?>
                <a href="<?php echo $resultcategorie->getHref(); ?>"><?php echo $this->translate($resultcategorie->category_name); ?></a>
              </p>
            </div>
            <?php if(count($categoriesFaqs) > 0): ?>
              <div class="sesfaq_question_answer_grid_content sesfaq_clearfix">
                <ul class="sesfaq_clearfix">
                  <?php foreach($categoriesFaqs as $faq): ?>
                    <div class="sesfaq_question_answer_section">
                      <div class="sesfaq_question_answer_inner" style="height:<?php echo $this->gridblockheight ?>px;">
                        <div class="sesfaq_question_answer_title">
                          <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></a>
                        </div>
                        <div class="sesfaq_question_answer_stats">
                          <ul>
                            <?php if(in_array('commentcount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $faq->comment_count), $this->locale()->toNumber($faq->comment_count)); ?></li>
                            <?php endif; ?>
                            <?php if(in_array('viewcount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $faq->view_count), $this->locale()->toNumber($faq->view_count)); ?></li>
                            <?php endif; ?>
                            <?php if(in_array('likecount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $faq->like_count), $this->locale()->toNumber($faq->like_count)); ?></li>
                            <?php endif; ?>
                            <?php if(in_array('ratingcount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $faq->rating), $this->locale()->toNumber($faq->rating)); ?></li>
                            <?php endif; ?>
                          </ul>
                        </div>
                        <?php if(in_array('readmorelink', $this->showinformation1) || in_array('description', $this->showinformation1)): ?>
                          <div class="sesfaq_question_answer_discription">
                            <?php if(in_array('description', $this->showinformation1)): ?>
                            <p> <?php echo $this->string()->truncate($this->string()->stripTags($faq->description), $this->faqdescriptionlimit); ?></p>
                            <?php endif; ?>
                            <?php if(in_array('readmorelink', $this->showinformation1)): ?>
                              <p class="read_more"><a href="<?php echo $faq->getHref(); ?>"><?php echo $this->translate("Read More"); ?></a></p>
                            <?php endif; ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
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
  <?php } ?>
<?php else: ?>
  <?php //if(count($this->resultcategories) > 0): ?>
    <?php //foreach($this->resultcategories as $resultcategorie): ?>
      <?php //if($resultcategorie->total_faq_categories == 0) continue; ?>
      <?php if($this->thirdlevelcategory) { ?>
        <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'subcat_id' => $this->subject->category_id, 'order' => $this->faqcriteria)); ?>
      <?php } else { ?>
        <?php $categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $this->subject->category_id, 'order' => $this->faqcriteria)); ?>
      <?php } ?>
      <?php if(count($categoriesFaqs) > 0): ?>
        <div class="sesfaq_category_faq_listing_cont sesfaq_clearfix sesfaq_bxs">
          <?php if($this->viewtype == 'listview'): ?>
            <div class="sesfaq_question_answer_list_content sesfaq_clearfix sesfaq_bxs">
                <?php //if(count($categoriesFaqs) > 0): ?>
                  <?php foreach($categoriesFaqs as $faq): //print_r($faq->toarray());die; ?>
                    <div class="sesfaq_question_answer_section" >	
                      <div class="sesfaq_question_answer_content_section">
                        <div class="sesfaq_question_answer_title">
                          <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></a>
                        </div>
                        <?php if(in_array('description', $this->showinformation1)): ?>
                          <div class="sesfaq_question_answer_discription">
                            <p> <?php echo $this->string()->truncate($this->string()->stripTags($faq->description), $this->faqdescriptionlimit); ?></p>
                          </div>
                        <?php endif; ?>
                        <div class="sesfaq_question_answer_stats">
                          <ul>
                            <?php if(in_array('commentcount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $faq->comment_count), $this->locale()->toNumber($faq->comment_count)); ?></li>
                            <?php endif; ?>
                            <?php if(in_array('viewcount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $faq->view_count), $this->locale()->toNumber($faq->view_count)); ?></li>
                            <?php endif; ?>
                            <?php if(in_array('likecount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $faq->like_count), $this->locale()->toNumber($faq->like_count)); ?></li>
                            <?php endif; ?>
                            <?php if(in_array('ratingcount', $this->showinformation1)): ?>
                              <li class="sesfaq_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $faq->rating), $this->locale()->toNumber($faq->rating)); ?></li>
                            <?php endif; ?>
                          </ul>
                          <?php if(in_array('readmorelink', $this->showinformation1)): ?>
                            <p class="read_more"><a href="<?php echo $faq->getHref(); ?>"><?php echo $this->translate("Read Artical"); ?><i class="fa fa-angle-right"></i></a></p>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php //endif; ?>
            </div>
          <?php elseif($this->viewtype == 'onlyfaqview'): ?>
            <div class="sesfaq_question_answer_list_content sesfaq_clearfix sesfaq_bxs">
              <?php //if(count($categoriesFaqs) > 0): ?>
                <div class="sesfaq_category_question_section_list">
                  <ul>
                    <?php foreach($categoriesFaqs as $faq): //print_r($faq->toarray());die; ?>
                      <li>
                      	<a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><i class=" fa fa-file-text-o"></i> <span><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></span></a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php //endif; ?>
            </div>
          <?php elseif($this->viewtype == 'gridview'): ?>
            <!--question answer grid view block-->
            <div class="sesfaq_question_answer_grid_content">
              <?php //$categoriesFaqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $this->limitdatafaq, 'fetchAll' => 1, 'category_id' => $resultcategorie->subcat_id, 'subcat_id' => $resultcategorie->category_id, 'order' => $this->faqcriteria)); ?>
              <?php //if(count($categoriesFaqs) > 0): ?>
                <?php foreach($categoriesFaqs as $faq): //print_r($faq->toarray());die; ?>
                  <div class="sesfaq_question_answer_section">
                    <div class="sesfaq_question_answer_inner" style="height:<?php echo $this->gridblockheight ?>px;">
                      <div class="sesfaq_question_answer_title">
                        <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></a>
                      </div>
                      <div class="sesfaq_question_answer_stats">
                        <ul>
                          <?php if(in_array('commentcount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $faq->comment_count), $this->locale()->toNumber($faq->comment_count)); ?></li>
                          <?php endif; ?>
                          <?php if(in_array('viewcount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $faq->view_count), $this->locale()->toNumber($faq->view_count)); ?></li>
                          <?php endif; ?>
                          <?php if(in_array('likecount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $faq->like_count), $this->locale()->toNumber($faq->like_count)); ?></li>
                          <?php endif; ?>
                          <?php if(in_array('ratingcount', $this->showinformation1)): ?>
                            <li class="sesfaq_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $faq->rating), $this->locale()->toNumber($faq->rating)); ?></li>
                          <?php endif; ?>
                        </ul>
                      </div>
                      <?php if(in_array('readmorelink', $this->showinformation1) || in_array('description', $this->showinformation1)): ?>
                        <div class="sesfaq_question_answer_discription">
                          <?php if(in_array('description', $this->showinformation1)): ?>
                          <p> <?php echo $this->string()->truncate($this->string()->stripTags($faq->description), $this->faqdescriptionlimit); ?></p>
                          <?php endif; ?>
                          <?php if(in_array('readmorelink', $this->showinformation1)): ?>
                            <p class="read_more"><a href="<?php echo $faq->getHref(); ?>"><?php echo $this->translate("Read More"); ?></a></p>
                          <?php endif; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php //endif; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div class="tip">
          <span>
            <?php echo $this->translate("There is no FAQ created in this category yet.") ?>
          </span>
        </div>
      <?php endif; ?>
    <?php //endforeach; ?>
  <?php //else: ?>
<!--      <div class="tip">
      <span>
        <?php //echo $this->translate("There are no more category yet.") ?>
      </span>
    </div>-->
  <?php //endif; ?>
<?php endif; ?>