<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $groupNameSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.show.userdetail', 0);?>
<?php  $viewUrl = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.polls.manifest', 'grouppolls'); ?>
<?php $gridclass = $this->gridlist? "sesgrouppoll_twoitems" : ""; ?>
<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgrouppoll/externals/styles/styles.css');?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):
$randonNumber = $this->identityForWidget;
else:
$randonNumber = $this->identity;
endif ?>

<?php if(!$this->is_ajax): ?>
<div class="sesgroup_profile_tab_wrapper sesgroup_profile_poll sesbasic_bxs">
  <div class="sesgroup_profile_content_search sesbasic_clearfix">
    <div class="_input">
      <input placeholder="<?php echo $this->translate('Search'); ?>" type="text" id="poll_text_search" name="poll_text_search" />
    </div>
    <div class="_select">
      <select onchange="pollSearch(this.value);" id="poll_browsebyoptions">
        <option value="creation_date"><?php echo $this->translate("Recently Created"); ?></option>
        <option value="most_liked"><?php echo $this->translate("Most Liked"); ?></option>
        <option value="most_viewed"><?php echo $this->translate("Most Viewed"); ?></option>
        <option value="most_commented"><?php echo $this->translate("Most Commented"); ?></option>
      </select>
    </div>
   <?php endif ?>
  <?php if($this->allowPoll && $this->canUpload && !$this->is_ajax): ?>
		<div class="_addbtn">
			<a class="sesbasic_button sesbasic_icon_add sesgroup_cbtn" href="<?php echo $this->url(array('module' => 'sesgrouppoll', 'action'=>'create','group_id'=>$this->group_id), 'sesgrouppoll_general', true); ?>">
				<?php echo $this->translate('Post New Poll'); ?>
			</a>
		</div>
  <?php endif ?>
  <?php if(!$this->is_ajax): ?>
  </div>
   <?php endif ?>

<?php if( 0 == count($this->paginator) ): ?>
<div class="tip">
    <span>
      <?php echo $this->translate('There are no polls yet.') ?>
      <?php if( $this->canCreate): ?>
      <?php echo $this->translate('Why don\'t you %1$screate one%2$s?',
          '<a href="'.$this->url(array('action' => 'create'), 'sesgrouppoll_general').'">', '</a>') ?>
      <?php endif; ?>
    </span>
</div>

<?php else: // $this->polls is NOT empty ?>
<?php if(!$this->is_ajax): ?>
	<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" style="position: relative;" class="sesbasic_clearfix sesbasic_bxs clear">
  <ul class="sesgrouppoll_poll_listing sesbasic_clearfix <?php echo $gridclass; ?>  clear" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
 <?php endif ?>
  <?php foreach ($this->paginator as $poll): ?>
  <li id="sesgrouppoll-item-<?php echo $poll->poll_id ?>">
    <?php echo $this->htmlLink($poll->getHref(),$this->itemPhoto($poll->getOwner(), 'thumb.icon', $poll->getOwner()->getTitle()),array('class' => 'polls_browse_photo') ) ?>
     <div class="sesgrouppoll_browse_info">
      <h3 class="sesgrouppoll_browse_info_title">
		  <?php if((in_array("title", $this->show_criteria))): ?>
		  <?php if(strlen($poll->getTitle()) > $this->title_truncation):?>
		  <?php $title = mb_substr($poll->getTitle(),0,$this->title_truncation).'...';?>
		  <?php else:?>
		  <?php $title = $poll->getTitle();?>
		  <?php endif; ?>
		  <?php echo $this->htmlLink($poll->getHref(), $title) ?>
		  <?php endif; ?>
      </h3>
<?php $groupItem = Engine_Api::_()->getItem('sesgroup_group',$poll->group_id); ?>
		<?php if((in_array("by", $this->show_criteria)) && (in_array("in", $this->show_criteria))): ?>
			<?php if($groupNameSetting): ?>
				<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('Posted by %s in %s ', $this->htmlLink($poll->getOwner(), $poll->getOwner()->getTitle()),$this->htmlLink($groupItem->getHref(), $groupItem->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php else: ?>
				<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('in %s ',$this->htmlLink($groupItem->getHref(), $groupItem->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php endif;  ?>
		<?php elseif((in_array("by", $this->show_criteria)) && !(in_array("in", $this->show_criteria))): ?>
			<?php if($pageNameSetting): ?>
				<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('Posted by %s',$this->htmlLink($poll->getOwner(), $poll->getOwner()->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php endif; ?>
		<?php elseif(!(in_array("by", $this->show_criteria)) && (in_array("in", $this->show_criteria))): ?>
			<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
			  <?php echo $this->translate('in %s', $this->htmlLink($groupItem->getHref(), $groupItem->getTitle())) ?>
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
					<div class="sesgrouppoll_browse_info_desc sesbasic_text_light">
						<?php echo $description; ?>
					</div>
				<?php endif; ?>	
			<?php endif; ?>
		<?php endif; ?>
		
		<!-- polls like favourite -->
    <div class="sesgrouppoll_stats">
		<div class="_btnsleft">
		  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
		  <?php $viewerId = $viewer->getIdentity();?>
		  <?php if($viewerId ):?>
			<?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesgrouppoll_poll', $viewer, 'create');?>
			<?php  if($canComment && in_array("likeButton", $this->show_criteria)):?>
			  <?php $likeStatus = Engine_Api::_()->sesgroup()->getLikeStatus($poll->poll_id,'sesgrouppoll_poll'); ?>
			  <a href="javascript:;" data-type="like_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesgrouppoll_like sesgrouppoll_like_<?php echo $poll->poll_id ?> sesgrouppoll_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $poll->like_count;?></span></a>
			<?php endif;?>
			  <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.allow.favourite', 1) && in_array("favouriteButton", $this->show_criteria)):?>
				<?php 	$value['resource_type'] = 'sesgrouppoll_poll';
						$value['resource_id'] = $poll->poll_id;
						$favouriteStatus = Engine_Api::_()->getDbTable('Favourites', 'sesgrouppoll')->isFavourite($value);
				$favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesgrouppoll')->isFavourite(array('resource_id' => $poll->poll_id,'resource_type' => 'sesgrouppoll_poll')); ?>
				<a href="javascript:;" data-type="favourite_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn favrite sesbasic_icon_btn_count sesgrouppoll_fav sesbasic_icon_fav_btn sesgrouppoll_favourite_<?php echo $poll->poll_id ?> sesgrouppoll_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $poll->favourite_count;?></span></a>
			  <?php endif;?>
			<?php endif;?>
		  
		 <!-- polls end  polls like favourite -->
         <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.allow.share', 1);?>
		 <!-- social share -->
             <?php if(in_array("socialSharing", $this->show_criteria) && $shareType):?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $poll, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
             <?php endif;?>
		 <!-- social share end -->
     </div>
     		</div>
        </div>
   </li>
   <?php endforeach;
   if($this->load_content == 'pagging' && $this->show_limited_data == 'no'): ?>
     <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesgrouppoll"),array('identityWidget'=>$randonNumber)); ?>
     <?php endif ?>
 <?php if(!$this->is_ajax): ?>
 </ul>
			<div class="sesbasic_loading_cont_overlay" id="pollwidgetoverlay"></div>
 <?php if($this->load_content != 'pagging' && $this->show_limited_data == 'no'): ?>
   	<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
					<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
				</div> 
   <div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>
   <?php  endif ?>
   </div>
 <?php  endif ?>
 <?php endif;?>
 <?php if(!$this->is_ajax): ?>
 </div>
 <?php  endif ?>
   <script type="text/javascript">

     function paggingNumber<?php echo $randonNumber; ?>(pageNum){
       (new Request.HTML({
         method: 'post',
         'url': en4.core.baseUrl + 'widget/index/mod/sesgrouppoll/name/<?php echo $this->widgetName; ?>',
         'data': {
           format: 'html',
           page: pageNum,
           params :'<?php echo json_encode($this->params); ?>',
           is_ajax : 1,
           identity : '<?php echo $randonNumber; ?>',
           group_id:'<?php echo $this->group_id ?>',
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
         'url': en4.core.baseUrl + 'widget/index/mod/sesgrouppoll/name/<?php echo $this->widgetName; ?>',
         'data': {
           format: 'html',
         params :'<?php echo json_encode($this->params); ?>',
         is_ajax : 1,
         identity : '<?php echo $randonNumber; ?>',
         identityObject : '<?php echo $this->identityObject; ?>',
         group_id:'<?php echo $this->group_id ?>',
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
         'url': en4.core.baseUrl + "widget/index/mod/sesgrouppoll/name/<?php echo $this->widgetName; ?>",
         'data': {
         format: 'html',
         is_ajax : 1,
         identity : '<?php echo $randonNumber; ?>',
         identityObject : '<?php echo $this->identityObject; ?>',
         sort:$('poll_browsebyoptions').value,
         search:$('poll_text_search').value,
         group_id:<?php echo $this->group_id ?>

       },
       onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
         if($('loading_images_browse_<?php echo $randonNumber; ?>'))
           sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
				  document.getElementById('pollwidgetoverlay').style.display = 'none'; 
         if($('loadingimgsesgrouppoll-wrapper'))
           sesJqueryObject('#loadingimgsesgrouppoll-wrapper').hide();
         document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
       }
     }));
       requestViewMore_<?php echo $randonNumber; ?>.send();
       return false;
     }
 </script>
<script>
		var urls = '<?php echo $viewUrl; ?>';
     /* like request */
     sesJqueryObject(document).on('click', '.sesgrouppoll_like', function() {
         var id = sesJqueryObject (this).attr('data-url');
         var thisclass = sesJqueryObject (this);
         sesJqueryObject.ajax({
             url:en4.core.baseUrl+urls+'/poll/like/id/' + id ,
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
     sesJqueryObject(document).on('click', '.sesgrouppoll_fav', function() {
         var id = sesJqueryObject (this).attr('data-url');
         var thisclass = sesJqueryObject (this);
         sesJqueryObject.ajax({
             url:en4.core.baseUrl+urls+'/poll/favourite/id/' + id ,
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

