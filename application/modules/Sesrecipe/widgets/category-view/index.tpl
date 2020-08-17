<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if(isset($this->category->thumbnail) && !empty($this->category->thumbnail)){ ?>
  <div class="sesrecipe_category_cover sesbasic_bxs sesbm">
 		<div class="sesrecipe_category_cover_inner" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>">
    	<div class="sesrecipe_category_cover_content">
        <div class="sesrecipe_category_cover_breadcrumb">
          <!--breadcrumb -->
          <a href="<?php echo $this->url(array('action' => 'browse'), "sesrecipe_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
          <?php if(isset($this->breadcrumb['category'][0]->category_id)){ ?>
             <?php if($this->breadcrumb['subcategory']) { ?>
              <a href="<?php echo $this->breadcrumb['category'][0]->getHref(); ?>"><?php echo $this->translate($this->breadcrumb['category'][0]->category_name) ?></a>
             <?php }else{ ?>
               <?php echo $this->translate($this->breadcrumb['category'][0]->category_name) ?>
             <?php } ?>
             <?php if($this->breadcrumb['subcategory']) echo "&nbsp;&raquo"; ?>
          <?php } ?>
          <?php if(isset($this->breadcrumb['subcategory'][0]->category_id)){ ?>
            <?php if($this->breadcrumb['subSubcategory']) { ?>
              <a href="<?php echo $this->breadcrumb['subcategory'][0]->getHref(); ?>"><?php echo $this->translate($this->breadcrumb['subcategory'][0]->category_name) ?></a>
            <?php }else{ ?>
              <?php echo $this->translate($this->breadcrumb['subcategory'][0]->category_name) ?>
            <?php } ?>
            <?php if($this->breadcrumb['subSubcategory']) echo "&nbsp;&raquo"; ?>
          <?php } ?>
          <?php if(isset($this->breadcrumb['subSubcategory'][0]->category_id)){ ?>
            <?php echo $this->translate($this->breadcrumb['subSubcategory'][0]->category_name) ?>
          <?php } ?>
        </div>

        <div class="sesrecipe_category_cover_blocks">
          <div class="sesrecipe_category_cover_block_img">
            <span style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>"></span>
          </div>
          <div class="sesrecipe_category_cover_block_info">
            <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
              <div class="sesrecipe_category_cover_title"> 
                <?php echo $this->category->title; ?>
              </div>
            <?php endif; ?>
            <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
              <div class="sesrecipe_category_cover_des clear sesbasic_custom_scroll">
                <?php echo $this->category->description;?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>  
<?php } else { ?>
  <div class="sesvide_breadcrumb clear sesbasic_clearfix">
    <!--breadcrumb -->
    <a href="<?php echo $this->url(array('action' => 'browse'), "sesrecipe_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
    <?php if(isset($this->breadcrumb['category'][0]->category_id)){ ?>
       <?php if($this->breadcrumb['subcategory']) { ?>
        <a href="<?php echo $this->breadcrumb['category'][0]->getHref(); ?>"><?php echo $this->translate($this->breadcrumb['category'][0]->category_name) ?></a>
       <?php }else{ ?>
         <?php echo $this->translate($this->breadcrumb['category'][0]->category_name) ?>
       <?php } ?>
       <?php if($this->breadcrumb['subcategory']) echo "&nbsp;&raquo"; ?>
    <?php } ?>
    <?php if(isset($this->breadcrumb['subcategory'][0]->category_id)){ ?>
      <?php if($this->breadcrumb['subSubcategory']) { ?>
        <a href="<?php echo $this->breadcrumb['subcategory'][0]->getHref(); ?>"><?php echo $this->translate($this->breadcrumb['subcategory'][0]->category_name) ?></a>
      <?php }else{ ?>
        <?php echo $this->translate($this->breadcrumb['subcategory'][0]->category_name) ?>
      <?php } ?>
      <?php if($this->breadcrumb['subSubcategory']) echo "&nbsp;&raquo"; ?>
    <?php } ?>
    <?php if(isset($this->breadcrumb['subSubcategory'][0]->category_id)){ ?>
      <?php echo $this->translate($this->breadcrumb['subSubcategory'][0]->category_name) ?>
    <?php } ?>
  </div>
  <div class="sesrecipe_browse_cat_top sesbm">
    <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
      <div class="sesrecipe_catview_title"> 
        <?php echo $this->category->title; ?>
      </div>
    <?php endif; ?>
    <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
      <div class="sesrecipe_catview_des">
        <?php echo $this->category->description;?>
      </div>
    <?php endif; ?>
  </div>
<?php } ?>

<!-- category subcategory -->
<?php if($this->show_subcat == 1 && count($this->innerCatData)>0){ ?>
  <div class="sesrecipe_category_grid sesbasic_clearfix sesbasic_bxs">
    <ul class="">	
      <?php foreach( $this->innerCatData as $item ):  ?>
        <li class=" ">
        <div class="sesrecipe_thumb_contant"  style="height:<?php echo is_numeric($this->heightSubcat) ? $this->heightSubcat.'px' : $this->heightSubcat ?>;width:<?php echo is_numeric($this->widthSubcat) ? $this->widthSubcat.'px' : $this->widthSubcat ?>;">
          <a href="<?php echo $item->getHref(); ?>" class="link_img img_animate">
            <?php if($item->thumbnail != '' && !is_null($item->thumbnail) && intval($item->thumbnail)){ ?>
                <img class="list_main_img"  src="<?php echo  Engine_Api::_()->storage()->get($item->thumbnail)->getPhotoUrl('thumb.thumb'); ?>"/>
              <?php } ?>
            <div class="animate_contant">
              <div>
                  <?php if(isset($this->iconSubcatActive) && $item->cat_icon != '' && !is_null($item->cat_icon) && intval($item->cat_icon)){ ?>
                    <img src="<?php echo  Engine_Api::_()->storage()->get($item->cat_icon)->getPhotoUrl('thumb.icon'); ?>" />
                  <?php } ?>
                  <?php if(isset($this->titleSubcatActive)){ ?>
                  <p class="title"><?php echo $this->translate($item->category_name); ?></p>
                  <?php } ?>
                  <?php if(isset($this->countRecipeSubcatActive)){ ?>
                    <p class="count"><?php echo $this->translate(array('%s recipe', '%s recipes', $item->total_recipes_categories), $this->locale()->toNumber($item->total_recipes_categories))?></p>
                  <?php } ?>
                
              </div>
            </div>
          </a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
   </div>
<?php } ?> 

<div class="sesrecipe_subcat_list_head clear sesbasic_clearfix">
	<p><?php echo $this->translate($this->textRecipe);?></p>
</div>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">  
<?php } ?>
   <?php if($this->viewType == 'list'):?>
		<?php if(!$this->is_ajax){ ?>
		<ul class="sesrecipe_recipe_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>" style="display:block;">
	<?php } ?>
			<?php foreach($this->paginator as $key=>$recipe):?>
				<li class="sesrecipe_list_recipe_view sesbasic_clearfix clear">
					<?php if(isset($this->titleActive)){ ?>
						<div class="sesrecipe_list_info_title">
							<a href="<?php echo $recipe->getHref(); ?>"><?php echo $recipe->getTitle(); ?></a>
						</div>
				  <?php } ?>
					<div class="sesrecipe_list_thumb sesrecipe_thumb">
						<a href="<?php echo $recipe->getHref(); ?>" data-url = "<?php echo $recipe->getType() ?>" class="sesrecipe_thumb_img">
							<span class="" style="background-image:url(<?php echo $recipe->getPhotoUrl(); ?>);"></span>
						</a>
						<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>
							<div class="sesrecipe_list_labels ">
								<?php if(isset($this->featuredLabelActive) && $recipe->featured == 1){ ?>
									<p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED'); ?></p>
								<?php } ?>
								<?php if(isset($this->sponsoredLabelActive) && $recipe->sponsored == 1){ ?>
									<p class="sesrecipe_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
					<div class="sesrecipe_list_info">
						<div class="sesrecipe_admin_list">
							<div class="sesrecipe_stats_list sesbasic_text_dark">
								<?php if(isset($this->byActive)){ ?>
									<?php $owner = $recipe->getOwner();?>
									<span>
										<a href="<?php echo $owner->getHref();?>"><?php echo $this->itemPhoto($owner, 'thumb.icon');?></a>
											<?php echo $this->translate('by');?>
										<a href="<?php echo $owner->getHref();?>"><?php echo $this->translate(' %1$s', $owner->getTitle()); ?></a>
									</span>
								<?php } ?>
							</div>
							<?php if(isset($this->creationDateActive)):?>
								<div class="sesrecipe_stats_list sesbasic_text_dark">
									<span>
										<i class="fa fa-clock-o"></i>
										<?php echo date('M d, Y',strtotime($recipe->publish_date));?>		
									</span>
								</div>
							<?php endif;?>
						</div>
						<div class="sesrecipe_list_contant">
							<?php if(isset($this->descriptionActive)){ ?>
								<?php echo $this->string()->truncate($this->string()->stripTags($recipe->body), $this->description_truncation) ?>
							<?php } ?> 
						</div>
						<div class="sesrecipe_list_stats sesbasic_text_dark">
							<?php if(isset($this->likeActive) && isset($recipe->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $recipe->like_count), $this->locale()->toNumber($recipe->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $recipe->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($recipe->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $recipe->comment_count), $this->locale()->toNumber($recipe->comment_count))?>"><i class="fa fa-comment"></i><?php echo $recipe->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($recipe->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $recipe->view_count), $this->locale()->toNumber($recipe->view_count))?>"><i class="fa fa-eye"></i><?php echo $recipe->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($recipe->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $recipe->favourite_count), $this->locale()->toNumber($recipe->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $recipe->favourite_count; ?></span>
							<?php } ?>
							<?php if(isset($this->ratingActive) && isset($recipe->rating) && $recipe->rating > 0 && Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view')): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($recipe->rating,1)), $this->locale()->toNumber(round($recipe->rating,1)))?>">
									<i class="fa fa-star"></i><?php echo round($recipe->rating,1).'/5';?><?php echo round($item->rating,1).'/5';?><?php echo $this->translate(' Ratings');?>
								</span>
							<?php endif; ?>
						</div>
						<?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && isset($this->ratingStarActive)):?>
							<?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $recipe->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting floatL', 'style' => ''));?>
						<?php endif;?>
						<?php if(isset($this->readmoreActive)){ ?>
							<div class="sesrecipe_list_readmore floatR"><a href="<?php echo $recipe->getHref();?>" class="sesrecipe_animation"><?php echo $this->translate('Read More'); ?></a></div>
						<?php } ?>
					</div>
				</li>  
		<?php endforeach;?>
		<?php  if(count($this->paginator) == 0){  ?>
			<div class="tip">
				<span>
					<?php echo $this->translate("No recipe in this  category."); ?>
					<?php if (!$this->can_edit):?>
						<?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sesrecipe_general").'">', '</a>'); ?>
					<?php endif; ?>
				</span>
			</div>
		<?php } ?>    
		<?php if($this->loadOptionData == 'pagging'): ?>
			<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesrecipe"),array('identityWidget'=>$randonNumber)); ?>
		<?php endif; ?>
	<?php if(!$this->is_ajax){ ?> 
	</ul>
	<?php } ?>
 <?php else:?>
	<?php if(!$this->is_ajax){ ?> 
	<ul class="sesrecipe_recipe_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>">
	<?php } ?>
			<?php foreach($this->paginator as $key=>$recipe): ?>
				<li class="sesrecipe_grid sesrecipe_catogery_grid_view sesbasic_bxs" style="width:<?php echo $this->width.'px'; ?>">
						<div class="sesrecipe_grid_inner sesrecipe_thumb"> 
							<div class="sesrecipe_grid_thumb" style="height:<?php echo $this->height.'px'; ?>">
								<a href="<?php echo $recipe->getHref(); ?>" data-url = "<?php echo $recipe->getType() ?>" class="sesrecipe_thumb_img">
									<span class="" style="background-image:url(<?php echo $recipe->getPhotoUrl(); ?>);"></span>
								</a>
								<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>
									<div class="sesrecipe_list_labels ">
										<?php if(isset($this->featuredLabelActive) && $recipe->featured == 1){ ?>
											<p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED'); ?></p>
										<?php } ?>
										<?php if(isset($this->sponsoredLabelActive) && $recipe->sponsored == 1){ ?>
											<p class="sesrecipe_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<div class="sesrecipe_grid_info clear clearfix sesbm">
						<?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && isset($this->ratingStarActive)):?>
							<?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $recipe->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting floatR', 'style' => 'margin-bottom:5px; margin-top:5px;'));?>
						<?php endif;?>
          	<?php if(isset($this->titleActive)){ ?>
							<div class="sesrecipe_grid_info_title">
								<a href="<?php echo $recipe->getHref();?>"><?php echo $recipe->getTitle(); ?></a>
							</div>
							<?php } ?>
					
						<div class="sesrecipe_grid_meta_block">
							<div class="sesrecipe_list_stats sesbasic_text_light">
								<?php if(isset($this->byActive)){ ?>
									<?php $owner = $recipe->getOwner();?>
                    <span>
                      <a href="<?php echo $owner->gethref();?>"><?php echo $this->itemPhoto($owner, 'thumb.icon');?></a>
                        <?php echo $this->translate('by');?>
                      <a href="<?php echo $owner->getHref();?>"><?php echo $this->translate(' %1$s', $owner->getTitle()); ?></a>
                      
                    </span>
									<?php } ?>
									<?php if(isset($this->creationDateActive)) { ?>
             
                    <span>
                      <i class="fa fa-clock-o"></i>
                      <?php echo date('M d, Y',strtotime($recipe->publish_date));?>	
                    </span>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="sesrecipe_grid_hover_block">
					<div class="sesrecipe_grid_info_hover_title">
					<a href="<?php echo $recipe->getHref();?>"><?php echo $recipe->getTitle(); ?></a>
					<span></span>
					</div>
					<div class="sesrecipe_grid_meta_block">
							<div class="sesrecipe_list_stats sesbasic_text_light">
                  <?php if(isset($this->byActive)){ ?>
                    <?php $owner = $recipe->getOwner();?>
                    <span>
                      <a href="<?php echo $owner->gethref();?>"><?php echo $this->itemPhoto($owner, 'thumb.icon');?></a>
                        <?php echo $this->translate('by');?>
                      <a href="<?php echo $owner->getHref();?>"><?php echo $this->translate(' %1$s', $owner->getTitle()); ?></a>
                      
                    </span>
									<?php } ?>
								<?php if(isset($this->creationDateActive)) { ?>
                   
                    <span>
                      <i class="fa fa-clock-o"></i>
                      <?php echo date('M d, Y',strtotime($recipe->publish_date));?>	
                    </span>
                  <?php } ?>
							</div>
						</div>
          <div class="sesrecipe_list_contant">
						<?php if(isset($this->descriptionActive)){ ?>
							<?php echo $this->string()->truncate($this->string()->stripTags($recipe->body), $this->description_truncation) ?>
						<?php } ?> 
					</div>
          
					<div class="sesrecipe_grid_hover_block_footer">  
						<div class="sesrecipe_list_stats sesbasic_text_light">
							<?php if(isset($this->likeActive) && isset($recipe->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $recipe->like_count), $this->locale()->toNumber($recipe->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $recipe->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($recipe->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $recipe->comment_count), $this->locale()->toNumber($recipe->comment_count))?>"><i class="fa fa-comment"></i><?php echo $recipe->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($recipe->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $recipe->view_count), $this->locale()->toNumber($recipe->view_count))?>"><i class="fa fa-eye"></i><?php echo $recipe->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($recipe->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $recipe->favourite_count), $this->locale()->toNumber($recipe->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $recipe->favourite_count; ?></span>
							<?php } ?>
							<?php if(isset($this->ratingActive) && isset($recipe->rating) && $recipe->rating > 0 ): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($recipe->rating,1)), $this->locale()->toNumber(round($recipe->rating,1)))?>">
								<i class="fa fa-star"></i><?php echo round($recipe->rating,1).'/5';?>
								</span>
							<?php endif; ?>
						</div>
					<?php if(isset($this->readmoreActive)){ ?>
						<div class="sesrecipe_grid_read_btn floatR"><a href="<?php echo $recipe->getHref();?>" class="sesrecipe_animation"><?php echo $this->translate('Read More '); ?></a></div>
					<?php } ?>
					</div>
					</div>
					</div>
				</li>
			<?php endforeach;?>
			<?php  if(  count($this->paginator) == 0){  ?>
				<div class="tip">
					<span>
						<?php echo $this->translate("No recipe in this  category."); ?>
						<?php if (!$this->can_edit):?>
							<?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sesrecipe_general").'">', '</a>'); ?>
						<?php endif; ?>
					</span>
				</div>
			<?php } ?>    
			<?php if($this->loadOptionData == 'pagging'){ ?>
				<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesrecipe"),array('identityWidget'=>$randonNumber)); ?>
			<?php } ?>
	<?php if(!$this->is_ajax){ ?> 
	</ul>
	<?php } ;?>
	<?php endif;?>
	<?php if(!$this->is_ajax){ ?>
 </div>
 <?php if($this->loadOptionData != 'pagging'){ ?>
  <div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
  <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
  <?php } ?>
  <script type="application/javascript">
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
	 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesrecipe/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: pageNum,    
				params :<?php echo json_encode($this->params); ?>, 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
				type:'<?php echo $this->view_type; ?>'
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
				dynamicWidth();
      }
    }));
    return false;
}
</script>
  <?php } ?>
<script type="text/javascript">
var valueTabData ;
// globally define available tab array
	var availableTabs_<?php echo $randonNumber; ?>;
	var requestTab_<?php echo $randonNumber; ?>;
  availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($this->defaultOptions); ?>;
<?php if($this->loadOptionData == 'auto_load'){ ?>
		window.addEvent('load', function() {
		 sesJqueryObject(window).scroll( function() {
			  var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
        var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
     });
	});
<?php } ?>
var defaultOpenTab ;
  viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  function viewMore_<?php echo $randonNumber; ?> (){
    var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesrecipe/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: <?php echo $this->page + 1; ?>,    
				params :<?php echo json_encode($this->params); ?>, 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
				dynamicWidth();
      }
    }));
    return false;
  }
<?php if(!$this->is_ajax){ ?>
function dynamicWidth(){
	var objectClass = sesJqueryObject('.sesrecipe_cat_recipe_list_info');
	for(i=0;i<objectClass.length;i++){
			sesJqueryObject(objectClass[i]).find('div').find('.sesrecipe_cat_recipe_list_content').find('.sesrecipe_cat_recipe_list_title').width(sesJqueryObject(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
</script>