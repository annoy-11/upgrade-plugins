<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); ?>
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
  <div class="sesjob_category_cover sesbasic_bxs sesbm">
 		<div class="sesjob_category_cover_inner" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>">
    	<div class="sesjob_category_cover_content">
        <div class="sesjob_category_cover_breadcrumb">
          <!--breadcrumb -->
          <a href="<?php echo $this->url(array('action' => 'browse'), "sesjob_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
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

        <div class="sesjob_category_cover_blocks">
          <div class="sesjob_category_cover_block_img">
            <span style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>"></span>
          </div>
          <div class="sesjob_category_cover_block_info">
            <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
              <div class="sesjob_category_cover_title"> 
                <?php echo $this->category->title; ?>
              </div>
            <?php endif; ?>
            <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
              <div class="sesjob_category_cover_des clear sesbasic_custom_scroll">
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
    <a href="<?php echo $this->url(array('action' => 'browse'), "sesjob_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
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
  <div class="sesjob_browse_cat_top sesbm">
    <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
      <div class="sesjob_catview_title"> 
        <?php echo $this->category->title; ?>
      </div>
    <?php endif; ?>
    <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
      <div class="sesjob_catview_des">
        <?php echo $this->category->description;?>
      </div>
    <?php endif; ?>
  </div>
<?php } ?>

<!-- category subcategory -->
<?php if($this->show_subcat == 1 && count($this->innerCatData)>0){ ?>
  <div class="sesjob_category_grid sesbasic_clearfix sesbasic_bxs">
    <ul class="">	
      <?php foreach( $this->innerCatData as $item ):  ?>
        <li class=" ">
        <div class="sesjob_thumb_contant"  style="height:<?php echo is_numeric($this->heightSubcat) ? $this->heightSubcat.'px' : $this->heightSubcat ?>;width:<?php echo is_numeric($this->widthSubcat) ? $this->widthSubcat.'px' : $this->widthSubcat ?>;">
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
                  <?php if(isset($this->countJobSubcatActive)){ ?>
                    <p class="count"><?php echo $this->translate(array('%s job', '%s jobs', $item->total_jobs_categories), $this->locale()->toNumber($item->total_jobs_categories))?></p>
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

<div class="sesjob_subcat_list_head clear sesbasic_clearfix">
	<p><?php echo $this->translate($this->textJob);?></p>
</div>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">  
<?php } ?>
   <?php if($this->viewType == 'list'):?>
		<?php if(!$this->is_ajax){ ?>
		<ul class="sesjob_job_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>" style="display:block;">
	<?php } ?>
			<?php foreach($this->paginator as $key=>$job):?>
				<li class="sesjob_list_job_view sesbasic_clearfix clear">
         <div class="sesjob_list_job_main">
         <div class="sesjob_list_thumb sesjob_thumb">
						<a href="<?php echo $job->getHref(); ?>" data-url = "<?php echo $job->getType() ?>" class="sesjob_thumb_img">
							<span class="" style="background-image:url(<?php echo $job->getPhotoUrl(); ?>);"></span>
						</a>
						<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>
							<div class="sesjob_list_labels ">
								<?php if(isset($this->featuredLabelActive) && $job->featured == 1){ ?>
									<p class="sesjob_label_featured"><?php echo $this->translate('<i class="fa fa-star"></i>'); ?></p>
								<?php } ?>
								<?php if(isset($this->sponsoredLabelActive) && $job->sponsored == 1){ ?>
									<p class="sesjob_label_sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>'); ?></p>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
          
					<div class="sesjob_list_info">
          <?php if(isset($this->titleActive)){ ?>
						<div class="sesjob_list_info_title">
							<a href="<?php echo $job->getHref(); ?>"><?php echo $job->getTitle(); ?></a>
						</div>
				  <?php } ?>
           <div class="sesjob_stats_list">
    	<span class="sesbasic_text_light">
       <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
<?php if($company) { ?>
  <?php if(isset($this->companynameActive) && isset($item->company_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)){ ?>
  <i class="fa fa-building" aria-hidden="true"></i> <a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
  <?php } ?>
<?php } ?>
   </span>
     </div>
           <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
      <?php if($company) { ?>
       <?php if(isset($this->industryActive) && isset($company->industry_id)) { ?>
        <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
        <?php if($industry) { ?>
         <div class="sesjob_stats_list sesjob_stats_list_itype sesbasic_text_light">
           <span><?php echo $this->translate('Industry Type: '); ?></span><?php echo $this->translate($industry->industry_name); ?>
        </div>
        <?php } ?>
      <?php } ?>
      <?php } ?>
						<div class="sesjob_list_contant">
							<?php if(isset($this->descriptionActive)){ ?>
                              <?php echo $job->getDescription($this->description_truncation);?>
							<?php } ?> 
						</div>
						<?php if(isset($this->readmoreActive)){ ?>
							<div class="sesjob_list_readmore"><a href="<?php echo $job->getHref();?>" class="sesjob_animation"><?php echo $this->translate('Read More'); ?></a></div>
						<?php } ?>
					</div>
          </div>
          <div class="sesjob_admin_list">
          <div class="sesjob_list_stats sesbasic_text_dark">
							<?php if(isset($this->likeActive) && isset($job->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $job->like_count), $this->locale()->toNumber($job->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $job->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($job->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $job->comment_count), $this->locale()->toNumber($job->comment_count))?>"><i class="fa fa-comment"></i><?php echo $job->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($job->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $job->view_count), $this->locale()->toNumber($job->view_count))?>"><i class="fa fa-eye"></i><?php echo $job->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($job->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $job->favourite_count), $this->locale()->toNumber($job->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $job->favourite_count; ?></span>
							<?php } ?>
						</div>
							<?php if(isset($this->creationDateActive)):?>
								<div class="sesjob_stats_list sesbasic_text_dark">
									<span>
									on
										<?php echo date('M d, Y',strtotime($job->publish_date));?>		
									</span>
								</div>
							<?php endif;?>
              <div class="sesjob_stats_list sesbasic_text_dark">
								<?php if(isset($this->byActive)){ ?>
									<?php $owner = $job->getOwner();?>
									<span>
										<a href="<?php echo $owner->getHref();?>"><?php echo $this->itemPhoto($owner, 'thumb.icon');?></a>
											<?php echo $this->translate('Posted by');?>
										<a href="<?php echo $owner->getHref();?>"><?php echo $this->translate(' %1$s', $owner->getTitle()); ?></a>
									</span>
								<?php } ?>
							</div>
						</div>
				</li>  
		<?php endforeach;?>
		<?php  if(count($this->paginator) == 0){  ?>
			<div class="tip">
				<span>
					<?php echo $this->translate("No job in this  category."); ?>
					<?php if (!$this->can_edit):?>
						<?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sesjob_general").'">', '</a>'); ?>
					<?php endif; ?>
				</span>
			</div>
		<?php } ?>    
		<?php if($this->loadOptionData == 'pagging'): ?>
			<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesjob"),array('identityWidget'=>$randonNumber)); ?>
		<?php endif; ?>
	<?php if(!$this->is_ajax){ ?> 
	</ul>
	<?php } ?>
 <?php else:?>
	<?php if(!$this->is_ajax){ ?> 
	<ul class="sesjob_job_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>">
	<?php } ?>
			<?php foreach($this->paginator as $key=>$job): ?>
				<li class="sesjob_grid sesjob_catogery_grid_view sesbasic_bxs" style="width:<?php echo $this->width.'px'; ?>">
						<div class="sesjob_grid_inner sesjob_thumb"> 
							<div class="sesjob_grid_thumb" style="height:<?php echo $this->height.'px'; ?>;width:<?php echo is_numeric($this->width_grid_photo) ? $this->width_grid_photo.'px' : $this->width_grid_photo ?>">
								<a href="<?php echo $job->getHref(); ?>" data-url = "<?php echo $job->getType() ?>" class="sesjob_thumb_img">
									<span class="" style="background-image:url(<?php echo $job->getPhotoUrl(); ?>);"></span>
								</a>
								<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>
									<div class="sesjob_list_labels ">
										<?php if(isset($this->featuredLabelActive) && $job->featured == 1){ ?>
											<p class="sesjob_label_featured"><?php echo $this->translate('FEATURED'); ?></p>
										<?php } ?>
										<?php if(isset($this->sponsoredLabelActive) && $job->sponsored == 1){ ?>
											<p class="sesjob_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						<div class="sesjob_grid_info clear clearfix sesbm">
          	<?php if(isset($this->titleActive)){ ?>
							<div class="sesjob_grid_info_title">
								<a href="<?php echo $job->getHref();?>"><?php echo $job->getTitle(); ?></a>
							</div>
							<?php } ?>
              <div class="sesjob_list_stats">
         <span class="sesbasic_text_light">
       <?php $company = Engine_Api::_()->getItem('sesjob_company', $job->company_id); ?>
<?php if($company) { ?>
  <?php if(isset($this->companynameActive) && isset($job->company_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)){ ?>
  <i class="fa fa-building" aria-hidden="true"></i> <a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
  <?php } ?>
<?php } ?>
   </span>
        </div>
         <?php $company = Engine_Api::_()->getItem('sesjob_company', $job->company_id); ?>
      <?php if($company) { ?>
       <?php if(isset($this->industryActive) && isset($company->industry_id)) { ?>
        <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
        <?php if($industry) { ?>
         <div class="sesjob_grid_itype sesbasic_text_light">
           <span><?php echo $this->translate('Industry Type: '); ?></span><?php echo $this->translate($industry->industry_name); ?>
        </div>
        <?php } ?>
      <?php } ?>
      <?php } ?>
					</div>
          <div class="sesjob_grid_owner sesbasic_clearfix">
							<div class="sesjob_list_stats sesbasic_text_light">
								<?php if(isset($this->byActive)){ ?>
									<?php $owner = $job->getOwner();?>
                    <span>
                      <a href="<?php echo $owner->gethref();?>"><?php echo $this->itemPhoto($owner, 'thumb.icon');?></a>
                        <?php echo $this->translate('Posted by');?>
                      <a href="<?php echo $owner->getHref();?>"><?php echo $this->translate(' %1$s', $owner->getTitle()); ?></a>
                      
                    </span>
									<?php } ?>
									<?php if(isset($this->creationDateActive)) { ?>
                    <span>on
                      <?php echo date('M d, Y',strtotime($job->publish_date));?>	
                    </span>
								<?php } ?>
							</div>
						</div>
					<div class="sesjob_grid_hover_block">
					<div class="sesjob_grid_info_hover_title">
					<a href="<?php echo $job->getHref();?>"><?php echo $job->getTitle(); ?></a>
					<span></span>
					</div>
          <div class="sesjob_list_contant">
						<?php if(isset($this->descriptionActive)){ ?>
							<?php echo $job->getDescription($this->description_truncation);?>
						<?php } ?> 
					</div>
          
					<div class="sesjob_grid_hover_block_footer">  
						<div class="sesjob_list_stats sesbasic_text_light">
							<?php if(isset($this->likeActive) && isset($job->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $job->like_count), $this->locale()->toNumber($job->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $job->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($job->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $job->comment_count), $this->locale()->toNumber($job->comment_count))?>"><i class="fa fa-comment"></i><?php echo $job->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($job->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $job->view_count), $this->locale()->toNumber($job->view_count))?>"><i class="fa fa-eye"></i><?php echo $job->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($job->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $job->favourite_count), $this->locale()->toNumber($job->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $job->favourite_count; ?></span>
							<?php } ?>
							<?php if(isset($this->ratingActive) && isset($job->rating) && $job->rating > 0 ): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($job->rating,1)), $this->locale()->toNumber(round($job->rating,1)))?>">
								<i class="fa fa-star"></i><?php echo round($job->rating,1).'/5';?>
								</span>
							<?php endif; ?>
						</div>
					<?php if(isset($this->readmoreActive)){ ?>
						<div class="sesjob_grid_read_btn"><a href="<?php echo $job->getHref();?>" class="sesjob_animation"><?php echo $this->translate('Read More '); ?></a></div>
					<?php } ?>
					</div>
					</div>
					</div>
				</li>
			<?php endforeach;?>
			<?php  if(  count($this->paginator) == 0){  ?>
				<div class="tip">
					<span>
						<?php echo $this->translate("No job in this  category."); ?>
						<?php if (!$this->can_edit):?>
							<?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sesjob_general").'">', '</a>'); ?>
						<?php endif; ?>
					</span>
				</div>
			<?php } ?>    
			<?php if($this->loadOptionData == 'pagging'){ ?>
				<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesjob"),array('identityWidget'=>$randonNumber)); ?>
			<?php } ?>
	<?php if(!$this->is_ajax){ ?> 
	</ul>
	<?php } ;?>
	<?php endif;?>
	<?php if(!$this->is_ajax){ ?>
 </div>
<?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
  <script type="application/javascript">
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
	 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesjob/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
      'url': en4.core.baseUrl + "widget/index/mod/sesjob/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
	var objectClass = sesJqueryObject('.sesjob_cat_job_list_info');
	for(i=0;i<objectClass.length;i++){
			sesJqueryObject(objectClass[i]).find('div').find('.sesjob_cat_job_list_content').find('.sesjob_cat_job_list_title').width(sesJqueryObject(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
</script>
