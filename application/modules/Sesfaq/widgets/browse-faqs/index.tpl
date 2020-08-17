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


<script type="text/javascript">
  function loadMore() {
  
    if ($('view_more'))
      $('view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('view_more'))
      document.getElementById('view_more').style.display = 'none';
    
    if(document.getElementById('loading_image'))
     document.getElementById('loading_image').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/sesfaq/name/browse-faqs',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('sesfaq_results').innerHTML = document.getElementById('sesfaq_results').innerHTML + responseHTML;
        
        if(document.getElementById('view_more'))
          document.getElementById('view_more').destroy();
        
        if(document.getElementById('loading_image'))
         document.getElementById('loading_image').destroy();
               if(document.getElementById('loadmore_list'))
         document.getElementById('loadmore_list').destroy();
      }
    }));
    return false;
  }
  
  function showFAQ(id) {
  
    if($('sesfaq_question_answer_cont_'+id).style.display == 'block' || $('sesfaq_question_answer_cont_'+id).style.display == '') {
      $('sesfaq_question_answer_cont_'+id).style.display = 'none';
      $('sesfaq_question_'+id).innerHTML = '<i class="fa fa-plus-square-o"></i>';
    } else {
      $('sesfaq_question_answer_cont_'+id).style.display = 'block';
      $('sesfaq_question_'+id).innerHTML = '<i class="fa fa-minus-square-o"></i>';
    }
  
  }
</script>


<?php if(count($this->paginator) > 0): ?>
<!--question answer list view block-->
<?php if($this->viewtype == 'listview'): ?>
  <?php if (empty($this->viewmore)): ?>
    <div class="sesfaq_question_answer_list_content sesfaq_clearfix sesfaq_bxs" id="sesfaq_results">
  <?php endif;?>  
      <?php foreach($this->paginator as $faq): //print_r($faq->toarray());die; ?>
        <div class="sesfaq_question_answer_section _isexpcol" >
          <?php //if(in_array('photo', $this->showinformation)): ?>
<!--            <div class="sesfaq_question_answer_img">
              <a href="<?php //echo $faq->getHref(); ?>"><img src="<?php //echo $faq->getPhotoUrl(); ?>" /></a>
            </div>-->
          <?php //endif; ?>
          <div class="sesfaq_question_answer_content_section">
            <div class="sesfaq_question_answer_title">
            	<?php if($this->showicons) { ?><a onclick="showFAQ('<?php echo $faq->getIdentity(); ?>')" class="sesfaq_question_answer_expcol_btn" id="sesfaq_question_<?php echo $faq->getIdentity(); ?>"><i  class="fa fa-minus-square-o"></i></a><?php } ?>
              <a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></a>
            </div>
            <div class="sesfaq_question_answer_cont" id="sesfaq_question_answer_cont_<?php echo $faq->getIdentity(); ?>">
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
        </div>
    <?php endforeach; ?>
  <?php if (empty($this->viewmore)): ?>
    </div>
  <?php endif;?>
<?php elseif($this->viewtype == 'onlyfaqview'): ?>
  <?php if (empty($this->viewmore)): ?>
  	<div class="sesfaq_category_question_section_list sesfaq_clearfix sesfaq_bxs">
    	<ul id="sesfaq_results">
    <?php endif;?>  
        <?php foreach($this->paginator as $faq): //print_r($faq->toarray());die; ?>
          <li class="sesfaq_question_answer_section" >
          	<a href="<?php echo $faq->getHref(); ?>" title="<?php echo $faq->title; ?>"><i class=" fa fa-file-text-o"></i><span><?php echo $this->string()->truncate($this->string()->stripTags($faq->title), $this->faqtitlelimit); ?></span></a>
          </li>
      <?php endforeach; ?>
    <?php if (empty($this->viewmore)): ?>
  		</ul>
    </div>
  <?php endif;?>
<?php elseif($this->viewtype == 'gridview'): ?>
  <!--question answer grid view block-->
  <?php if (empty($this->viewmore)): ?>
    <div class="sesfaq_question_answer_grid_content sesfaq_clearfix sesfaq_bxs" id="sesfaq_results">
  <?php endif;?>
    <?php foreach($this->paginator as $faq): //print_r($faq->toarray());die; ?>
    <div class="sesfaq_question_answer_section">
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
        <?php if(in_array('photo', $this->showinformation)): ?>
          <div class="sesfaq_question_answer_img">
            <a href="<?php echo $faq->getHref(); ?>"><img src="<?php echo $faq->getPhotoUrl(); ?>" /></a>
          </div>
        <?php endif; ?>
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
  <?php if (empty($this->viewmore)): ?>
    </div>
  <?php endif; ?>
<?php endif; ?>
<?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
  <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
    <div class="clr" id="loadmore_list"></div>
    <div class="sesfaq_load_more" id="view_more" onclick="loadMore();" style="display: block;">
      <a href="javascript:void(0);" id="feed_viewmore_link" class="sesfaq_load_more_btn"><?php echo $this->translate('View More'); ?></a>
    </div>
    <div class="sesfaq_load_more" id="loading_image" style="display: none;">
      <span class="sesfaq_loading_icon"><i class="fa fa-spinner fa-spin"></i></span>
    </div>
  <?php endif; ?>
 <?php endif; ?>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no FAQs.") ?>
    </span>
  </div>
<?php endif; ?>

<?php if($this->paginationType == 1): ?>
  <script type="text/javascript">    
     //Take refrences from: http://mootools-users.660466.n2.nabble.com/Fixing-an-element-on-page-scroll-td1100601.html
    //Take refrences from: http://davidwalsh.name/mootools-scrollspy-load
    en4.core.runonce.add(function() {
      var paginatorCount = '<?php echo $this->paginator->count(); ?>';
      var paginatorCurrentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';
      function ScrollLoader() { 
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if($('loadmore_list')) {
          if (scrollTop > 40)
            loadMore();
        }
      }
      window.addEvent('scroll', function() {
        ScrollLoader(); 
      });
    });    
  </script>
<?php endif; ?>