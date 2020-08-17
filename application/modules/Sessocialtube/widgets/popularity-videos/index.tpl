<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideo
 * @package    Sesvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessocialtube/externals/styles/styles.css'); ?>
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)){
				$randonNumber = $this->identityForWidget;
      }else{
      	$randonNumber = $this->identity; 
      }
?>
<?php if(!$this->is_ajax){ ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
  <?php if($this->backgroundimage): ?>
    <div class="socialtube_videos_wrapper" style="background-image:url(<?php echo $this->baseUrl() . '/' . $this->backgroundimage ?>);">
  <?php else: ?>
      <div class="socialtube_videos_wrapper" style="background-image:url(application/modules/Sessocialtube/externals/images/background-image.jpg);">
  <?php endif; ?>
    
	
  <h3><?php echo $this->translate($this->textVideo);?></h3>
  <div class="socialtube_videos_content">
    <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">    
       <ul class="sesvideo_cat_video_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>">
    <?php } ?>
        <?php //rating show code
          $allowRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('video.video.rating',1);
          $allowShowPreviousRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('video.ratevideo.show',1);
          if($allowRating == 0){
            if($allowShowPreviousRating == 0)
              $ratingShow = false;
             else
              $ratingShow = true;
          }else
            $ratingShow = true;
         ?>
        <?php $totalCount = $this->paginator->getCurrentItemCount(); 
              $allowedLimit = 5;
              $counter =1;
              $break = false;
              $type = 1;
              $close = false;
        ?>
        <?php foreach($this->paginator as $key=>$video){  ?>
          <?php
            $href = $video->getHref();
            $imageURL = $video->getPhotoUrl();
          ?>
          <?php if(($this->paginator->getCurrentPageNumber() == 1 || $this->loadOptionData == 'pagging') && !$break && $totalCount >= $allowedLimit ){ ?>
          <?php if(($counter-1)%5 == 0 ){ ?>
            <li class="sesbasic_clearfix sesbasic_bxs clear">
              <div class="sesvideo_videolist_row clear sesbasic_clearfix">
          <?php } ?>
                <?php if($type == 1){ ?>
                   <?php if(!$close){  ?>
                   		<div class="socialtube_videolist_column_small floatL"> <?php } ?>
                        <div class="socialtube_video_list">
                      <div class="socialtube_video_list_thumb">
                        <a href="<?php echo $href; ?>" data-url = "<?php echo $video->getType() ?>" class="socialtube_video_list_thumb_img">
                          <img class="sesvideo_animation" src="<?php echo $imageURL; ?>" alt="" />
                          <div class="socialtube_video_list_info">
                            <div class="socialtube_video_list_cont">
                            <?php if(isset($this->titleActive)){ ?>
                              <div class="socialtube_video_list_cont_title">
                                <?php echo $video->getTitle(); ?>
                              </div>
                              <?php } ?>
                              <?php if(isset($this->byActive)){ ?>
                              <div class="socialtube_video_list_cont_stats">
                                <?php
                                  $owner = $video->getOwner();
                                  echo $this->translate('Posted by %1$s', $owner->getTitle());
                                ?>
                              </div>
                              <?php } ?>
                              <div class="socialtube_video_list_cont_stats">
                                <?php if(isset($this->likeActive) && isset($video->like_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s like', '%s likes', $video->like_count), $this->locale()->toNumber($video->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $video->like_count; ?></span>
                                <?php } ?>
                                <?php if(isset($this->commentActive) && isset($video->comment_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s comment', '%s comments', $video->comment_count), $this->locale()->toNumber($video->comment_count))?>"><i class="fa fa-comment"></i><?php echo $video->comment_count;?></span>
                                <?php } ?>
                                <?php if(isset($this->viewActive) && isset($video->view_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s view', '%s views', $video->view_count), $this->locale()->toNumber($video->view_count))?>"><i class="fa fa-eye"></i><?php echo $video->view_count; ?></span>
                                <?php } ?>
                                <?php if(isset($this->favouriteActive) && isset($video->favourite_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $video->favourite_count), $this->locale()->toNumber($video->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $video->favourite_count; ?></span>
                                <?php } ?>
                                <?php if(isset($this->ratingActive) && $ratingShow && isset($video->rating) && $video->rating > 0 ): ?>
                                <span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($video->rating,1)), $this->locale()->toNumber(round($video->rating,1)))?>">
                                 <i class="fa fa-star"></i><?php echo round($video->rating,1).'/5';?>
                                </span>
                              <?php endif; ?>
                              </div>
                            </div>
                          </div>
                        </a>
                    </div>
                    </div>
                   <?php if($close){ $close = false;  ?></div> <?php }else{ $close = true;  }   ?>
                <?php } ?>
                <?php if($type == 2){ ?>
                 <div class="socialtube_videolist_column_big floatL">
                    <div class="socialtube_video_list">
                      <div class="socialtube_video_list_thumb">
                        <a href="<?php echo $href; ?>" data-url = "<?php echo $video->getType() ?>" class="socialtube_video_list_thumb_img">
                          <img class="sesvideo_animation" src="<?php echo $imageURL; ?>" alt="" />
                          <div class="socialtube_video_list_info">
                            <div class="socialtube_video_list_cont">
                            <?php if(isset($this->titleActive)){ ?>
                              <div class="socialtube_video_list_cont_title">
                                <?php echo $video->getTitle(); ?>
                              </div>
                              <?php } ?>
                              <?php if(isset($this->byActive)){ ?>
                              <div class="socialtube_video_list_cont_stats">
                                <?php
                                  $owner = $video->getOwner();
                                  echo $this->translate('Posted by %1$s', $owner->getTitle());
                                ?>
                              </div>
                              <?php } ?>
                              <div class="socialtube_video_list_cont_stats">
                                <?php if(isset($this->likeActive) && isset($video->like_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s like', '%s likes', $video->like_count), $this->locale()->toNumber($video->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $video->like_count; ?></span>
                                <?php } ?>
                                <?php if(isset($this->commentActive) && isset($video->comment_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s comment', '%s comments', $video->comment_count), $this->locale()->toNumber($video->comment_count))?>"><i class="fa fa-comment"></i><?php echo $video->comment_count;?></span>
                                <?php } ?>
                                <?php if(isset($this->viewActive) && isset($video->view_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s view', '%s views', $video->view_count), $this->locale()->toNumber($video->view_count))?>"><i class="fa fa-eye"></i><?php echo $video->view_count; ?></span>
                                <?php } ?>
                                <?php if(isset($this->favouriteActive) && isset($video->favourite_count)) { ?>
                                  <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $video->favourite_count), $this->locale()->toNumber($video->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $video->favourite_count; ?></span>
                                <?php } ?>
                                <?php if(isset($this->ratingActive) && $ratingShow && isset($video->rating) && $video->rating > 0 ): ?>
                                <span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($video->rating,1)), $this->locale()->toNumber(round($video->rating,1)))?>">
                                 <i class="fa fa-star"></i><?php echo round($video->rating,1).'/5';?>
                                </span>
                              <?php endif; ?>
                              </div>
                            </div>
                          </div>
                        </a>
                    </div>
                    </div>
                </div>
                <?php } ?>
         <?php if(($counter)%5 == 0){ ?>
               </div>
             </li>
        <?php } ?>
          <?php
            if($counter == 2 || $counter == 9 || $counter == 10) $type = 2;
            else $type = 1;
            ?>
          <?php if($counter%5 == 0){
                  $allowedLimit = $allowedLimit + 5;
                }
                 if($counter%15 == 0){
                  $break = true;
                  }
          ?>
          <?php }else{ ?>
                   <li class="socialtube_video_list socialtube_video_list_min">
                    <div class="socialtube_video_list_thumb">
                      <a href="<?php echo $href; ?>" data-url = "<?php echo $video->getType() ?>" class="socialtube_video_list_thumb_img">
                        <img class="sesvideo_animation" src="<?php echo $imageURL; ?>" alt="" />
                        <div class="socialtube_video_list_info">
                          <div class="socialtube_video_list_cont">
                          <?php if(isset($this->titleActive)){ ?>
                            <div class="socialtube_video_list_cont_title">
                              <?php echo $video->getTitle(); ?>
                            </div>
                            <?php } ?>
                            <?php if(isset($this->byActive)){ ?>
                            <div class="socialtube_video_list_cont_stats">
                              <?php
                                $owner = $video->getOwner();
                                echo $this->translate('Posted by %1$s', $owner->getTitle());
                              ?>
                            </div>
                            <?php } ?>
                            <div class="socialtube_video_list_cont_stats">
                              <?php if(isset($this->likeActive) && isset($video->like_count)) { ?>
                                <span title="<?php echo $this->translate(array('%s like', '%s likes', $video->like_count), $this->locale()->toNumber($video->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $video->like_count; ?></span>
                              <?php } ?>
                              <?php if(isset($this->commentActive) && isset($video->comment_count)) { ?>
                                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $video->comment_count), $this->locale()->toNumber($video->comment_count))?>"><i class="fa fa-comment"></i><?php echo $video->comment_count;?></span>
                              <?php } ?>
                              <?php if(isset($this->viewActive) && isset($video->view_count)) { ?>
                                <span title="<?php echo $this->translate(array('%s view', '%s views', $video->view_count), $this->locale()->toNumber($video->view_count))?>"><i class="fa fa-eye"></i><?php echo $video->view_count; ?></span>
                              <?php } ?>
                              <?php if(isset($this->favouriteActive) && isset($video->favourite_count)) { ?>
                                <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $video->favourite_count), $this->locale()->toNumber($video->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $video->favourite_count; ?></span>
                              <?php } ?>
                              <?php if(isset($this->ratingActive) && $ratingShow && isset($video->rating) && $video->rating > 0 ): ?>
                              <span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($video->rating,1)), $this->locale()->toNumber(round($video->rating,1)))?>">
                               <i class="fa fa-star"></i><?php echo round($video->rating,1).'/5';?>
                              </span>
                            <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </a>
                  </div>
          		</li>
            <?php }
           $counter ++;
        } ?>   
        <?php  if(  count($this->paginator) == 0){  ?>
          <div class="tip">
            <span>
              <?php echo $this->translate("No video in this  category."); ?>
              <?php if (!$this->can_edit):?>
                        <?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sesvideo_general").'">', '</a>'); ?>
              <?php endif; ?>
            </span>
          </div>
        <?php } ?>    
        <?php
              if($this->loadOptionData == 'pagging'){ ?>
         <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesvideo"),array('identityWidget'=>$randonNumber)); ?>
     <?php } ?>
    <?php if(!$this->is_ajax){ ?> 
     </ul>
     </div>
   		<?php if($this->loadOptionData != 'pagging' && $this->loadOptionData != 'fixedbutton'){ ?>
        
        <div id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" class="socialtube_video_list_more"> <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?></div>
        
        <div id="loading_image_<?php echo $randonNumber; ?>" class="socialtube_video_list_loading" style="display: none;">
        	<span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
        </div>
    	<?php } ?>
  	</div>
  </div>
  <script type="application/javascript">
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
	 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sessocialtube/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
      'url': en4.core.baseUrl + "widget/index/mod/sessocialtube/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
	var objectClass = sesJqueryObject('.sesvideo_cat_video_list_info');
	for(i=0;i<objectClass.length;i++){
			sesJqueryObject(objectClass[i]).find('div').find('.sesvideo_cat_video_list_content').find('.sesvideo_cat_video_list_title').width(sesJqueryObject(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
</script>