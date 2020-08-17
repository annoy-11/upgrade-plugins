<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: editphotos.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/style_album.css'); ?>
<?php $randonNumber = 'sesPag'; ?>
<?php if(!$this->is_ajax){ ?>
<div class="layout_middle">

  <div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
    <div class="_mainhumb"><a href="<?php echo $this->sespage->getHref(); ?>"><img src="<?php echo $this->sespage->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
    <div class="_maincont">
      <a href="<?php echo $this->sespage->getHref(); ?>"><?php echo $this->sespage->getTitle(); ?></a>
      <?php if($this->album) { ?>
        <span class="sesbasic_text_light">&raquo;</span>
        <a href="<?php echo $this->album->getHref(); ?>"><?php echo $this->translate("Photo Albums"); ?></a>
        <span class="sesbasic_text_light">&raquo;</span>
        <a href="<?php echo $this->album->getHref(); ?>"><?php echo $this->album->getTitle(); ?></a>
      <?php } ?>
      <span class="sesbasic_text_light">&raquo;</span>
      <span><?php echo $this->translate("Manage Photos"); ?></span>
    </div>
  </div>

  <div class="sesbasic_clearfix">
    <h3>
      <?php echo $this->htmlLink(Engine_Api::_()->sespage()->getHref($this->album->getIdentity()), $this->album->getTitle()) ?>
      (<?php echo $this->translate(array('%s photo', '%s photos', $this->album->count()),$this->locale()->toNumber($this->album->count())) ?>)
    </h3>
  <?php if( $this->paginator->count() > 0 ): ?>
  <?php endif; ?>
  <div class="sespage_manage_photos_wrapper sesbasic_clearfix sesbasic_bxs" id="scrollHeightDivSes_<?php echo $randonNumber; ?>">
  <form action="<?php echo $this->escape($this->form->getAction()) ?>" name="editPhotos" method="<?php echo $this->escape($this->form->getMethod()) ?>">
    <?php echo $this->form->album_id; ?>
    <ul class='sespage_manage_photos' id="tabbed-widget_<?php echo $randonNumber; ?>">
  <?php } ?>
      <?php foreach( $this->paginator as $photo ): ?>
        <li class="sespage_manage_photos_list" id="thumbs-photo-<?php echo $photo->photo_id ?>">
          <div class="sesbasic_clearfix sesbm">
            <div class="sespage_manage_photos_list_photo">
              <?php $url = $photo->getPhotoUrl('thumb.normalmain'); ?>
              <span style="background-image:url(<?php echo $url ?>);"></span>
            </div>
            <div class="sespage_manage_photos_list_info">
              <?php
                $key = $photo->getGuid();
                echo $this->form->getSubForm($key)->render($this);
              ?>
              <div class="sespages_editphotos_cover">
                <input type="radio" name="cover" id="album_photo_<?php echo $photo->getIdentity() ?>_cover" value="<?php echo $photo->getIdentity() ?>" <?php if( $this->album->photo_id == $photo->getIdentity() ): ?> checked="checked"<?php endif; ?> />
                <label for="album_photo_<?php echo $photo->getIdentity() ?>_cover"><?php echo $this->translate('Main Photo');?></label>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
  <?php if(!$this->is_ajax){ ?>
    </ul>  
     <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
    <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?> </div>
    <div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div> 
    
    <?php echo $this->form->submit->render(); ?>
  </form>
    </div>
  <?php if( $this->paginator->count() > 0 ): ?>
    <br />
    <?php //echo $this->paginationControl($this->paginator); ?>
  <?php endif; ?>
    </div>
  </div>
</div>
<?php } ?>
<script type="text/javascript">
<?php if(!$this->is_ajax){ ?>
	window.ivnGetSetValue = function(obj,context){
  f = obj.form
  o = document.getElementById('ivnData')

  if(f.use_try.checked){
    /* controlled blow up if error occurs */
    try{
      remote_form = parent.document.forms["i"];
      ivnHandleRemoteFormExchange(f,o,context);
    } catch(e){ var ee = e.message || 0; console.log('Error: \n\n'+e+'\n'+ee); }
  }
  else{
    /* don't control the blow up if error occurs... let it bubble to the JS console */
    remote_form = parent.document.forms["i"];
    ivnHandleRemoteFormExchange(f,o,context);
  }
}
	// auto load function
	window.addEvent('load', function() {
		 sesJqueryObject(window).scroll( function() {		 
		 var containerId = '#scrollHeightDivSes_<?php echo $randonNumber;?>';
				if(typeof sesJqueryObject(containerId).offset() != 'undefined') {
					var hT = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').offset().top,
					hH = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').outerHeight(),
					wH = sesJqueryObject(window).height(),
					wS = sesJqueryObject(this).scrollTop();
					if ((wS + 30) > (hT + hH - wH) && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block') {
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
					}
				}
	});
	});
<?php } ?>
	viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  function viewMore_<?php echo $randonNumber; ?> (){
    var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "albums/editphotos/<?php echo $this->album_id; ?>",
      'data': {
        format: 'html',
        page: <?php echo $this->page + 1; ?>,    
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
         sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').append(responseHTML);
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  }
	/*end code for auto load*/
</script>