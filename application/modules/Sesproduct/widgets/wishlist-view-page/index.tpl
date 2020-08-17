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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<div class="sesproduct_my_wishlist sesbasic_clearfix sesbasic_bxs">
  <div class="sesproduct_wishlist_head">
    <div class="sesproduct_wishlist_left">
      <?php if(isset($this->wishlist) && isset($this->wishlistPhoto)) {?>
        <div class="sesproduct_thumb">
          <img src="<?php echo $this->wishlist->getPhotoUrl(); ?>" class="lg_img"/>
        </div>
      <?php } ?>
    </div>
    <?php if(isset($this->wishlistTitle)) { ?>
      <div class="sesproduct_wishlist_right">
          <a href="<?php echo $this->wishlist->getHref(); ?>"><h3><?php echo $this->wishlist->getTitle(); ?></h3></a>
      </div>
    <?php } ?>
    <?php if(isset($this->wishlistDesc)) { ?>
      <div class="sesproduct_wishlist_right">
         <span><?php echo $this->wishlist->description; ?></span>
      </div>
    <?php } ?>
		<?php if(isset($this->wishlist) && $this->wishlist->owner_id == $this->viewer_id) {?>
        <a href="javascript:void(0);" class="sesbasic_pulldown_toggle">
          <span><i class="fa fa-ellipsis-h"></i></span>  
        </a>      
          <div class="sesbasic_pulldown_options">
            <ul>
             <?php if(isset($this->editButton)) { ?>
                <li>
                    <a class="menu_sespage_main" href="javascript:void(0);" onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'edit','wishlist_id'=> $this->wishlist_id),'sesproduct_wishlist_view',true); ?>')"><?php echo $this->translate("Edit"); ?></a>
                </li>
            <?php } ?>
             <?php if(isset($this->deleteButton)) { ?>
                <li>
                    <a class="menu_sespage_main" href="javascript:void(0);" onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'delete','wishlist_id'=> $this->wishlist_id),'sesproduct_wishlist_view',true); ?>')" ><?php echo $this->translate("Delete"); ?></a>
                </li>
              <?php } ?>
            </ul>
          </div>
		<?php } ?>
         <?php if(isset($this->wishlistOwner)) { ?>
            <div class="_stats sesbasic_text_light">
                <a href="<?php echo $this->wishlist->getOwner()->getHref(); ?>"><span class="admin-name"><?php echo $this->translate("By "); ?><?php echo $this->wishlist->getOwner()->getTitle(); ?></span></a>
            </div>
           <?php } ?>
           <?php if(isset($this->wishlistCreation)) {?>
            <div class="_stats sesbasic_text_light">
                <a href="javascript:void(0);"><span class="date"><i class="fa fa-calendar"></i> <?php echo date('dS D, Y',strtotime($this->wishlist->creation_date)); ?></span></a>
            </div>
           <?php } ?>
          <div class="_stats sesbasic_text_light">
            <?php if(isset($this->wishlist->like_count) && isset($this->likeCountWishlist)) { ?>
                <span class="list_like"><i class="fa fa-thumbs-up"></i><?php echo $this->wishlist->like_count; ?></span>
            <?php } ?>
            <?php if(isset($this->wishlist->comment_count)) { ?>
                <span class="list_comm"><i class="fa fa-comments"></i><?php echo $this->wishlist->comment_count; ?></span>
            <?php } ?>
            <?php if(isset($this->wishlist->view_count)  && isset($this->viewCountPlaylist)) { ?>
                <span class="list_view"><i class="fa fa-eye"></i><?php  echo $this->wishlist->view_count; ?></span>
            <?php } ?>
            <?php if(isset($this->wishlist->favourite_count)  && isset($this->favouriteCountWishlist)) { ?>
                <span class="list_fav"><i class="fa fa-star"></i><?php echo $this->wishlist->favourite_count; ?></span>
             <?php } ?>
             <?php if(isset($this->wishlist->product_count) && isset($this->likeCountWishlist)) { ?>
                <span class="list_follow"><i class="fa fa-shopping-bag"></i><?php  echo $this->wishlist->product_count;  ?></span>
            <?php } ?>
          </div>
        </div>  
</div>
<script>
/*var ajaxDeleteRequest;
function getDeletewishlist(cartId)
{
    sesJqueryObject(this).hide();
	ajaxDeleteRequest = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesproduct/wishlist/delete',
	  'data': {
        wishlist_id: cartId,
        isAjax : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
         sesJqueryObject(this).show();
	  }
	})).send();
}  */
</script>
