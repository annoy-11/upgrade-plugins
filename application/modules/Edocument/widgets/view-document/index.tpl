<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.rate', 1)) { ?>
  <script type="text/javascript">
    en4.core.runonce.add(function() {
      var pre_rate = <?php echo $this->subject->rating;?>;
      var rated = '<?php echo $this->rated;?>';
      var edocument_id = <?php echo $this->subject->edocument_id;?>;
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
          'url' : '<?php echo $this->url(array('module' => 'edocument', 'controller' => 'index', 'action' => 'rate'), 'default', true) ?>',
          'data' : {
            'format' : 'json',
            'rating' : rating,
            'edocument_id': edocument_id
          },
          'onRequest' : function(){
            rated = 1;
            total_votes = total_votes+1;
            pre_rate = (pre_rate+rating)/total_votes;
            set_rating();
          },
          'onSuccess' : function(responseJSON, responseText)
          {
            $('rating_text').innerHTML = responseJSON[0].total+" ratings";
            new_text = responseJSON[0].total+" ratings";
          }
        })).send();

      }
      set_rating();
    });
  </script>
<?php } ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Edocument/externals/styles/styles.css'); ?>

<div class="edocument_layout_contant sesbasic_clearfix sesbasic_bxs">
  <?php if(isset($this->titleActive)):?>
    <h2><?php echo $this->subject->getTitle() ?></h2>
  <?php endif;?>
  <div class="edocument_entrylist_entry_date">
    <p><?php echo $this->translate('<i>Posted by -</i>');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;-&nbsp;</p>
    <p><?php echo $this->translate('<i>on - </i>') ?><?php echo $this->timestamp($this->subject->creation_date) ?><?php if( $this->category ): ?>&nbsp;-&nbsp;</p>
      <p><?php echo $this->translate('<i>Filed in - </i>') ?>
      <a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a><?php endif; ?>&nbsp;-&nbsp;</p>
    <p><?php if (count($this->subjectTags )):?>
      <?php foreach ($this->subjectTags as $tag): ?>
        <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if(isset($this->staticsActive)):?>
      &nbsp;-&nbsp;</p>
      <p>
        <?php if(isset($this->viewActive)):?>
          <span><?php echo $this->translate(array('%s View', '%s Views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)) ?>&nbsp;-&nbsp;</span>
        <?php endif;?>
        <?php if(isset($this->commentActive)):?>
          <span><?php echo $this->translate(array('%s Comment', '%s Comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)) ?>&nbsp;-&nbsp;</span>
        <?php endif;?>
        <?php if(isset($this->likeActive)):?>
          <span><?php echo $this->translate(array('%s Like', '%s Likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)) ?></span>
        <?php endif;?>
      </p>
    <?php endif;?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.rate', 1)) { ?>
      <div id="edocument_rating" class="rating" onmouseout="rating_out();">
        <span id="rate_1" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(1);"<?php endif; ?> onmouseover="rating_over(1);"></span>
        <span id="rate_2" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(2);"<?php endif; ?> onmouseover="rating_over(2);"></span>
        <span id="rate_3" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(3);"<?php endif; ?> onmouseover="rating_over(3);"></span>
        <span id="rate_4" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(4);"<?php endif; ?> onmouseover="rating_over(4);"></span>
        <span id="rate_5" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(5);"<?php endif; ?> onmouseover="rating_over(5);"></span>
        <span id="rating_text" class="rating_text"><?php echo $this->translate('click to rate');?></span>
      </div>
    <?php } ?>
  </div>
  <div class="edocument_entrylist_entry_body">
    <?php if(isset($this->descriptionActive)):?>
      <div class="rich_content_body"><?php echo $this->subject->body;?></div>
    <?php endif;?>
    <?php if(isset($this->documentActive)):?>
      <div class="edocument_image clear">
        <iframe src="https://docs.google.com/file/d/<?php echo $this->subject->file_id_google ?>/preview" width="100%" height="600"></iframe>
      </div>
    <?php endif;?>

  </div>
  <div class="edocument_footer_two_document clear">
    <?php if(isset($this->ratingActive)):?>
      <div class="sesbasic_rating_star floatL">
        <?php $ratingCount = $this->subject->rating; $x=0; ?>
        <?php if( $ratingCount > 0 ): ?>
          <?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
            <span id="" class="edocument_rating_star"></span>
          <?php endfor; ?>
          <?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
          <span class="edocument_rating_star edocument_rating_star_half"></span>
          <?php }else{ $x = $x - 1;} ?>
          <?php if($x < 5){ 
          for($j = $x ; $j < 5;$j++){ ?>
          <span class="edocument_rating_star edocument_rating_star_disable"></span>
          <?php }   	
          } ?>
        <?php endif; ?>
      </div>
    <?php endif;?>
    <div class="edocument_deshboard_document floatR">
      <ul>
        <?php if(isset($this->ownerOptionsActive) && ($this->canEdit || $this->canDelete)):?>
          <?php if($this->canEdit) { ?>
            <li><a href="<?php echo $this->url(array('action' => 'edit', 'edocument_id' => $this->subject->custom_url), 'edocument_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
          <?php } ?>
          <?php if($this->canDelete) { ?>
            <li><a href="<?php echo $this->url(array('action' => 'delete', 'edocument_id' => $this->subject->getIdentity()), 'edocument_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Document');?></a></li>
          <?php } ?>
        <?php endif;?>
        <?php if($this->viewer_id && isset($this->smallShareButtonActive) && $this->enableSharng):?>
          <li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->subject->getType(), "id" => $this->subject->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i> <?php echo $this->translate('Share');?></a></li>
        <?php endif;?>
        <?php if($this->viewer_id && $this->viewer_id != $this->subject->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.report', 1)):?>
          <li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->subject->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
        <?php endif;?>
        <?php if(isset($this->postCommentActive) && $this->canComment):?>
          <li><a href="javascript:void(0);" class="edocument_comment"><i class="edocument_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
        <?php endif;?>
      </ul>
    </div>
    <div class="edocument_shear_document sesbasic_bxs">
      <?php if(isset($this->socialShareActive) && $this->enableSharng):?>
        <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->subject, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
      <?php endif;?>
      <?php if($this->viewer_id && $this->enableSharng && isset($this->shareButtonActive)):?>
        <a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->subject->getType(), "id" => $this->subject->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i><span><?php echo $this->translate('Share');?></span></a>
      <?php endif;?>
      <?php if($this->viewer_id):?>
        <?php if(isset($this->likeButtonActive) && $this->canComment):?>
          <a href="javascript:;" data-url="<?php echo $this->subject->edocument_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  edocument_like_edocument_<?php echo $this->subject->edocument_id ?> edocument_like_edocument_view <?php echo ($this->LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $this->likeClass;?>"></i><span><?php echo $this->translate($this->likeText);?></span></a>
        <?php endif;?>
        <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.favourite', 1)):?>
          <a href="javascript:;" data-url="<?php echo $this->subject->edocument_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  edocument_favourite_edocument_<?php echo $this->subject->edocument_id ?> edocument_favourite_edocument_view <?php echo ($this->favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($this->favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
        <?php endif;?>
      <?php endif;?>
    </div>
  </div>
</div>
<script type="text/javascript">  
  $$('.core_main_edocument').getParent().addClass('active');
  sesJqueryObject('.edocument_comment').click(function() {
    sesJqueryObject('.comments_options').find('a').eq(0).trigger('click');
    sesJqueryObject('#adv_comment_subject_btn_<?php echo $this->subject->edocument_id; ?>').trigger('click');
  });
	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"edocument_general",true); ?>'+'?tag_id='+tag_id;
	}
</script>
