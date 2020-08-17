<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seseventspeaker/externals/styles/styles.css'); ?>
<script type="text/javascript">
  function loadMore() {
    if(document.getElementById('load_more'))
      document.getElementById('load_more').style.display = 'none';    
    if(document.getElementById('underloading_image'))
     document.getElementById('underloading_image').style.display = '';
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/seseventspeaker/name/browse-speakers',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('results_data').innerHTML = document.getElementById('results_data').innerHTML + responseHTML;
        if(document.getElementById('load_more'))
          document.getElementById('load_more').destroy();
        if(document.getElementById('underloading_image'))
         document.getElementById('underloading_image').destroy();
        if(document.getElementById('loadmore_list'))
         document.getElementById('loadmore_list').destroy();
      }
    }));
    return false;
  }
</script>
<?php if(count($this->paginator) > 0): ?>
  <?php if (empty($this->viewmore)): ?>
     <h4><?php echo $this->translate(array('%s speaker found.', '%s speakers found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?></h4>
     <ul class="sesspeaker_list sesbasic_bxs sesbasic_clearfix" id="results_data">
  <?php endif; ?>
  <?php foreach ($this->paginator as $item): ?>
    <?php 
      $speakerEventCount = Engine_Api::_()->getDbtable('eventspeakers', 'seseventspeaker')->getSpeakerEventCounts(array('speaker_id' => $item->speaker_id));
	    $sitehostredirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.sitehostredirect', 1); 
			if($sitehostredirect && $item->user_id) {
			  $user = Engine_Api::_()->getItem('user', $item->user_id);
			  $href = $user->getHref();
			} else {
			  $href = $item->getHref();
			}
		?>
	  <li class="sesspeaker_list_item sesbasic_clearfix sesbasic_bxs sesevent_grid_btns_wrap" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
    	<div class="sesspeaker_list_item_inner prelative sesbasic_clearfix">
        <div class="sesspeaker_list_item_thumb prelative" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
          <?php
          $href = $href;
          $imageURL = $item->getPhotoUrl('thumb.profile');
          ?>
          <span class="sesspeaker_list_item_thumb_img" style="background-image:url(<?php echo $imageURL; ?>);"></span>
          <a href="<?php echo $href; ?>" class="sesspeaker_list_item_thumb_overlay"></a>
          <?php if(isset($this->featuredActive) || isset($this->sponsoredLabelActive)){ ?>
            <p class="sesevent_labels sesbasic_animation">
              <?php if(isset($this->featuredLabelActive) && $item->featured){ ?>
              <span class="sesevent_label_featured"><?php echo $this->translate("FEATURED"); ?></span>
              <?php } ?>
              <?php if(isset($this->sponsoredLabelActive) && $item->sponsored){ ?>
              <span class="sesevent_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
              <?php } ?>
            </p>
          <?php } ?>
          <?php if(isset($this->socialSharingActive) || isset($this->favouriteButtonActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $href); ?>
            <div class="sesevent_grid_btns"> 
              <?php if(isset($this->socialSharingActive)){ ?>
              <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $item->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
              <a href="<?php echo 'http://twitthis.com/twit?url=' . $urlencode . '&title=' . $item->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
              <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($item->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $item->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $item->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
              <?php } 
              $itemtype = 'seseventspeaker_speaker';
              $getId = 'speaker_id';
              ?>
              <?php
                if(isset($this->favouriteButtonActive) && isset($item->favourite_count)) {
                  $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesevent')->isFavourite(array('resource_type'=>'seseventspeaker_speaker','resource_id' => $item->speaker_id));
                  $favClass = ($favStatus)  ? 'button_active' : '';
                  $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count sesevent_favourite_seseventspeaker_speaker_". $item->speaker_id." sesbasic_icon_fav_btn sesevent_favourite_seseventspeaker_speaker ".$favClass ."' data-url=\"$item->speaker_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";
                  echo $shareOptions;
                }
              ?>
            </div>
          <?php } ?>
        </div>
	    <div class="sesspeaker_list_item_details sesbasic_clearfix">
	      <div class="sesspeaker_list_item_title">
	        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid) {
		        $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';
		        echo $this->htmlLink($href,$title ) ?>
	        <?php } else { ?>
		        <?php echo $this->htmlLink($href,$item->getTitle() ) ?>
	        <?php } ?>
	      </div>
	      <div class="sesspeaker_list_item_stats sesbasic_text_light">
	        <?php if(isset($this->speakerEventCountActive) && isset($speakerEventCount)) { ?>
		        <span title="<?php echo $this->translate(array('%s event', '%s events', $speakerEventCount), $this->locale()->toNumber($speakerEventCount))?>"><i class="fa fa-calendar"></i><?php echo $speakerEventCount; ?></span>
	        <?php } ?>
	        <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
		        <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
	        <?php } ?>
	        <?php if(isset($this->favouriteActive) && isset($item->favourite_count)) { ?>
		        <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
	        <?php } ?>
	      </div>
	    </div>
      
			<!--<div class="sesevent_member_profile_contact_info">
			  <?php if($item->phone && isset($this->phoneActive)): ?>
	        <span class="clear sesbasic_clearfix">
	          <i class="fa fa-phone sesbasic_text_light"></i>
	          <?php echo $item->phone ?>
	        </span>
	      <?php endif; ?>
	    </div>-->
      <!--
	    <div class="sesevent_member_profile_social_icon sesevent-social-icon">
	      <?php if($item->email && isset($this->emailActive)): ?>
		      <a href="mailto:<?php echo $item->email ?>" title="<?php echo $item->email; ?>"><i class="fa fa-envelope sesbasic_text_light"></i>
		      </a>
	      <?php endif; ?>
	      <?php if($item->website && isset($this->websiteActive)): ?>
	      <?php $website = (preg_match("#https?://#", $item->website) === 0) ? 'http://'.$item->website : $item->website; ?>
	      <a href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
	        <i class="fa fa-globe sesbasic_text_light"></i>
	      </a> 
	      <?php endif; ?>
	      <?php if($item->facebook && isset($this->facebookActive)): ?>
	      <?php $facebook = (preg_match("#https?://#", $item->facebook) === 0) ? 'http://'.$item->facebook : $item->facebook; ?>
	      <a href="<?php echo $facebook ?>" target="_blank" title="<?php echo $facebook ?>">
	        <i class="fa fa-facebook sesbasic_text_light"></i>
	      </a> 
	      <?php endif; ?>
	      <?php if($item->twitter && isset($this->twitterActive)): ?>
	      <?php $twitter = (preg_match("#https?://#", $item->twitter) === 0) ? 'http://'.$item->twitter : $item->twitter; ?>
	      <a href="<?php echo $twitter ?>" target="_blank" title="<?php echo $twitter ?>">
	        <i class="fa fa-twitter sesbasic_text_light"></i>
	      </a>
	      <?php endif; ?>
	      <?php if($item->linkdin && isset($this->linkdinActive)): ?>
	      <?php $linkdin = (preg_match("#https?://#", $item->linkdin) === 0) ? 'http://'.$item->linkdin : $item->linkdin; ?>
	      <a href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
	        <i class="fa fa-linkedin sesbasic_text_light"></i>
	      </a>
	      <?php endif; ?>
	      <?php if($item->googleplus && isset($this->googleplusActive)): ?>
	      <?php $googleplus = (preg_match("#https?://#", $item->googleplus) === 0) ? 'http://'.$item->googleplus : $item->googleplus; ?>
	      <a href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
	        <i class="fa fa-google-plus sesbasic_text_light"></i>
	      </a>
	      <?php endif; ?>
	    </div>
      -->
      </div>
	  </li>
  <?php endforeach; ?>

  <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="clear" id="loadmore_list"></div>
      <div class="sesbasic_view_more" id="load_more" onclick="loadMore();" style="display: block;">
        <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => 'feed_viewmore_link', 'class' => 'buttonlink icon_viewmore')); ?>
      </div>
      <div class="sesbasic_view_more_loading" id="underloading_image" style="display: none;">
        <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="Loading" />
        <?php echo $this->translate("Loading ...") ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
  
<?php if (empty($this->viewmore)): ?>
</ul>
<?php endif; ?>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('There are currently no hosts.') ?>
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
