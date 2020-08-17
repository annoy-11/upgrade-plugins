<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesvideo/externals/styles/styles.css'); ?>
<script type="text/javascript">
  function showPopUp(url) {
    Smoothbox.open(url);
    parent.Smoothbox.close;
  }
</script>
<?php if(count($this->results) > 0) :?>
  <ul class="sesvideo_playlist_grid_listing sesbasic_clearfix sesbasic_bxs">
    <?php foreach( $this->results as $item ):  ?>
      <li class="sesvideo_playlist_grid sesbm" style="width:<?php echo $this->width ?>px;">
        <div class="sesvideo_playlist_grid_top sesbasic_clearfix">
          <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.icon')) ?>
          <div>
             <?php if(!empty($this->information) && in_array('title', $this->information)): ?>
                <div class="sesvideo_playlist_grid_title">
                    <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($this->information) && in_array('postedby', $this->information)): ?>
            <div class="sesvideo_playlist_grid_stats  sesbasic_text_light">
              <?php echo $this->translate('by');?> <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>     
            </div>
            <?php endif; ?>
            <div class="sesvideo_playlist_grid_stats sesvideo_list_stats sesbasic_text_light">
              <?php if (!empty($this->information) && in_array('favouriteCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s favorite', '%s favorites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count)); ?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('viewCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)); ?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('likeCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
              <?php endif; ?>
              <?php $wishlistCount = Engine_Api::_()->getDbtable('playlistproducts', 'sesproduct')->playlistProductsCount(array('wishlist_id' => $item->wishlist_id));  ?>
              <?php if (!empty($this->information) && in_array('videoCount', $this->information)): ?>
                <span title="<?php echo $this->translate(array('%s product', '%s products', $item->product_count), $this->locale()->toNumber($item->product_count)); ?>"><i class="fa fa-shopping-bag fa-video"></i><?php echo $item->product_count; ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
