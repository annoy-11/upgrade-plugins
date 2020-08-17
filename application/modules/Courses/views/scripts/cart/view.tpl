<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: view.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php //if(!$this->is_ajax){ ?>
<?php  if($this->cartData['cartCoursesCount']) { ?>
  <div class="sesbasic_header_pulldown_inner">  
    <div class="sesbasic_header_pulldown_head">
    	<div class="_title">
      	<?php echo $this->translate("COURSE CART")?>
      </div>
      <div class="_right">
        <span class="_items"> <?php echo $this->translate(array('%s Course', '%s Courses', ($this->cartData['cartCoursesCount'])),($this->cartData['cartCoursesCount'])); ?></span>
      </div>
    </div>
    <div class="sesbasic_header_pulldown_body">
      <?php foreach($this->cartData['cartCourses'] as $cart) {
        $item = Engine_Api::_()->getItem('courses',$cart->course_id);
        if(isset($item)){
        $priceData = Engine_Api::_()->courses()->courseDiscountPrice($item);
      ?>
        <div class="sesbasic_cart_pulldown_item">
          <div class="_thumb">
            <a href="javascrip:;"><img src="<?php echo $item->getPhotoUrl('thumb.icon'); ?>"/></a>
          </div>
          <div class="_info">
            <div class="_title">
              <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>
            </div>  
            <div class="_amt">
              <?php if(!empty($priceData['discountPrice'])){ ?>
                <?php echo Engine_Api::_()->courses()->getCurrencyPrice(round($priceData['discountPrice'],2)) ; ?>
              <?php } else { ?>
                <span style="font-weight: bold;"><?php echo $this->translate("Free "); ?></span>
              <?php } ?>
            </div>
            <div class="_close" id="close<?php echo $cart->cartcourse_id; ?>" style="display:<?php echo $this->cartviewPage ? 'none':'block'; ?>">
              <a href="javascript:void(0);" onclick="getDeleteCourse('<?php echo $cart->cartcourse_id; ?>')" class="fa fa-times"></a>
            </div>
          </div>
      	</div>    
      <?php } ?>
    </div>
    <div class="sesbasic_header_pulldown_footer sesbasic_clearfix">
      <div class="_total">
        <div class="_label">
        	<span><?php echo $this->translate("Grand Total:"); ?> </span>
        </div>      
        <div class="_value">
          <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice(round($this->cartData['totalPrice'],2)) ; ?></span>
        </div>
      </div>
    	<div class="_footer">
        <div id="Cart<?php echo $this->cartData['cartId']; ?>" style="display:<?php echo $this->cartviewPage ? 'none':'block'; ?>">
        	<a href="javascript:void(0);" class="btn_border" onclick="getDeleteCart('<?php echo $this->cartData['cartId']; ?>')"><?php echo $this->translate("Clear All"); ?></a>
        </div>
        <div> 
        	<a href="<?php echo $this->url(array('action'=>'checkout'),'courses_cart',true); ?>" class="btn_full" ><?php echo $this->translate("Checkout"); ?></a>
        </div>
    	</div>
    </div>
  </div>

<?php } ?>
<?php } else { ?>
  <div class="sesbasic_header_pulldown_inner">
    <div class="sesbasic_header_pulldown_tip">
      <span><?php echo $this->translate("You have not added courses yet in your cart.");  ?></span>
    </div>
  </div>
<?php } ?>
<script>
var ajaxDeleteRequest;
function getDeleteCourse(cartId)
{
var confirmDelete = confirm("<?php echo $this->translate('Are you sure you want to delete?'); ?>");
  if(confirmDelete){
      sesJqueryObject("#close"+cartId).removeClass();
      sesJqueryObject("#close"+cartId).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
      ajaxDeleteRequest = (new Request.HTML({
      method: 'post',
      format: 'html',
      'url': en4.core.baseUrl + 'courses/cart/view',
      'data': {
          id: cartId,
          isAjax : 1,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        sesJqueryObject('.courses_cart_dropdown').html(responseHTML);
        if(sesJqueryObject('.courses_cart_count').length){
            var count = parseInt(sesJqueryObject('.courses_cart_count').html());
            sesJqueryObject('.courses_cart_count').html(count-1);
            if(count-1 <= 0){
                sesJqueryObject('.courses_cart_count').hide();
            }
        }
        <?php if($this->cartviewPage): ?>
            if(count-1 <= 0){
                 window.location.href = '<?php echo $this->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'browse'), 'courses_general', false); ?>';
            }
        <?php endif; ?>
        if(sesJqueryObject('.courses_cart_list_item_'+cartId) !='undefined')
          sesJqueryObject('.courses_cart_list_item_'+cartId).remove();
        if(sesJqueryObject('.courses_checkout_sidebar_head') !='undefined')
          sesJqueryObject('.courses_checkout_sidebar_head').html(en4.core.language.translate('Your Item('+(count-1)+')'));
      }
    })).send();
  }
}  
function getDeleteCart(cartId)
{
var confirmDelete = confirm('Are you sure you want to delete?');
if(confirmDelete){
    sesJqueryObject("#Cart"+cartId).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
    ajaxDeleteRequest = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'courses/cart/view',
	  'data': {
        is_Ajax_Delete : 1,
        isAjax : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        sesJqueryObject('.courses_cart_dropdown').html(responseHTML);
        sesJqueryObject('.courses_cart_count').hide();
        sesJqueryObject('.courses_cart_count').html(0);
	  }
	})).send();
}
} 
</script>
<?php die; ?>
