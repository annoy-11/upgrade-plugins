<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<div class="sesqa_category_qa_listing sesbasic_clearfix sesbasic_bxs">
  <?php foreach($this->resultcategories as $resultcategorie): ?>
    <div class="sesqa_category_qa_listing_head">
      <img src="<?php echo $resultcategorie->getCategoryIconUrl(); ?>" />
      <a href="<?php echo $resultcategorie->getHref(); ?>" class="sesqa_linkinherit"><?php echo $this->translate($resultcategorie->category_name); ?></a>
      <?php if($this->showviewalllink): ?>
        <?php $totalCountQuestions = Engine_Api::_()->getDbTable('questions', 'sesqa')->getQuestions(array('fetchAll' => 1, 'category_id' => $resultcategorie->category_id,'locationEnable'=>$this->locationEnable)); ?> 
        <?php if(count($totalCountQuestions) > 0): ?>
          <span class="seeall_link"><a href="<?php echo $this->url(array('action' => 'browse'), 'sesqa_general', true).'?category_id='.urlencode($resultcategorie->category_id) ; ?>"><?php echo $this->translate("See All Questions");?> <i class=" fa fa-angle-right"></i></a>
        <?php endif; ?></span>
      <?php endif; ?>
    </div>
    <div class="sesqa_category_qa_listing_cont sesbasic_clearfix">
      <div class="sesqa_question_answer_list_content">
        <?php $categoriesQuestions = Engine_Api::_()->getDbTable('questions', 'sesqa')->getQuestions(array('limit' => $this->limitdataqa, 'fetchAll' => 1, 'category_id' => $resultcategorie->category_id, 'popularCol' => $this->qacriteria,'locationEnable'=>$this->locationEnable,'info'=>$this->info,'popularCol'=>$this->popularCol)); ?>
        <?php if(count($categoriesQuestions) > 0){
           echo $this->content()->renderWidget('sesqa.category-question',array('height'=>$this->height , 'width'=>$this->width , 'viewtype'=>$this->viewtype,  'title_truncate'=>$this->title_truncate, 'show_criteria'=>$this->showOptions,'result'=>$categoriesQuestions,'socialshare_enable_plusicon'=>$this->socialshare_enable_plusicon,'socialshare_icon_limit'=>$this->socialshare_icon_limit,'viewtype'=>$this->viewtype)); 
        }else{ ?> 
            <div class="tip"><span><?php echo $this->translate("No questions created in this category yet."); ?></span></div>
        <?php } ?>
      </div>
    </div>
  <?php endforeach; ?>  
</div>

