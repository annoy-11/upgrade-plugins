<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (isset($this->identityForWidget) && !empty($this->identityForWidget)): ?>
	<?php $randonNumber = $this->identityForWidget; ?>
<?php else: ?>
	<?php $randonNumber = $this->identity; ?>
<?php endif; ?>
<?php if (!$this->is_ajax) { ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
  <?php if ($this->allowedCreate && $this->cancreate && $this->viewer()->getIdentity() && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.allow.signature', 1) && !$this->isSignature): ?>
        <div class="sesbasic_profile_tabs_top sesbasic_clearfix">
          <?php echo $this->htmlLink(array('route' => 'epetitionsignature_extended', 'action' => 'create', 'epetition_id' => $this->subject()->getIdentity()), $this->translate('Write a Signature'), array('class' => 'sesbasic_button fa fa-plus')); ?>
        </div>
  <?php endif; ?>
<?php } ?>

<?php if ($this->paginator->getTotalItemCount() > 0): ?>
  <?php if (!$this->is_ajax) { ?>
        <div class="epetition_profile_signatures_filters sesbasic_bxs sesbasic_clearfix">
          <?php //echo $this->content()->renderWidget('epetition.browse-signature-search',array('signature_search'=>1,'signature_stars'=>1,'signatureRecommended'=>1,'signature_title'=>0,'view_type'=>'horizontal','isWidget'=>true,'epetition_id'=>$this->subject->getIdentity(),'widgetIdentity'=>$this->identity)); ?>
        </div>
        <ul class="epetition_signature_listing sesbasic_clearfix sesbasic_bxs" id="epetition_signature_listing">
  <?php } ?>
  <?php $viewer = Engine_Api::_()->user()->getViewer();
  $current_viwer = $viewer->getIdentity(); ?>
  <?php foreach ($this->paginator as $item): ?>
        <li class="epetition_owner_signature sesbasic_clearfix" id="sign<?php echo $item->signature_id;  ?>">
            <div class='epetition_signature_support_statement sesbasic_text_light'>
              <?php $user = Engine_Api::_()->getItem('user', $item->owner_id); ?>
              <?php echo (!empty($item->first_name) && !empty($item->last_name)) ? ($item->first_name . " " . $item->last_name) : (!empty($item->owner_id) ? $this->htmlLink($user->getHref(), $user->getTitle()) : " "); ?>
                - <i class="fa fa-clock-o"></i> <?php echo date("d/m/Y h:i A", strtotime($item->creation_date)); ?>
                <!--   For delete and Update -->
              <?php if ($item->owner_id == $current_viwer) { ?>
                <div class="sign_options">
                  <a href="javaScript:void(0)" onclick="deleteSignature(<?php echo $this->translate($item->signature_id); ?>)" class="sesbasic_button"><?php echo $this->translate("Delete"); ?></a>
                  <a class="sessmoothbox sesbasic_button" href="<?php echo $this->baseUrl()."/epetition/index/signupdate?id=".$item->signature_id;  ?>"><?php echo $this->translate("Edit"); ?></a>
                </div>
              <?php } ?>
            </div>
            <div class="epetition_signature_listing_top sesbasic_clearfix epetition_signature_listing_left_column">
              <?php if (isset($item->support_statement)): ?>
                  <div class='epetition_signature_support_statement'>
                      <b><?php echo $item->support_statement; ?></b>
                  </div>
              <?php endif; ?>
            </div>
            <?php if (isset($item->support_reason)): ?>
              <div class='epetition_signature_support_reason'>
                <?php echo $item->support_reason; ?>
              </div>
          <?php endif; ?>
        </li>
  <?php endforeach; ?>
  <?php if ($this->loadOptionData == 'pagging') { ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "epetition"), array('identityWidget' => $randonNumber)); ?>
  <?php } ?>
  <?php if (!$this->is_ajax) { ?>
        </ul>
  <?php } ?>

<?php else: ?>
    <div class="sesbasic_tip clearfix">
        <img src="application/modules/Epetition/externals/images/signatures_icon.png" alt="">
        <span class="sesbasic_text_light">
      <?php echo $this->translate('No signature have been posted in this petition yet.'); ?>    </span>
    </div>
<?php endif; ?>
<?php if (!$this->is_ajax) { ?>
  <?php if ($this->loadOptionData != 'pagging' && !$this->is_ajax): ?>
        <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>"
             onclick="viewMore_<?php echo $randonNumber; ?>();"> <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn fa fa-repeat')); ?> </div>
        <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber; ?>"
             id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i
                        class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif; ?>
<?php } ?>


<script type="application/javascript">
    var tabId_signature = '<?php echo $randonNumber; ?>';
    window.addEvent('domready', function () {
        tabContainerHrefSesbasic(tabId_signature);
    });
</script>

<script type="application/javascript">
  <?php if(!$this->is_ajax):?>
  <?php if($this->loadOptionData == 'auto_load'){ ?>
  window.addEvent('load', function () {
      sesJqueryObject(window).scroll(function () {
          var containerId = '#epetition_signature_listing';
          if (typeof sesJqueryObject(containerId).offset() != 'undefined') {
              var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject(containerId).offset().top;
              var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
              if (fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block') {
                  document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
              }
          }
      });
  });
  <?php } ?>
  <?php endif; ?>
  var page<?php echo $randonNumber; ?> = <?php echo $this->page + 1; ?>;
  var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->stats); ?>';
  var searchParams<?php echo $randonNumber; ?> = '';
  <?php if($this->loadOptionData != 'pagging') { ?>
  viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
     if ($('view_more_<?php echo $randonNumber; ?>'))
         $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  function viewMore_<?php echo $randonNumber; ?> () {
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show();
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + "widget/index/mod/epetition/name/petition-signatures",
          'data': {
              format: 'html',
              page: page<?php echo $randonNumber; ?>,
              params: params<?php echo $randonNumber; ?>,
              is_ajax: 1,
              limit: '<?php echo $this->limit; ?>',
              widgetId: '<?php echo $this->widgetId; ?>',
              searchParams: searchParams<?php echo $randonNumber; ?>,
              epetition_id: '<?php echo $this->epetition_id; ?>',
              loadOptionData: '<?php echo $this->loadOptionData ?>'
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
              sesJqueryObject('#epetition_signature_listing').append(responseHTML);
              sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
              sesJqueryObject('#loadingimgepetitionsignature-wrapper').hide();
              viewMoreHide_<?php echo $randonNumber; ?>();
          }
      });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
  }
  <?php }else{ ?>
  function paggingNumber<?php echo $randonNumber; ?>(pageNum) {
      sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display', 'block');
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
          method: 'post',
          'url': en4.core.baseUrl + "widget/index/mod/epetition/name/petition-signatures",
          'data': {
              format: 'html',
              page: pageNum,
              epetition_id: '<?php echo $this->epetition_id; ?>',
              params: params<?php echo $randonNumber; ?> ,
              searchParams: searchParams<?php echo $randonNumber; ?>,
              is_ajax: 1,
              limit: '<?php echo $this->limit; ?>',
              widgetId: '<?php echo $this->widgetId; ?>',
              loadOptionData: '<?php echo $this->loadOptionData ?>'
          },
          onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
              sesJqueryObject('#epetition_signature_listing').html(responseHTML);
              sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display', 'none');
              sesJqueryObject('#loadingimgepetitionsignature-wrapper').hide();
          }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
  }
  <?php } ?>
</script>
<script type="application/javascript">
    function deleteSignature(id) {
        var url=en4.core.baseUrl+"epetition/index/deletesign";
        if (confirm("Are you sure? Do you want to delete?")) {
            sesJqueryObject.ajax({
                url: url,
                type: "POST",
                data: {id : id},
                dataType: "json",
                success: function(html) {
                    if (html['status']) {
                        sesJqueryObject("#sign"+id).remove();
                        alert(html['msg']);
                    }
                    else
                    {
                        alert(html['msg']);
                    }
                }
            });
        }
    }
</script>
