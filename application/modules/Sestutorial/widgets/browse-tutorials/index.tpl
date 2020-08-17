<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestutorial
 * @package    Sestutorial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestutorial/externals/styles/styles.css'); ?>


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
      'url': en4.core.baseUrl + 'widget/index/mod/sestutorial/name/browse-tutorials',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('sestutorial_results').innerHTML = document.getElementById('sestutorial_results').innerHTML + responseHTML;
        
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
  
  function showTutorial(id) {
  
    if($('sestutorial_question_answer_cont_'+id).style.display == 'block' || $('sestutorial_question_answer_cont_'+id).style.display == '') {
      $('sestutorial_question_answer_cont_'+id).style.display = 'none';
      $('sestutorial_question_'+id).innerHTML = '<i class="fa fa-plus-square-o"></i>';
    } else {
      $('sestutorial_question_answer_cont_'+id).style.display = 'block';
      $('sestutorial_question_'+id).innerHTML = '<i class="fa fa-minus-square-o"></i>';
    }
  
  }
</script>


<?php if(count($this->paginator) > 0): ?>
<!--question answer list view block-->
<?php if($this->viewtype == 'listview'): ?>
  <?php if (empty($this->viewmore)): ?>
    <div class="sestutorial_question_answer_list_content sestutorial_clearfix sestutorial_bxs" id="sestutorial_results">
  <?php endif;?>  
      <?php foreach($this->paginator as $tutorial): //print_r($tutorial->toarray());die; ?>
        <div class="sestutorial_question_answer_section _isexpcol" >
          <?php //if(in_array('photo', $this->showinformation)): ?>
<!--            <div class="sestutorial_question_answer_img">
              <a href="<?php //echo $tutorial->getHref(); ?>"><img src="<?php //echo $tutorial->getPhotoUrl(); ?>" /></a>
            </div>-->
          <?php //endif; ?>
          <div class="sestutorial_question_answer_content_section">
            <div class="sestutorial_question_answer_title">
            	<?php if($this->showicons) { ?><a onclick="showTutorial('<?php echo $tutorial->getIdentity(); ?>')" class="sestutorial_question_answer_expcol_btn" id="sestutorial_question_<?php echo $tutorial->getIdentity(); ?>"><i  class="fa fa-minus-square-o"></i></a><?php } ?>
              <a href="<?php echo $tutorial->getHref(); ?>" title="<?php echo $tutorial->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->title), $this->tutorialtitlelimit); ?></a>
            </div>
            <div class="sestutorial_question_answer_cont" id="sestutorial_question_answer_cont_<?php echo $tutorial->getIdentity(); ?>">
              <?php if(in_array('description', $this->showinformation)): ?>
                <div class="sestutorial_question_answer_discription">
                  <p> <?php echo $this->string()->truncate($this->string()->stripTags($tutorial->description), $this->tutorialdescriptionlimit); ?></p>
                </div>
              <?php endif; ?>
              <div class="sestutorial_question_answer_stats">
                <ul>
                  <?php if(in_array('commentcount', $this->showinformation)): ?>
                    <li class="sestutorial_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $tutorial->comment_count), $this->locale()->toNumber($tutorial->comment_count)); ?></li>
                  <?php endif; ?>
                  <?php if(in_array('viewcount', $this->showinformation)): ?>
                    <li class="sestutorial_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $tutorial->view_count), $this->locale()->toNumber($tutorial->view_count)); ?></li>
                  <?php endif; ?>
                  <?php if(in_array('likecount', $this->showinformation)): ?>
                    <li class="sestutorial_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $tutorial->like_count), $this->locale()->toNumber($tutorial->like_count)); ?></li>
                  <?php endif; ?>
                  <?php if(in_array('ratingcount', $this->showinformation)): ?>
                    <li class="sestutorial_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $tutorial->rating), $this->locale()->toNumber($tutorial->rating)); ?></li>
                  <?php endif; ?>
                </ul>
                <?php if(in_array('readmorelink', $this->showinformation)): ?>
                  <p class="read_more"><a href="<?php echo $tutorial->getHref(); ?>"><?php echo $this->translate("Read More"); ?><i class="fa fa-angle-right"></i></a></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
    <?php endforeach; ?>
  <?php if (empty($this->viewmore)): ?>
    </div>
  <?php endif;?>
<?php elseif($this->viewtype == 'onlytutorialview'): ?>
  <?php if (empty($this->viewmore)): ?>
  	<div class="sestutorial_category_question_section_list sestutorial_clearfix sestutorial_bxs">
    	<ul id="sestutorial_results">
    <?php endif;?>  
        <?php foreach($this->paginator as $tutorial): //print_r($tutorial->toarray());die; ?>
          <li class="sestutorial_question_answer_section" >
          	<a href="<?php echo $tutorial->getHref(); ?>" title="<?php echo $tutorial->title; ?>"><i class=" fa fa-file-text-o"></i><span><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->title), $this->tutorialtitlelimit); ?></span></a>
          </li>
      <?php endforeach; ?>
    <?php if (empty($this->viewmore)): ?>
  		</ul>
    </div>
  <?php endif;?>
<?php elseif($this->viewtype == 'gridview'): ?>
  <!--question answer grid view block-->
  <?php if (empty($this->viewmore)): ?>
    <div class="sestutorial_question_answer_grid_content sestutorial_clearfix sestutorial_bxs" id="sestutorial_results">
  <?php endif;?>
    <?php foreach($this->paginator as $tutorial): //print_r($tutorial->toarray());die; ?>
    <div class="sestutorial_question_answer_section">
      <div class="sestutorial_question_answer_inner" style="height:<?php echo $this->gridblockheight ?>px;">
        <div class="sestutorial_question_answer_title">
          <a href="<?php echo $tutorial->getHref(); ?>" title="<?php echo $tutorial->title; ?>"><?php echo $this->string()->truncate($this->string()->stripTags($tutorial->title), $this->tutorialtitlelimit); ?></a>
        </div>
        <div class="sestutorial_question_answer_stats">
          <ul>
            <?php if(in_array('commentcount', $this->showinformation)): ?>
              <li class="sestutorial_text_light"><i class="fa fa-comment-o"></i> <?php echo $this->translate(array('%s comment', '%s comments', $tutorial->comment_count), $this->locale()->toNumber($tutorial->comment_count)); ?></li>
            <?php endif; ?>
            <?php if(in_array('viewcount', $this->showinformation)): ?>
              <li class="sestutorial_text_light"><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $tutorial->view_count), $this->locale()->toNumber($tutorial->view_count)); ?></li>
            <?php endif; ?>
            <?php if(in_array('likecount', $this->showinformation)): ?>
              <li class="sestutorial_text_light"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate(array('%s like', '%s likes', $tutorial->like_count), $this->locale()->toNumber($tutorial->like_count)); ?></li>
            <?php endif; ?>
            <?php if(in_array('ratingcount', $this->showinformation)): ?>
              <li class="sestutorial_text_light"><i class="fa fa-star-o"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $tutorial->rating), $this->locale()->toNumber($tutorial->rating)); ?></li>
            <?php endif; ?>
          </ul>
        </div>
        <?php if(in_array('photo', $this->showinformation)): ?>
          <div class="sestutorial_question_answer_img">
            <a href="<?php echo $tutorial->getHref(); ?>"><img src="<?php echo $tutorial->getPhotoUrl(); ?>" /></a>
          </div>
        <?php endif; ?>
        <?php if(in_array('readmorelink', $this->showinformation) || in_array('description', $this->showinformation)): ?>
          <div class="sestutorial_question_answer_discription">
            <?php if(in_array('description', $this->showinformation)): ?>
            <p> <?php echo $this->string()->truncate($this->string()->stripTags($tutorial->description), $this->tutorialdescriptionlimit); ?></p>
            <?php endif; ?>
            <?php if(in_array('readmorelink', $this->showinformation)): ?>
              <p class="read_more"><a href="<?php echo $tutorial->getHref(); ?>"><?php echo $this->translate("Read More"); ?></a></p>
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
    <div class="sestutorial_load_more" id="view_more" onclick="loadMore();" style="display: block;">
      <a href="javascript:void(0);" id="feed_viewmore_link" class="sestutorial_load_more_btn"><?php echo $this->translate('View More'); ?></a>
    </div>
    <div class="sestutorial_load_more" id="loading_image" style="display: none;">
      <span class="sestutorial_loading_icon"><i class="fa fa-spinner fa-spin"></i></span>
    </div>
  <?php endif; ?>
 <?php endif; ?>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no Tutorials.") ?>
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