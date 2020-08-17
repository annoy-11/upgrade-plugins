<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php  $viewUrl = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpolls.poll.manifest', 'pagepolls'); ?>
<?php $gridclass = $this->gridlist? "sesadvpoll_twoitems" : ""; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvpoll/externals/styles/styles.css');?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):
	$randonNumber = $this->identityForWidget;
else:
	$randonNumber = $this->identity;
endif ?>

	<?php if(!$this->is_ajax): ?>
	<div class="sesadvpoll_profile_tab_wrapper sesadvpoll_profile_poll sesbasic_bxs">
		<div class="sespage_profile_content_search sesbasic_clearfix">
  <?php endif ?>
  <?php if(!$this->is_ajax): ?>
		</div>
  <?php endif ?>
	<?php if( 0 == count($this->paginator)): ?>
	<div class="tip">
		<span>
			<?php echo $this->translate('There are no polls yet.') ?>
			<?php if( $this->canCreate): ?>
			<?php echo $this->translate('Why don\'t you %1$screate one%2$s?',
					'<a href="'.$this->url(array('action' => 'create'), 'sesadvpoll_general').'">', '</a>') ?>
			<?php endif; ?>
		</span>
	</div>
	<?php else: // $this->polls is NOT empty ?>
	<?php if(!$this->is_ajax): ?>
		<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" style="position: relative;" class="sesbasic_clearfix sesbasic_bxs clear">
			<ul class="sesadvpoll_poll_listing sesbasic_clearfix <?php echo $gridclass; ?> clear" id="tabbed-widget_<?php 	echo $randonNumber; ?>" style="min-height:50px;">
			<?php endif ?>
				<?php foreach ($this->paginator as $poll): ?>
					<li id="sesadvpoll-item-<?php echo $poll->poll_id ?>" <?php if($this->gridlist) { ?> style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;" <?php } ?>>
						<?php echo $this->htmlLink($poll->getHref(),$this->itemPhoto($poll->getOwner(), 'thumb.icon', $poll->getOwner()->getTitle()),array('class' => 'polls_browse_photo'))?>
						<div class="sesadvpoll_browse_info">
							<h3 class="sesadvpoll_browse_info_title">
								<?php if((in_array("title", $this->show_criteria))): ?>
									<?php if(strlen($poll->getTitle()) > $this->title_truncation):?>
										<?php $title = mb_substr($poll->getTitle(),0,$this->title_truncation).'...';?>
									<?php else:?>
										<?php $title = $poll->getTitle();?>
									<?php endif; ?>
									<?php echo $this->htmlLink($poll->getHref(), $title) ?>
								<?php endif; ?>
							</h3>
							<?php if((in_array("by", $this->show_criteria))): ?>
                <div class="sesadvpolls_browse_info_date sesbasic_text_light">
                  <?php echo $this->translate('Posted by %s ', $this->htmlLink($poll->getOwner(), $poll->getOwner()->getTitle())) ?>
                  <?php echo $this->timestamp($poll->creation_date) ?>
                </div>
							<?php endif; ?>
							<?php $item = $poll; ?>
							<div class="stats sesbasic_text_light">
								<?php if((in_array("view", $this->show_criteria))): ?>
									<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber(	$item->view_count)) ?>">
										<i class="fa fa-eye"></i> <span><?php echo $item->view_count ;?></span>
									</span>
								<?php endif; ?>
								<?php if((in_array("comment", $this->show_criteria))): ?>
									<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber(	$item->view_count)) ?>">
										<i class="fa fa-comment"></i> <span><?php echo $item->comment_count ;?></span>
									</span>
								<?php endif; ?>
								<?php if((in_array("like", $this->show_criteria))): ?>
									<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber(	$item->like_count)) ?>">
										<i class="fa fa-thumbs-up"></i> <span><?php echo $item->like_count ;?></span>
									</span>
								<?php endif; ?>
								<?php if((in_array("favourite", $this->show_criteria))): ?>
									<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber(	$item->favourite_count)) ?>">
										<i class="fa fa-heart"></i> <span><?php echo $item->favourite_count ;?></span>
									</span>
								<?php endif; ?>
								<?php if((in_array("vote", $this->show_criteria))): ?>
									<span title="<?php echo $this->translate(array('%s vote', '%s votes', $item->vote_count), $this->locale()->toNumber(	$item->vote_count)) ?>">
										<i class="fa fa-hand-o-up"></i> <span><?php echo $item->vote_count ;?></span>
									</span>
								<?php endif; ?>
							</div>
							<?php if((in_array("description", $this->show_criteria))): ?>
								<?php if (!empty($poll->description)): ?>
									<?php if(strlen($poll->description) > $this->description_truncation):?>
										<?php $description = mb_substr($poll->description,0,$this->description_truncation).'...';?>
									<?php else:?>
										<?php $description = $poll->description;?>
									<?php endif; ?>
									<?php if($description): ?>
										<div class="sesadvpoll_browse_info_desc sesbasic_text_light">
											<?php echo $description; ?>
										</div>
									<?php endif; ?>	
								<?php endif; ?>
							<?php endif; ?>
							<!-- polls like favourite -->
							<div class="sesadvpoll_stats">
								<div class="_btnsleft">
									<?php $viewer = Engine_Api::_()->user()->getViewer();?>
									<?php $viewerId = $viewer->getIdentity();?>
									<?php if($viewerId ):?>
										<?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesadvpoll_poll', $viewer, 'create');?>
										<?php  if($canComment && in_array("likeButton", $this->show_criteria)):?>
											<?php $likeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($poll->poll_id,'sesadvpoll_poll'); ?>
											<a href="javascript:;" data-type="like_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesadvpoll_like sesadvpoll_like_<?php echo $poll->poll_id ?> sesadvpoll_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $poll->like_count;?></span></a>
										<?php endif;?>
										<?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.allow.favourite', 1) && in_array("favouriteButton", $this->show_criteria)):?>
											<?php 	$value['resource_type'] = 'sesadvpoll_poll';
											$value['resource_id'] = $poll->poll_id;
											$favouriteStatus = Engine_Api::_()->getDbTable('Favourites', 'sesadvpoll')->isFavourite($value);
											$favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesadvpoll')->isFavourite(array('resource_id' => $poll->poll_id,'resource_type' => 'sesadvpoll_poll')); ?>
											<a href="javascript:;" data-type="favourite_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn favrite sesbasic_icon_btn_count sesadvpoll_fav sesbasic_icon_fav_btn sesadvpoll_favourite_<?php echo $poll->poll_id ?> sesadvpoll_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $poll->favourite_count;?></span></a>
										<?php endif;?>
									<?php endif;?>
									<!-- polls end  polls like favourite -->
									<?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.allow.share', 1);?>
									<!-- social share -->
                  <?php if(in_array('siteshare', $this->show_criteria) && in_array($shareType, array('1', '2'))) { ?>
                    <a href="activity/index/share/type/sesadvpoll_poll/id/<?php echo $poll->getIdentity();?>/format/smoothbox" class="sesbasic_icon_btn smoothbox" title="Share"><i class="fa fa-share"></i></a>
                  <?php } ?>
									<?php if(in_array("socialSharing", $this->show_criteria) && $shareType == 2):?>
										<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $poll, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
									<?php endif;?>
									<!-- social share end -->
								</div>
							</div>
						</div>
					</li>
				<?php endforeach;
				if($this->load_content == 'pagging' && $this->show_limited_data == 'no'): ?>
					<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesadvpoll"),array('identityWidget'=>$randonNumber)); ?>
				<?php endif ?>
			<?php if(!$this->is_ajax): ?>
			</ul>
			<div class="sesbasic_loading_cont_overlay" id="pollwidgetoverlay"></div>
			<?php if($this->load_content != 'pagging' && $this->show_limited_data == 'no'): ?>		
				<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
					<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
				</div>  
				<div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
			<?php  endif ?>
		</div>
		<?php  endif ?>
	<?php endif;?>
 <?php if(!$this->is_ajax): ?>
	</div>
 <?php endif ?>
   <script type="text/javascript">
		
     function paggingNumber<?php echo $randonNumber; ?>(pageNum){
       (new Request.HTML({
         method: 'post',
         'url': en4.core.baseUrl + 'widget/index/mod/sesadvpoll/name/profile-polls',
         'data': {
           format: 'html',
           page: pageNum,
           params :'<?php echo json_encode($this->params); ?>',
           is_ajax : 1,
           identity : '<?php echo $randonNumber; ?>',
           user_id:'<?php echo $this->user_id ?>',
           identityObject : '<?php echo $this->identityObject; ?>',
           limit_data:'<?php echo $this->limit_data; ?>',
           pagging:'<?php echo $this->load_content; ?>'
         },
         onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
           sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
           document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
         }
       })).send();
       return false;
     }
     en4.core.runonce.add(function() {
       $('poll_text_search').addEvent('keypress', function(e) {
         if( e.key != 'enter' ) return;
         pollSearch();
       })
     });
     <?php if($this->load_content != 'pagging'){ ?>
    viewMoreHide_<?php echo $randonNumber; ?>();
   function viewMoreHide_<?php echo $randonNumber; ?>() {
     if ($('view_more_<?php echo $randonNumber; ?>'))

       $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
   }
     <?php } ?>
     <?php if($this->load_content == 'auto_load'){ ?>
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
     function viewMore_<?php echo $randonNumber; ?> (){
       document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
       document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';

       var valueTab ;
       sesJqueryObject('#tab-widget_<?php echo $randonNumber; ?> > li').each(function(index){
         if(sesJqueryObject(this).hasClass('sesbasic_tab_selected')){
           valueTab = sesJqueryObject(this).find('a').attr('data-src');
         }
       });
       requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
         method: 'post',
         'url': en4.core.baseUrl + 'widget/index/mod/sesadvpoll/name/profile-polls',
         'data': {
           format: 'html',
         params :'<?php echo json_encode($this->params); ?>',
         is_ajax : 1,
         identity : '<?php echo $randonNumber; ?>',
         identityObject : '<?php echo $this->identityObject; ?>',
         user_id:'<?php echo $this->user_id ?>',
         page:'<?php echo $this->page; ?>',
         limit_data:'<?php echo $this->limit_data; ?>',
         pagging:'<?php echo $this->load_content; ?>'
     },
       onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
         document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML  + responseHTML;
         document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
       }
     })).send();
       return false;
     }
     function pollSearch() {
			 document.getElementById('pollwidgetoverlay').style.display = 'block';   
       var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
       requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
         method: 'post',
         'url': en4.core.baseUrl + "widget/index/mod/sesadvpoll/name/profile-polls",
         'data': {
         format: 'html',
         is_ajax : 1,
         identity : '<?php echo $randonNumber; ?>',
         identityObject : '<?php echo $this->identityObject; ?>',
         sort:$('poll_browsebyoptions').value,
         search:$('poll_text_search').value,
         user_id:<?php echo $this->user_id ?>

       },
       onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
         if($('loading_images_browse_<?php echo $randonNumber; ?>'))
           sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
				  document.getElementById('pollwidgetoverlay').style.display = 'none'; 
         if($('loadingimgsesadvpoll-wrapper'))
           sesJqueryObject('#loadingimgsesadvpoll-wrapper').hide();
         document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
       }
     }));
       requestViewMore_<?php echo $randonNumber; ?>.send();
       return false;
     }
   </script>

<script>
		 /* like request */
     sesJqueryObject(document).on('click', '.sesadvpoll_like', function() {
			
         var id = sesJqueryObject (this).attr('data-url');
         var thisclass = sesJqueryObject (this);
         sesJqueryObject.ajax({
             url:en4.core.baseUrl+'sesadvpoll/poll/like/id/' + id ,
             type: "POST",
             contentType:false,
             processData: false,
             success: function(response) {
                 var data = JSON.parse(response);
                 var span = sesJqueryObject(thisclass).find( "span" );
                 if(data.status){
                     if(data.condition == 'increment'){
                         sesJqueryObject(thisclass).addClass("button_active");
                         sesJqueryObject(span).html(data.count);
                     }else{
                         sesJqueryObject(thisclass).removeClass("button_active");
                         sesJqueryObject(span).html(data.count);
                     }
                 }
             }
         });
     });
     /* like request end */
     /* favourite request  */
     sesJqueryObject(document).on('click', '.sesadvpoll_fav', function() {
         var id = sesJqueryObject (this).attr('data-url');
         var thisclass = sesJqueryObject (this);
         sesJqueryObject.ajax({
             url:en4.core.baseUrl+'sesadvpoll/poll/favourite/id/' + id ,
             type: "POST",
             contentType:false,
             processData: false,
             success: function(response) {
                 var data = JSON.parse(response);
                 var span = sesJqueryObject(thisclass).find( "span" );
                 if(data.status){
                     if(data.condition == 'increment'){
                         sesJqueryObject(thisclass).addClass("button_active");
                         sesJqueryObject(span).html(data.count);
                     }else{
                         sesJqueryObject(thisclass).removeClass("button_active");
                         sesJqueryObject(span).html(data.count);
                     }
                 }
             }
         });
     });
     /* favourite request end */
</script>
