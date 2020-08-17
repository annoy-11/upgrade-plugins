<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Booking/externals/styles/styles.css'); ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();
$viewerId = $viewer->getIdentity();
$levelId = ($viewerId) ? $viewer->level_id : Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id; 
?>
<div class="sesapmt_browse_services sesbasic_bxs sesbasic_clearfix">
	<div class="sesapmt_browse_services_inner">
    <div id="ajaxdata" class="sesapmt_service_list">
    	<?php if(count($this->paginator)){ ?>
      <?php foreach ($this->paginator as $item): ?>  
        <div class="sesapmt_service_list_item" style="width:<?php echo $this->width.'px'; ?>;">
        	<article>
           <div class="item_thumb" style="background-image:url(<?php  if($this->serviceimage) { $img_path = Engine_Api::_()->storage()->get($item->file_id, '')->getPhotoUrl(); echo $img_path; } ?>);height:<?php echo $this->height.'px'; ?>">
                <?php if($levelId!=5) {?>
               <div class="sesapmt_services_list_buttons" id="<?php echo $item->service_id; ?>">
                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('booking.prof.like', 1)){ if($this->like) { ?>
                  <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn" onclick="like(<?php echo $item->service_id; ?>)"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                  <?php } } ?>
                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('booking.prof.fav', 1)){ if($this->favourite) { ?>
                  <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn" onclick="favourite(<?php echo $item->service_id; ?>)"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                  <?php } } ?>
                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('booking.prof.report', 1)){ ?>
                  <!--a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_report_btn"><i class="fa fa-flag"></i><span>0</span></a-->
                  <?php } ?>
                </div>
                <?php } ?>
           	<a href="<?php echo $item->getHref(); ?>" class="item_thumb_link"></a>
           </div>
           <div class="info">
              <p class="_title">
                <?php if($this->servicename) { if(strlen($item->name)>$this->servicenamelimit) echo mb_substr($item->name,0,($this->servicenamelimit)).'...'; else echo $item->name; } ?>
              </p>
              <p class="_price">
                 <span><?php if($this->price) { echo Engine_Api::_()->booking()->getCurrencyPrice($item->price); ?></span> / <?php } if($this->minute) { echo $item->duration." ".(($item->timelimit=="h")?"Hour.":"Minutes.");} ?>
              </p>
                <p class="_stats sesbasic_text_light">
                    <?php if($this->likecount) { ?><span title="<?php echo $item->like_count; ?> likes"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span><?php } ?>
                    <?php if($this->favouritecount) { ?><span title="<?php echo $item->favourite_count; ?> favourites"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span><?php } ?>
                </p>
               <p class="_book">
                <?php if($this->bookbutton) { ?>  <a href="<?php echo $item->getHref(); ?>">View</a> <?php } ?>
              </p>
           </div>
        	</article>   
        </div>
        <?php endforeach; ?>
        <?php } else { ?>
          <?php if($this->ifNoProfessioanl) { ?><div class="tip"><span>There are currently no services to show.</span></div><?php } ?>
        <?php } ?>
  	</div>
  </div>
</div>
<script type="text/javascript">
    function like(service_id){
        (new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + 'booking/ajax/servicelike',
          'data': {
            format: 'html',
            service_id: service_id
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
              sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_like_btn').find('span').html(responseHTML);
              if(sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_like_btn').hasClass("button_active"))
                  sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_like_btn').removeClass("button_active");
              else
                  sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_like_btn').addClass("button_active");
            return true;
            }
          })).send();
    }
</script> 
<script type="text/javascript">
    function favourite(service_id){
        (new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + 'booking/ajax/servicefavourite',
          'data': {
            format: 'html',
            service_id : service_id
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
              sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_fav_btn').find('span').html(responseHTML);
              if(sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_fav_btn').hasClass("button_active"))
                  sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_fav_btn').removeClass("button_active");
              else
                  sesJqueryObject('#'+service_id+'').find('.sesbasic_icon_fav_btn').addClass("button_active");
            return true;
            }
          })).send();
    }
</script> 