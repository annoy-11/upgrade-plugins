<?php

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template6.css'); ?>
<?php if($this->backgroundimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->backgroundimage;
    $backgroundimage = $photoUrl;
  ?>
<?php else: ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
    $backgroundimage = $photoUrl;
  ?>
<?php endif; ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des6wid3_wrapper">
	<div class="seslp_des6wid3_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
  	<div class="seslp_blocks_row sesbasic_clearfix">
      <div class="seslp_des6wid3_col seslp_des6wid3_col_left">
        <?php if($this->leftsideheading) { ?>
          <h2 class="seslp_des6_head"><?php echo $this->leftsideheading; ?></h2>
        <?php } ?>
        <div class="seslp_des6wid3_left_listing sesbasic_clearfix">
          <?php if(count($this->leftsideresults)) {
            $changeClass = 0;
          ?>
          <?php foreach($this->leftsideresults as $leftsideresult) { ?>
            <div class="seslp_des6wid3_left_list_item <?php echo $changeClass == 0 ? 'seslp_des6wid3_left_list_item_big' : ''; ?>">
              <article>
                <div class="seslp_des6wid3_left_list_item_thumb">
                  <a href="<?php echo $leftsideresult->getHref(); ?>" class="seslp_des6wid3_left_list_item_thumb_img">
                    <span class="seslp_animation" style="background-image:url(<?php echo $leftsideresult->getPhotoUrl() ?>);"></span>
                    <?php if($changeClass == 0 && $this->leftsidefonticon) { ?>
                      <i class="fa <?php echo $this->leftsidefonticon ?>"></i>
                    <?php } ?>
                  </a>
                </div>
                <?php if($changeClass > 0) { ?>
                  <div class="seslp_des6wid3_left_list_item_cont">
                    <h3 class="seslp_des6wid3_left_list_item_title"><a href="<?php echo $leftsideresult->getHref(); ?>"><?php echo $leftsideresult->getTitle(); ?></a></h3>
                  </div>
                <?php } ?>
              </article>
            </div>
          <?php 
          $changeClass++;
          }
          } ?>
        </div>
        <?php if($this->leftseeallbuttontext && $this->leftseeallbuttonurl) { ?>
          <div class="seslp_des6wid3_more_btn">
            <a href="<?php echo $this->leftseeallbuttonurl; ?>" class="seslp_animation seslp_des6_more_btn"><?php echo $this->leftseeallbuttontext; ?> <i class="fa fa-chevron-circle-right"></i></a>
          </div>
        <?php } ?>
      </div>
      
      
      <div class="seslp_des6wid3_col seslp_des6wid3_col_right">
        <?php if($this->rightsideheading) { ?>
          <h2 class="seslp_des6_head"><?php echo $this->rightsideheading ; ?></h2>
        <?php } ?>
        <div class="seslp_des6wid3_right_listing sesbasic_clearfix">
          <?php foreach($this->rightsideresults as $rightsideresult) { ?>
            <div class="seslp_des6wid3_right_list_item">
              <article class="sesbasic_clearfix">
                <div class="seslp_des6wid3_right_list_item_thumb">
                  <a href="<?php echo $rightsideresult->getHref(); ?>">
                    <span class="seslp_animation" style="background-image:url(<?php echo $rightsideresult->getPhotoUrl() ?>);"></span>
                    <?php if(in_array('creationdate', $this->rightsideshowstats)) { ?>
                      <?php $rightsideshowstats = explode('-', $rightsideresult->creation_date);
                      //print_r($rightsideshowstats);die;
                      $date = explode(' ', $rightsideshowstats['2']);
                      ?>
                      <p><span><?php echo date("M", mktime(0, 0, 0, $rightsideshowstats[1], 10)); ?></span><span><?php echo $date[0] .' / '. $rightsideshowstats['0']; ?></span></p>
                    <?php } ?>
                  </a>
                </div>
                <div class="seslp_des6wid3_right_list_item_cont">
                  <?php if(in_array('title', $this->rightsideshowstats)) { ?>
                    <h3><a href="<?php echo $rightsideresult->getHref(); ?>"><?php echo $rightsideresult->getTitle(); ?></a></h3>
                  <?php } ?>
                  <p class="seslp_des6wid3_right_list_item_stats">
                    <?php if(isset($rightsideresult->owner_id) && in_array('ownername', $this->rightsideshowstats)) { ?>
                      <?php $user = Engine_Api::_()->getItem('user', $rightsideresult->owner_id); ?>
                      <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a></span></span>
                    <?php } else if(isset($rightsideresult->user_id) && in_array('ownername', $this->rightsideshowstats)) { ?>
                      <?php $user = Engine_Api::_()->getItem('user', $rightsideresult->user_id); ?>
                      <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $user->getTitle(); ?></a></span></span>
                    <?php } ?>
                    <?php if(isset($rightsideresult->location) && $rightsideresult->location && in_array('location', $this->rightsideshowstats)) { ?>
                      <span><i class="fa fa-map-marker"></i><span><a href="javascript:void(0);" class="sesbasic_linkinherit"><?php echo $rightsideresult->location; ?></a></span></span>
                    <?php } ?>
                  </p>
                  <p class="seslp_des6wid3_right_list_item_stats">
                    <?php if(in_array('likecount', $this->rightsideshowstats)): ?>
                      <span><i class="fa fa-thumbs-up"></i><span><?php echo $rightsideresult->like_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(in_array('commentcount', $this->rightsideshowstats)): ?>
                      <span><i class="fa fa-comment"></i><span><?php echo $rightsideresult->comment_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(in_array('viewcount', $this->rightsideshowstats)): ?>
                      <span><i class="fa fa-eye"></i><span><?php echo $rightsideresult->view_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(isset($rightsideresult->favourite_count) && in_array('favouritecount', $this->rightsideshowstats)): ?>
                      <span><i class="fa fa-heart"></i><span><?php echo $rightsideresult->favourite_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(isset($rightsideresult->rating_count) && in_array('ratingcount', $this->rightsideshowstats)): ?>
                      <span><i class="fa fa-star"></i><span><?php echo $rightsideresult->rating; ?></span></span>
                    <?php endif; ?>
                  </p>
                </div>
              </article>
            </div>
          <?php } ?>
        </div>
        <?php if($this->rightseeallbuttontext && $this->rightseeallbuttonurl) { ?>
          <div class="seslp_des6wid3_more_btn">
            <a href="<?php echo $this->rightseeallbuttonurl; ?>" class="seslp_animation seslp_des6_more_btn"><?php echo $this->rightseeallbuttontext; ?> <i class="fa fa-chevron-circle-right"></i></a>
          </div>
        <?php } ?>
      </div>
		</div>
  </div>
</div>