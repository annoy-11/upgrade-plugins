<?php ?>
<?php echo $this->content()->renderWidget('sesvideo.browse-menu',array()); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesvideosell/externals/styles/styles.css'); ?>
<div class="layout_middle sesbasic_bxs">
	<div class="generic_layout_container">
  
    <div class="sesvideosell_manage_tabs sesbasic_clearfix">
      <ul class="sesbasic_clearfix">
        <li>
          <?php echo $this->htmlLink(array('route' => 'sesvideosell_extended', 'action' => 'orders', 'user_id' => $this->user_id), $this->translate("My Purchased Videos"), array('class' => '', 'title' => $this->translate("My Purchased Videos"))); ?>
        </li>
        <li class="active">
          <?php echo $this->htmlLink(array('route' => 'sesvideosell_sold', 'action' => 'sold', 'user_id' => $this->user_id), $this->translate("My Sold Videos"), array('class' => '', 'title' => $this->translate("My Sold Videos"))); ?>
        </li>
        <!--<li class="fright"><a href="<?php //echo $this->user->getHref(); ?>"><?php //echo $this->translate("Back to Profile"); ?></a></li>-->
      </ul>
    </div>
    <div class="sesvideosell_manage_tabs_content sesbasic_clearfix">  
      <?php if($this->paginator->getTotalItemCount() > 0): ?>
        <p><?php echo $this->translate('Please find below the list of all the videos you have sold from this website.'); ?></p>
        <div class="sesbasic_clearfix sesvideosell_orders">
          <?php foreach($this->paginator as $result): ?>
            <?php $video = Engine_Api::_()->getItem('sesvideo_video', $result->video_id); ?>
            <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
            <div class="sesvideosell_order_item sesbasic_clearfix">
              <div class="sesvideosell_order_item_header sesbasic_clearfix">
                <?php echo $this->translate("Order Id:"); ?> <b><?php echo $result->order_id; ?></b>
              </div>
              <div class="sesvideosell_order_item_cont sesbasic_clearfix">            	
                <div class="sesvideosell_order_item_img">
                  <?php $imageURL = $video->getPhotoUrl(); ?>
                  <a href="<?php echo $video->getHref(); ?>">
                    <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
                  </a>
                </div>
                <div class="sesvideosell_order_item_details">
                  <div class="sesvideosell_order_item_title">
                    <a href="<?php echo $video->getHref(); ?>"><?php echo $video->getTitle(); ?></a>
                  </div>
                  <div class="sesvideosell_order_item_stat sesbasic_text_light">
                    <?php echo $this->translate("Ordered On %s", $result->creation_date); ?>
                  </div>
                  <div class="sesvideosell_order_item_stat sesbasic_text_light">
                    <?php echo $this->translate("Buyer Name ");?><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
                  </div>
                  <div class="sesvideosell_order_item_btm">
                    <span class="floatL">
                      <?php $currency = Engine_Api::_()->sesbasic()->getCurrencyPrice($result->total_useramount, $result->currency_symbol);  ?>
                      <?php echo $this->translate("Total Paid: %s", $currency); ?>
                    </span>
<!--                    <span class="floatR sesvideosell_download_link">
                      <?php //echo $this->htmlLink(array('route' => 'sesvideosell_specific', 'action' => 'download', 'video_id' => $video->getIdentity()), $this->translate("Download Video"), array('class' => 'fa fa-download', 'title' => $this->translate("Download Video"))); ?>
                    </span>-->
                  </div>
                </div>	
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="tip">
          <span>
            <?php echo $this->translate("You have not sold any videos yet.") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
	</div>
</div>