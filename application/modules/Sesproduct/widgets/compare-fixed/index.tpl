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
<!--suppress ALL -->
<div class="sesproduct_compare_fixed sesbasic_clearfix sesbasic_bxs" style="display: none;" >
	<div class="sesproduct_compare_heading">
		<h3><?php echo $this->translate("Compare"); ?></h3>
	</div>
	<div class="sesproduct_compare_tabs">
		<ul class="sesproduct_compare_tabs_ul">
			<?php
				if(!empty($_SESSION["sesproduct_add_to_compare"])){ ?>
				<?php foreach($_SESSION["sesproduct_add_to_compare"] as $key=>$value){
					if(!count($value))
						continue;
					$category = Engine_Api::_()->getItem('sesproduct_category',$key);
					if(!$category)
						continue;
				?>
					<li data-category="<?php echo $key; ?>">
						<a href="javascript:;"><?php echo $category->category_name; ?> <span><?php echo count($value); ?></span></a>
					</li>
				<?php } ?>
			<?php } ?>
		</ul>
		<div class="sesproduct_compare_cnt">
			<?php
			if(!empty($_SESSION["sesproduct_add_to_compare"])){ ?>
				<?php foreach($_SESSION["sesproduct_add_to_compare"] as $key=>$value){
					if(!count($value))
						continue;
					$category = Engine_Api::_()->getItem('sesproduct_category',$key);
					if(!$category)
						continue;
					?>
				<div class="sesproduct_compare_inner">
					<?php foreach($value as $product_id){ ?>
						<?php $product = Engine_Api::_()->getItem("sesproduct",$product_id);
							if(!$product)
								continue;
						$compareData = Engine_Api::_()->sesproduct()->compareData($product);
						 ?>
						<div data-attr='<?php echo $compareData; ?>'  class="sesproduct_compare_small_product sesproduct_product_cnt" data-productid="<?php echo $product_id; ?>">
							<img src="<?php echo $product->getPhotoUrl(); ?>" alt="">
								<a class="sesproduct_compare_product_a" href="javascript:;"><div class="compare_close"><i class="fa fa-times"></i></div></a>
						</div>

					<?php } ?>
				</div>
				<?php } ?>
			<?php } ?>


		</div>
	</div>
	<div class="sesproduct_compare_btn">
		<a href="javascript:;" class="compare_cancel sesproduct_compare_remove_all"><?php echo $this->translate("Clear All"); ?></a>
		<a href="javascript:;" data-url="<?php echo $this->url(array('action'=>compare),'sesproduct_general',true); ?>" class="compare_apply sesproduct_compare_view"><?php echo $this->translate("Let's Compare!"); ?></a>
	</div>
</div>
<script>
	sesJqueryObject(document).on('click','.sesproduct_compare_view',function (e) {
		var url = sesJqueryObject(this).data('url');

		var index = sesJqueryObject('.sesproduct_compare_tabs_ul').find('li').index(sesJqueryObject('.sesproduct_compare_tabs_ul').find('li.active'));
		var productsDic = sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_compare_inner').eq(index);
		if(productsDic.find('.sesproduct_product_cnt').length < 2){
			alert("Select minimum 2 products to compare");
			return;
		}
		window.location.href = url+"/id/"+sesJqueryObject('.sesproduct_compare_tabs_ul').find('li.active').data('category');

    });
sesJqueryObject(document).ready(function() {
	sesJqueryObject(document).on('click',".sesproduct_compare_tabs_ul li a",function() {
		var indexElem = sesJqueryObject(this).parent().index();
		sesJqueryObject('.sesproduct_compare_tabs_ul').find('.active').removeClass('active');
		sesJqueryObject(this).parent().addClass('active');
		var elem = sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_compare_inner');
		elem.hide();
		elem.eq(indexElem).show();
	});
    if(sesJqueryObject('.sesproduct_compare_tabs_ul').find('li').length > 0){
        sesJqueryObject('.sesproduct_compare_tabs_ul').find('li').eq(0).find('a').trigger('click');
        if(sesJqueryObject('body').attr('id') != "global_page_sesproduct-index-compare")
        sesJqueryObject('.sesproduct_compare_fixed').show();
    }
});
sesJqueryObject(document).on('click','.sesproduct_compare_remove_all',function (e) {
	sesJqueryObject('.sesproduct_compare_fixed').hide();
    sesJqueryObject('.sesproduct_compare_tabs_ul').html('');
    sesJqueryObject('.sesproduct_compare_cnt').html('');
    sesJqueryObject('.sesproduct_compare_change').removeAttr('checked');
    sesJqueryObject.post('sesproduct/index/compare-product/type/all',{},function (res) {

    });
});
sesJqueryObject(document).on('click','.sesproduct_compare_change',function (e) {
	var data = sesJqueryObject(this).data('attr');
	var isChecked = sesJqueryObject(this).is(':checked');
	//isChecked == false remove
	//isChecked == true add
	if(isChecked == true) {
        addCompareHTML(data,this);
    }else{
		removeCompareProduct(data,this);
	}
});
function removeCompareProduct(data,obj) {
    //remove
    var category_id = data.category_id;
    sesJqueryObject.post('sesproduct/index/compare-product/type/remove',{category_id:category_id,product_id:data.product_id},function (res) {
    });
    var isCategoryLiExists = sesJqueryObject('.sesproduct_compare_tabs_ul').find('li[data-category='+category_id+']');
    var index = isCategoryLiExists.index();
    sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_product_cnt[data-productid='+data.product_id+']').remove();

    var count = sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_compare_inner').eq(index);

    if(!count.find('.sesproduct_product_cnt').length){
        isCategoryLiExists.remove();
    }else{
        var countProduct = sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_compare_inner').eq(index).find('.sesproduct_compare_small_product').length;
        isCategoryLiExists.find('a').html(data.category_title+" <span>"+countProduct+"</span>");
    }
	if(!sesJqueryObject('.sesproduct_compare_tabs_ul').find('li').length){
		sesJqueryObject('.sesproduct_compare_fixed').hide();
	}
}
function addCompareHTML(data,obj) {
    sesJqueryObject('.sesproduct_compare_fixed').show();
    var product_id = data.product_id;
    var category_id = data.category_id;
    var category_title = data.category_title;
    var countElementInCategory = 1;
    var productImage = data.image;
    sesJqueryObject.post('sesproduct/index/compare-product/type/add',{category_id:category_id,product_id:product_id},function (res) {

    });
    if(sesJqueryObject('.sesproduct_product_cnt[data-productid='+product_id+']').length){
		return;
	}
	var isCategoryLiExists = sesJqueryObject('.sesproduct_compare_tabs_ul').find('li[data-category='+category_id+']');
	if(!isCategoryLiExists.length) {
        var liHTML = '<li data-category = "' + category_id + '">' +
            '<a href="javascript:;">' + category_title + ' <span>1</span></a>' + '</li>';
		sesJqueryObject('.sesproduct_compare_tabs_ul').append(liHTML);
		sesJqueryObject('.sesproduct_compare_cnt').append("<div class='sesproduct_compare_inner' style=\"display:none\"></div>");
        var index = sesJqueryObject('.sesproduct_compare_tabs_ul').find('li[data-category='+category_id+']').index();
    }else{
	    var index = isCategoryLiExists.index();
	    var countProduct = sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_compare_inner').eq(index).find('.sesproduct_compare_small_product').length + 1;
        isCategoryLiExists.find('a').html(category_title+" <span>"+countProduct+"</span>");
	}
	var htmlCode = "<div data-attr='"+JSON.stringify(sesJqueryObject(obj).data('attr'))+"'' " +
		'class="sesproduct_compare_small_product sesproduct_product_cnt"  data-productid="'+product_id+'">'
		+'<img src="'+productImage+'" alt=""/>' +'<a class="sesproduct_compare_product_a" href="javascript:;">' +
	'<div class="compare_close"><i class="fa fa-times"></i></div></a>' + '</div>';
    sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_compare_inner').eq(index).append(htmlCode);

    if(sesJqueryObject('.sesproduct_compare_tabs_ul').find('li').length == 1) {
        sesJqueryObject('.sesproduct_compare_tabs_ul').find('li').eq(0).addClass('active');
        sesJqueryObject('.sesproduct_compare_cnt').find('.sesproduct_compare_inner').eq(0).show();
    }

}
sesJqueryObject(document).on('click','.sesproduct_compare_product_a',function (e) {
	var elem = sesJqueryObject(this).closest('.sesproduct_product_cnt');
	var data = elem.data('attr');
	removeCompareProduct(data,elem);
	sesJqueryObject('.sesproduct_compare_product_'+data.product_id).removeAttr('checked');
});
</script>