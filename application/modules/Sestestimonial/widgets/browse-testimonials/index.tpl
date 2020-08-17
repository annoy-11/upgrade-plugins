<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $randonNumber = 8000; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestestimonial/externals/styles/style.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js'); ?>
<script type="text/javascript">
  function loadMore() {
  
    if ($('view_more'))
      $('view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('view_more'))
      document.getElementById('view_more').style.display = 'none';
    
    if(document.getElementById('sestest_loading_image'))
     document.getElementById('sestest_loading_image').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/sestestimonial/name/browse-testimonials',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('sestestimonial_results').innerHTML = document.getElementById('sestestimonial_results').innerHTML + responseHTML;
		<?php if($this->viewtype == 'listview'): ?>
        pinboardLayout_<?php echo $randonNumber ?>();
	  <?php endif; ?>
        if(document.getElementById('view_more'))
          document.getElementById('view_more').destroy();
        
        if(document.getElementById('sestest_loading_image'))
          document.getElementById('sestest_loading_image').destroy();
        if(document.getElementById('loadmore_list'))
          document.getElementById('loadmore_list').destroy();
      }
    }));
    return false;
  }
 <?php if($this->viewtype == 'pinview') { ?>
  var wookmark = undefined;
  var wookmark<?php echo $randonNumber ?>;
  function pinboardLayout_<?php echo $randonNumber ?>(force) {
    sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
    imageLoadedAll<?php echo $randonNumber ?>(force);
  }
  
  function imageLoadedAll<?php echo $randonNumber ?>(force) {
  
    sesJqueryObject('#sestestimonial_results').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
    sesJqueryObject('#sestestimonial_results').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
    if (typeof wookmark<?php echo $randonNumber ?> == 'undefined' || typeof force != 'undefined') {
      (function() {
        function getWindowWidth() {
          return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
        }
        wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {
          itemWidth: <?php echo isset($this->allParams['width']) ? str_replace(array('px','%'),array(''),$this->allParams['width']) : '300'; ?>, // Optional min width of a grid item
          outerOffset: 0, // Optional the distance from grid to parent
          align:'left',
          flexibleWidth: function () {
            // Return a maximum width depending on the viewport
            return getWindowWidth() < 1024 ? '100%' : '40%';
          }
        });
      })();
    } else {
      wookmark<?php echo $randonNumber ?>.initItems();
      wookmark<?php echo $randonNumber ?>.layout(true);
    }
  }
  
  sesJqueryObject(document).ready(function(){
    pinboardLayout_<?php echo $randonNumber ?>();
  });
<?php } ?>
</script>
<?php if(count($this->paginator) > 0): ?>
<?php if($this->viewtype == 'listview'): ?>
  <?php if (empty($this->viewmore)): ?>
    <div class="sestestimonial_listing sesbasic_clearfix sesbasic_bxs" id="sestestimonial_results">
  <?php endif;?>  
    <?php foreach($this->paginator as $item) { ?>
      <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
      <div class="sestestimonial_list_item sesbasic_clearfix sesbasic_bxs">
        <div class="testimonial_list_body sesbasic_bxs">
          <div class="list_body_img">
            <div class="list_body_img_inner">
              <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
            </div>
          </div>
          <div class="list_content">
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
              <div class="list_title">
                <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
              </div>
            <?php } ?>
            <p class="_desc"><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
          </div>	
        </div>
        <div class="testimonial_list_footer sesbasic_bxs">
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
            <div class="testimonial_list_rating">
              <?php for( $x=1; $x<=$item->rating; $x++ ): ?>
                <span class="rating_star_generic rating_star"></span>
              <?php endfor; ?>
              <?php if( (round($item->rating) - $item->rating) > 0): ?>
                <span class="rating_star_generic rating_star_half"></span>
              <?php endif; ?>
              <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
                <span class="rating_star_generic rating_star_empty"></span>
              <?php endfor; ?>
            </div>
          <?php } ?>
          <div class="list_designation sesbasic_text_light">
            <span class="_name"><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span>
            <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
              <span class="_desg"><?php echo $item->designation; ?></span>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php if (empty($this->viewmore)): ?>
    </div>
  <?php endif;?>
  
<?php elseif($this->viewtype == 'advlistview'): ?>
  <?php if (empty($this->viewmore)): ?>
  	<div class="sestestimonial_advlisting sesbasic_clearfix sesbasic_bxs" id="sestestimonial_results">
    <?php endif;?>  
        <?php foreach($this->paginator as $item): ?>
          <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
          <div class="sestestimonial_advlist_item">
            <div class="testimonial_quote_right">
              <i class="fa fa-quote-right"></i>
            </div>
            <div class="testimonial_advlist_body sesbasic_clearfix sesbasic_bxs">
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
                <div class="testimonial_advlist_title">
                  <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
                </div>
              <?php } ?>
              <div class="list_body_desc">
                <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
                <div class="list_body_img">
                  <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.icon'); ?></a>
                </div>
                <span class="_name"><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span>
                <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
                  <span class="_designation sesbasic_text-light">&#40;<?php echo $item->designation; ?>&#41;</span>
                <?php } ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
                  <div class="testimonial_advlist_rating">
                    <?php for( $x=1; $x<=$item->rating; $x++ ): ?>
                      <span class="rating_star_generic rating_star"></span>
                    <?php endfor; ?>
                    <?php if( (round($item->rating) - $item->rating) > 0): ?>
                      <span class="rating_star_generic rating_star_half"></span>
                    <?php endif; ?>
                    <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
                      <span class="rating_star_generic rating_star_empty"></span>
                    <?php endfor; ?>
                  </div>
                <?php } ?>
              </div>	
            </div>
          </div>
      <?php endforeach; ?>
    <?php if (empty($this->viewmore)): ?>
    </div>
  <?php endif;?>
<?php elseif($this->viewtype == 'gridview'): ?>
  <?php if (empty($this->viewmore)): ?>
    <div class="sestestimonial_grid_basic sesbasic_clearfix sesbasic_bxs" id="sestestimonial_results">
  <?php endif;?>
  <?php foreach($this->paginator as $item): ?>
    <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
    <div class="sestestimonial_grid_item">
      <div class="sestestimonial_grid_inner">
        <div class="testimonial_grid_header">
          <img src="application/modules/Sestestimonial/externals/images/comma-3.png">
        </div>
        <div class="testimonial_grid_body">
          <div class="grid_body_img">
            <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
          </div>
          <div class="grid_body_desc sesbasic_text_light">
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
            <div class="testimonial_gridbasic_title">
              <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
            </div>
            <?php } ?>
            <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
          </div>
        </div>	
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
          <div class="testimonial_grid_rating">
            <?php for( $x=1; $x<=$item->rating; $x++ ): ?>
              <span class="rating_star_generic rating_star"></span>
            <?php endfor; ?>
            <?php if( (round($item->rating) - $item->rating) > 0): ?>
              <span class="rating_star_generic rating_star_half"></span>
            <?php endif; ?>
            <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
              <span class="rating_star_generic rating_star_empty"></span>
            <?php endfor; ?>
          </div>
        <?php } ?>
        <div class="testimonial_grid_footer">
          <a href="<?php echo $user->getHref(); ?>"><span class="_name"><?php echo $user->getTitle(); ?></span></a>
          <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
            <span class="_desg">&#40; <?php echo $item->designation; ?> &#41;</span>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  <?php if (empty($this->viewmore)): ?>
    </div>
  <?php endif; ?>

<?php elseif($this->viewtype == 'advgridview'): ?>
  <?php if (empty($this->viewmore)): ?>
    <div class="sestestimonial_advgrid sesbasic_clearfix sesbasic_bxs" id="sestestimonial_results" >
  <?php endif;?>
  <?php foreach($this->paginator as $item): ?>
    <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
    <div class="sestestimonial_advgrid_item">
      <div class="sestestimonial_advgrid_inner">
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
          <div class="testimonial_advgrid_header">
            <div class="ribbon">
              <span><?php echo $item->rating; ?> <i class="fa fa-star"></i></span>
            </div>
          </div>
        <?php } ?>
        <div class="testimonial_advgrid_body">
          <div class="advgrid_body_img">
            <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.profile'); ?></a>
          </div>
          <div class="testimonial_advgrid_des">
            <a href="<?php echo $user->getHref(); ?>"><span class="_name"><?php echo $user->getTitle(); ?></span></a>
            <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
              <span class="_desg">&#40; <?php echo $item->designation; ?> &#41;</span>
            <?php } ?>
          </div>
          <div class="advgrid_body_desc sesbasic_text_light">
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) { ?>
              <div class="testimonial_advgrid_title">
                <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
              </div>
            <?php } ?>
            <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
          </div>	
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  <?php if (empty($this->viewmore)): ?>
    </div>
  <?php endif; ?>
  
<?php elseif($this->viewtype == 'pinview'): ?>
  <?php if (empty($this->viewmore)): ?>
    <ul class="prelative sesbasic_pinboard_<?php echo $randonNumber ; ?>  sestestimonial_pinboard sesbasic_clearfix sesbasic_bxs" id="sestestimonial_results" style="min-height:50px;">
  <?php endif;?>
  <?php foreach($this->paginator as $item): ?>
    <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
    <li class="sestestimonial_pinboard_item new_image_pinboard_<?php echo $randonNumber; ?>" >
      <div class="sestestimonial_pinboard_inner">
        <div class="testimonial_pin_body">
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1) && $item->title) { ?>
            <div class="testimonial_pin_title">
              <a href="<?php echo $item->getHref(); ?>"><span class="_title"><?php echo $item->title; ?></span></a>
            </div>
          <?php } ?>
          <div class="pin_body_desc sesbasic_text_light">
            <p><?php echo mb_substr(nl2br($item->description),0,$this->truncationlimit).'...'; ?></p>
          </div>
        </div>
        <div class="testimonial_pin_footer">
          <div class="pin_body_img">
            <a href="<?php echo $user->getHref(); ?>"><?php echo $this->itemPhoto($user, 'thumb.icon'); ?></a>
          </div>
          <a href="<?php echo $user->getHref(); ?>"><span class="_name"><?php echo $user->getTitle(); ?></span></a>
          <?php if($item->designation && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) { ?>
            <span class="_desg">&#40; <?php echo $item->designation; ?> &#41;</span>
          <?php } ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) { ?>
            <div class="testimonial_pin_rating">
              <?php for( $x=1; $x<=$item->rating; $x++ ): ?>
                <span class="rating_star_generic rating_star"></span>
              <?php endfor; ?>
              <?php if( (round($item->rating) - $item->rating) > 0): ?>
                <span class="rating_star_generic rating_star_half"></span>
              <?php endif; ?>
              <?php for( $x=5; $x>round($item->rating); $x-- ): ?>
                <span class="rating_star_generic rating_star_empty"></span>
              <?php endfor; ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </li>
  <?php endforeach; ?>
  <?php if (empty($this->viewmore)): ?>
    </ul>
  <?php endif; ?>

<?php endif; ?>

  <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="clr" id="loadmore_list"></div>
      <div class="sesbasic_load_btn" id="view_more" onclick="loadMore();" style="display: block;">
        <a href="javascript:void(0);" id="feed_viewmore_link" class="sesbasic_animation sesbasic_link_btn"><?php echo $this->translate('View More'); ?></a>
      </div>
      <div class="sesbasic_load_btn" id="sestest_loading_image" style="display: none;">
        <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no testimonials.") ?>
    </span>
  </div>
<?php endif; ?>

<?php if($this->paginationType == 1): ?>
  <script type="text/javascript">    
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
