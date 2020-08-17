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

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>

<?php if(!$this->is_ajax):?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber;?>" class="sesbasic_bxs"> 
		<div id="category-job-widget_<?php echo $randonNumber; ?>" class="sesbasic_clearfix">
<?php endif;?>
  <?php foreach( $this->paginatorCategory as $item): ?>
  	<div class="sesjob_category_job sesbasic_clearfix">
      <div class="sesjob_category_header sesbasic_clearfix">
        <p class="floatL"><a href="<?php echo $item->getBrowseJobHref(); ?>?category_id=<?php echo $item->category_id ?>" title="<?php echo $this->translate($item->category_name); ?>"><?php echo $this->translate($item->category_name); ?></a></p>
				<?php if(isset($this->seemore_text) && $this->seemore_text != ''): ?>
					<span <?php echo $this->allignment_seeall == 'right' ?  'class="floatR"' : ''; ?>><a  class="sesbasic_link_btn" href="<?php echo $item->getBrowseJobHref(); ?>?category_id=<?php echo $item->category_id ?>"><?php $seemoreTranslate = $this->translate($this->seemore_text); ?>
					<?php echo str_replace('[category_name]',$this->translate($item->category_name),$seemoreTranslate); ?></a></span>
				<?php endif;?>
      </div>
      <?php if(isset($this->resultArray['job_data'][$item->category_id])):?>
        <?php $bigBlg = 0;?>
        <?php	foreach($this->resultArray['job_data'][$item->category_id] as $item):?>
            <?php if(!$bigBlg):?>
            <div class="sesjob_category_item_single">
            <div class="sesjob_category_item_single_info">
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel) || isset($this->hotLabelActive)):?>
                <div class="sesjob_list_labels ">
                  <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
                  <p class="sesjob_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                  <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                  <p class="sesjob_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                  <?php if(isset($this->hotLabelActive) && $item->hot == 1):?>
                  <p class="sesjob_label_hot" title="Hot"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
                  <?php endif;?>
                </div>
                <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                <div class="sesjob_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
                <?php endif;?>
                <?php endif;?>
              <div class="sesjob_entry_img">
                <a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl('thumb.main'); ?>" /></a>
                <?php if(isset($this->readmoreActive)):?>
			           <div class="sesjob_list_readmore"><a class="sesjob_animation" href="<?php echo $item->getHref();?>"><?php echo $this->translate('Read More');?></a></div>
		          <?php endif;?>
              </div>
              <div class="sesjob_category_item_single_content">
							<?php if(isset($this->titleActive)): ?>
								<p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle(); ?></a></p>
							<?php endif;?>
              <div class="entry_meta">
                <?php if(isset($this->creationDateActive)):?>
									<div class="entry_meta-date floatL"> <?php $owner = $item->getOwner(); ?>
              <i class="fa fa-user"></i> <?php echo $this->translate('Posted By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?> on <?php echo date('M d, Y',strtotime($item->publish_date));?></div>
                <?php endif;?>
                <div class="entry_meta-comment floatR">
									<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
										<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
									<?php } ?>
									<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
										<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
									<?php } ?>
									<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)) { ?>
										<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
									<?php } ?>
									<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
										<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
									<?php } ?>
									
                </div>
                
              </div>
              </div>
              </div>
            </div>
            <div class="sesjob-category_item_list sesbasic_custom_scroll">
            <?php else:?>
              <div class="sesjob_category_item sesbasic_clearfix">
                <div class="wrapper_list sesbasic_clearfix">
                  <div class="sesjob_entry_img">
                    <a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl('thumb.main'); ?>" /></a>
                  </div>
                  <?php if(isset($this->titleActive)):?>
                    <a href="<?php echo $item->getHref();?>"><p class="title"><?php echo $item->getTitle();?></p></a>          
                  <?php endif;?>

                  <div class="entry_meta">
                    <?php if(isset($this->creationDateActive)):?>
                      <div class="entry_meta-date floatL">
                         <?php $owner = $item->getOwner(); ?>
              <i class="fa fa-user"></i> <?php echo $this->translate('Posted By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?> on <?php echo date('M d, Y',strtotime($item->publish_date));?>
                      </div>
                    <?php endif; ?>
                    <div class="entry_meta-comment floatL">
											<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
												<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
											<?php } ?>
											<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
												<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
											<?php } ?>
											<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)) { ?>
												<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
											<?php } ?>
											<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
												<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
											<?php } ?>
                    </div>
                    <?php if(isset($this->readmoreActive)):?>
                      <div class="sesjob_list_readmore floatR"><a class="sesjob_animation" href="<?php echo $item->getHref();?>"><?php echo $this->translate('Read More');?></a></div>
                    <?php endif;?>
                  </div>
                </div>
                </div>
            <?php endif;?>
          <?php $bigBlg++;?>
        <?php endforeach;?>
        <?php $bigBlg = 0;?>
      <?php endif;?>
      </div>
		</div>
  <?php endforeach;?>
	<?php if($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax):?>
		<div class="tip">
			<span>
				<?php echo $this->translate('Nobody has created an job yet.');?>
				<?php if ($this->can_create):?>
					<?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action' => 'create','module'=>'sesjob'), "sesjob_general",true).'">', '</a>'); ?>
				<?php endif; ?>
			</span>
		</div>
	<?php endif; ?> 
	<?php if($this->loadOptionData == 'pagging'): ?>
		<?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "sesjob"),array('identityWidget'=>$randonNumber)); ?>
	<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
		</div>
	</div>
	<?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
<?php } ?>

<script type="text/javascript">
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
	viewMoreHide_<?php echo $randonNumber; ?>();
	function viewMoreHide_<?php echo $randonNumber; ?>() {
		if ($('view_more_<?php echo $randonNumber; ?>'))
		$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '' )) ?>";
	}
	function viewMore_<?php echo $randonNumber; ?> (){
		document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
		document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
		en4.core.request.send(new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "widget/index/mod/sesjob/name/<?php echo $this->widgetName; ?>",
			'data': {
			format: 'html',
			page: <?php echo $this->page + 1; ?>,    
			params :'<?php echo json_encode($this->params); ?>', 
			is_ajax : 1,
			identity : '<?php echo $randonNumber; ?>',
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('category-job-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('category-job-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
          });
        
			}
		}));
		return false;
	}
	<?php if(!$this->is_ajax){ ?>
		function paggingNumber<?php echo $randonNumber; ?>(pageNum){
			sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
			en4.core.request.send(new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sesjob/name/<?php echo $this->widgetName; ?>",
				'data': {
					format: 'html',
					page: pageNum,    
					params :'<?php echo json_encode($this->params); ?>', 
					is_ajax : 1,
					identity : '<?php echo $randonNumber; ?>',
					type:'<?php echo $this->view_type; ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
					document.getElementById('category-job-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
          });
					dynamicWidth();
				}
			}));
			return false;
		}
	<?php } ?>
</script>
