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

  en4.core.runonce.add(function() {
    var pre_rate = <?php echo $this->faq->rating;?>;
    var rated = '<?php echo $this->rated;?>';
    var faq_id = <?php echo $this->faq->faq_id;?>;
    var total_votes = <?php echo $this->rating_count;?>;
    var viewer = <?php echo $this->viewer_id;?>;
    new_text = '';

    var rating_over = window.rating_over = function(rating) {
      if( rated == 1 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('you already rated');?>";
        //set_rating();
      } else if( viewer == 0 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('please login to rate');?>";
      } else {
        $('rating_text').innerHTML = "<?php echo $this->translate('click to rate');?>";
        for(var x=1; x<=5; x++) {
          if(x <= rating) {
            $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
          } else {
            $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
          }
        }
      }
    }
    
    var rating_out = window.rating_out = function() {
      if (new_text != ''){
        $('rating_text').innerHTML = new_text;
      }
      else{
        $('rating_text').innerHTML = " <?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";        
      }
      if (pre_rate != 0){
        set_rating();
      }
      else {
        for(var x=1; x<=5; x++) {
          $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
        }
      }
    }

    var set_rating = window.set_rating = function() {
      var rating = pre_rate;
      if (new_text != ''){
        $('rating_text').innerHTML = new_text;
      }
      else{
        $('rating_text').innerHTML = "<?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";
      }
      for(var x=1; x<=parseInt(rating); x++) {
        $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
      }

      for(var x=parseInt(rating)+1; x<=5; x++) {
        $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
      }

      var remainder = Math.round(rating)-rating;
      if (remainder <= 0.5 && remainder !=0){
        var last = parseInt(rating)+1;
        $('rate_'+last).set('class', 'rating_star_big_generic rating_star_big_half');
      }
    }

    var rate = window.rate = function(rating) {
      $('rating_text').innerHTML = "<?php echo $this->translate('Thanks for rating!');?>";
      for(var x=1; x<=5; x++) {
        $('rate_'+x).set('onclick', '');
      }
      (new Request.JSON({
        'format': 'json',
        'url' : '<?php echo $this->url(array('module' => 'sesfaq', 'controller' => 'index', 'action' => 'rate'), 'default', true) ?>',
        'data' : {
          'format' : 'json',
          'rating' : rating,
          'faq_id': faq_id
        },
        'onRequest' : function(){
          rated = 1;
          total_votes = total_votes+1;
          pre_rate = (pre_rate+rating)/total_votes;
          set_rating();
        },
        'onSuccess' : function(responseJSON, responseText)
        {
          if(responseJSON[0].total == 1) {
            $('rating_text').innerHTML = responseJSON[0].total+" rating";
          } else { 
            $('rating_text').innerHTML = responseJSON[0].total+" ratings";
          }
          new_text = responseJSON[0].total+" ratings";
        }
      })).send();

    }

//     var tagAction = window.tagAction = function(tag){
//       $('tag').value = tag;
//       $('filter_form').submit();
//     }
    
    set_rating();
  });
</script>

<div class="sesfaq_faq_view sesfaq_bxs sesfaq_clearfix">
	<div class="sesfaq_faq_view_top">
    <div class="sesfaq_faq_view_top_icon">
    	<i class="fa fa-file-text-o"></i>
    </div>
    <div class="sesfaq_faq_view_top_cont sesfaq_clearfix">
      <div class="sesfaq_faq_view_title">
        <h2><?php echo $this->translate($this->faq->title); ?></h2>
      </div>
      <?php if($this->showinformation): ?>
        <div class="sesfaq_faq_view_stats sesfaq_text_light">
          <?php if(in_array('viewcount', $this->showinformation)): ?>
            <p><i class="fa fa-eye"></i><span><?php echo $this->translate(array('%s view', '%s views', $this->faq->view_count), $this->locale()->toNumber($this->faq->view_count)); ?></span></p>
          <?php endif; ?>
          <?php if(in_array('commentcount', $this->showinformation)): ?>
            <p><i class="fa fa-comment-o"></i><span><?php echo $this->translate(array('%s comment', '%s comments', $this->faq->comment_count), $this->locale()->toNumber($this->faq->comment_count)); ?></span></p>
          <?php endif; ?>
          <?php if(in_array('likecount', $this->showinformation)): ?>
            <p><i class="fa fa-thumbs-o-up"></i><span><?php echo $this->translate(array('%s like', '%s likes', $this->faq->like_count), $this->locale()->toNumber($this->faq->like_count)); ?></span></p>
          <?php endif; ?>
          <?php if(in_array('ratingcount', $this->showinformation)): ?>
            <p><i class="fa fa-star-o"></i><span><?php echo $this->translate(array('%s rating', '%s ratings', $this->faq->rating), $this->locale()->toNumber($this->faq->rating)); ?></span></p>
          <?php endif; ?>
          
          <?php if(in_array('category', $this->showinformation) && $this->faq->category_id) :?>
            <p><i class="fa fa-folder-o"></i>
            	<span><?php $catName = $this->categoriesTable->getColumnName(array('column_name' => 'category_name', 'category_id' => $this->faq->category_id)); ?>
                <a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($this->faq->category_id) ; ?>"><?php echo $catName; ?></a>
                <?php if($this->faq->subcat_id): ?>
                <?php $subcatName = $this->categoriesTable->getColumnName(array('column_name' => 'category_name', 'category_id' => $this->faq->subcat_id)); ?>
                &nbsp;&raquo;
                <a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($this->faq->category_id) . '&subcat_id='.urlencode($this->faq->subcat_id) ?>"><?php echo $subcatName; ?></a>
                <?php endif; ?>
                <?php if($this->faq->subsubcat_id): ?>
                <?php $subsubcatName = $this->categoriesTable->getColumnName(array('column_name' => 'category_name', 'category_id' => $this->faq->subsubcat_id)); ?>
                &nbsp;&raquo;
                <a href="<?php echo $this->url(array('action' => 'browse'), 'sesfaq_general', true).'?category_id='.urlencode($this->faq->category_id) . '&subcat_id='.urlencode($this->faq->subcat_id) .'&subsubcat_id='.urlencode($this->faq->subsubcat_id) ?>"><?php echo $subsubcatName; ?></a>
                <?php endif; ?>
              </span>  
            </p>
          <?php endif; ?>
          <?php if (in_array('tags', $this->showinformation) && count($this->faqTags )):?>
          	<p><i class="fa fa-tag"></i>
              <span>
                <?php foreach ($this->faqTags as $tag): ?>
                  <a href='<?php echo $this->url(array('module' =>'sesfaq','controller' => 'index', 'action' => 'browse'),'sesfaq_general',true).'?tag_id='.$tag->tag_id.'&tag_name='.$tag->getTag()->text ;?>'>#<?php echo $tag->getTag()->text?></a>&nbsp;
                <?php endforeach; ?>
              </span>
            </p>    
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="sesfaq_faq_view_des sesfaq_clearfix">
    <?php echo $this->faq->description; ?>
  </div>
  <div class="sesfaq_faq_view_bottom">
    <?php if($this->canRate): ?>
      <div class="sesfaq_faq_view_rating" onMouseOut="rating_out();">
        <span id="rate_1" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(1);"<?php  endif; ?> onMouseOver="rating_over(1);"></span>
        <span id="rate_2" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(2);"<?php endif; ?> onMouseOver="rating_over(2);"></span>
        <span id="rate_3" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(3);"<?php endif; ?> onMouseOver="rating_over(3);"></span>
        <span id="rate_4" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(4);"<?php endif; ?> onMouseOver="rating_over(4);"></span>
        <span id="rate_5" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(5);"<?php endif; ?> onMouseOver="rating_over(5);"></span>
        <span id="rating_text" class="rating_text"><?php echo $this->translate('click to rate');?></span>
      </div>
    <?php endif; ?>
    <?php if(in_array('socialshare', $this->showinformation) || in_array('siteshare', $this->showinformation)): ?>
      <?php
        $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->faq->getHref());
        $facebookUrl = 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $this->faq->getTitle();
        $twitterUrl = 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $this->faq->getTitle().'%0a';
        $pinterestUrl = 'http://pinterest.com/pin/create/button/?url='.$urlencode.'&media='.urlencode((strpos($this->faq->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $this->faq->getPhotoUrl('thumb.main'))).'&description='.$this->faq->getTitle();
      ?>
      <div class="sesfaq_faq_view_social">
        <?php if(in_array('socialshare', $this->showinformation)): ?>
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesbasic') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sessocialshare')) { ?>
            <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->faq, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
          <?php } else { ?>
            <a href="<?php echo $facebookUrl; ?>" class="sesfaq_animation" onclick="return socialSharingPopUp(this.href,'Facebook');" title="<?php echo $this->translate('Facebook'); ?>"><i class='fa fa-facebook sesfaq_text_light'></i></a>
            <a href="<?php echo $twitterUrl; ?>" class="sesfaq_animation" onclick="return socialSharingPopUp(this.href,'Twitter');" title="<?php echo $this->translate('Twitter'); ?>"><i class='fa fa-twitter sesfaq_text_light'></i></a>
            <a href="<?php echo $pinterestUrl; ?>" class="sesfaq_animation" onclick="return socialSharingPopUp(this.href,'Pinterest');" title="<?php echo $this->translate('Pinterest'); ?>"><i class='fa fa-pinterest sesfaq_text_light'></i></a>
          <?php } ?>
      <?php endif; ?>
      <?php if($this->viewer()->getIdentity()) { ?>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfaq.allowshare', 1) && in_array('siteshare', $this->showinformation)): ?>
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { ?>
            <?php $module = 'sesadvancedactivity'; ?>
          <?php } else { ?>
            <?php $module = 'activity'; ?>
          <?php } ?>
          <a href="<?php echo $this->url(array('module' => $module, 'controller'=>'index', 'action'=>'share', 'route'=>'default', 'type'=>'sesfaq_faq', 'id' => $this->faq->getIdentity(), 'format' => 'smoothbox'), 'default', true); ?>" class="smoothbox sesfaq_animation" title="<?php echo $this->translate('Share'); ?>"><i class="fa fa-share sesfaq_text_light"></i></a>
        <?php endif; ?>
        <?php $LikeStatus = Engine_Api::_()->sesfaq()->getLikeStatus($this->faq->faq_id, $this->faq->getType()); ?>
        <a href="javascript:;" data-url="<?php echo $this->faq->faq_id ; ?>" class="btn_count sesfaq_like_sesfaq_faq_<?php echo $this->faq->faq_id ?> sesfaq_like_sesfaq_faq <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up sesfaq_text_light"></i><span><?php echo $this->faq->like_count; ?></span></a>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfaq.allowreport', 1) && $this->viewer()->getIdentity() != $this->faq->user_id && in_array('report', $this->showinformation)): ?>
          <a href="<?php echo $this->url(array("module"=> "core", "controller" => "report", "action" => "create", "route" => "default", "subject" => $this->faq->getGuid()), 'default', true); ?>" class="smoothbox sesfaq_animation" title="<?php echo $this->translate('Report'); ?>"><i class="fa fa-flag sesfaq_text_light"></i></a>
        <?php endif; ?>
      <?php } ?>
      </div>
      <?php endif; ?>
      
  </div>
  <?php if($this->canhelpful): ?>
    <?php if(in_array('showhelpful', $this->showinformation)): ?>
      <?php $checkHelpful = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->checkHelpful($this->faq->faq_id, $this->viewer_id);
      
      $getHelpfulvalue = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->getHelpfulvalue($this->faq->faq_id, $this->viewer_id);
      $helpfulCountforYes = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->helpfulCount($this->faq->faq_id, 1);
      $helpfulCountforNo = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->helpfulCount($this->faq->faq_id, 2);
      
      $totalHelpful = $helpfulCountforYes + $helpfulCountforNo;
      $percentageHelpful = ($helpfulCountforYes / ($totalHelpful))*100;
      $final_value = round($percentageHelpful);
      ?>
      <div class="sesfaq_view_helpful_section" id="helpful_content">
        <div id="helpful_faq">
          <p class="sesfaq_view_helpful_section_des"><?php echo $this->translate("Was this helpful?"); ?></p>
          <div class="sesfaq_view_helpful_section_btns">
            <?php if(empty($checkHelpful)) { ?>
              <p class="sesfaq_helpfull_yes"><a href="javascript:void(0);" onclick="markasHelpful('1', '<?php echo $this->faq->faq_id; ?>')" class="sesfaq_animation"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate("%s Yes", $helpfulCountforYes); ?></a></p>
              <p class="sesfaq_helpfull_no"><a href="javascript:void(0);" onclick="markasHelpful('2', '<?php echo $this->faq->faq_id; ?>')" class="sesfaq_animation"><i class="fa fa-thumbs-o-down"></i> <?php echo $this->translate("%s No", $helpfulCountforNo); ?></a></p>
            <?php } elseif($checkHelpful && $getHelpfulvalue == 1) { ?>
              <p class="disabled sesfaq_helpfull_yes"><a href="javascript:void(0);" class="sesfaq_animation"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate("%s Yes", $helpfulCountforYes); ?></a></p>
              <p class="sesfaq_helpfull_no"><a href="javascript:void(0);" onclick="markasHelpful('2', '<?php echo $this->faq->faq_id; ?>')" class="sesfaq_animation"><i class="fa fa-thumbs-o-down"></i> <?php echo $this->translate("%s No", $helpfulCountforNo); ?></a></p>
            <?php } elseif($checkHelpful && $getHelpfulvalue == 2) { ?>
              <p class="sesfaq_helpfull_yes"><a href="javascript:void(0);" onclick="markasHelpful('1', '<?php echo $this->faq->faq_id; ?>')" class="sesfaq_animation"><i class="fa fa-thumbs-o-up"></i> <?php echo $this->translate("%s Yes", $helpfulCountforYes); ?></a></p>
              <p class="disabled sesfaq_helpfull_no"><a href="javascript:void(0);" class="sesfaq_animation"><i class="fa fa-thumbs-o-down"></i> <?php echo $this->translate("%s No", $helpfulCountforNo); ?></a></p>
            <?php } ?>
          </div>
          <?php if($final_value > 0): ?>
            <p class="sesfaq_view_helpful_section_total"><?php echo '<b>'.$final_value.'%</b>'.$this->translate(' users marked this FAQ as helpful.');?></p>
          <?php else: ?>
            <p class="sesfaq_view_helpful_section_total"><?php echo '<b>0%</b>'.$this->translate(' users marked this FAQ as helpful.');?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
<script>

function markasHelpful(helpfulfaq, faq_id) {
  
  if($('helpful_faq'))
    $('helpful_faq').style.disply = 'none';
  (new Request.HTML({
    method: 'post',              
    'url': en4.core.baseUrl + 'sesfaq/index/helpful/',
    'data': {
      format: 'html',
      faq_id: faq_id,
      helpfulfaq: helpfulfaq,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      document.getElementById('helpful_content').innerHTML = "<div class='sesfaq_success_msg'><i class='fa fa-check'></i><span><?php echo $this->translate('Thank you for your feedback!.');?> </span></div>";
    }
  }).send());
  return false;
} 


</script>