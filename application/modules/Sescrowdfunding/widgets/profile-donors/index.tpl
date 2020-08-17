<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="text/javascript">
  function donorsLoadMore() {
  
    if ($('view_more_donors'))
      $('view_more_donors').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('view_more_donors'))
      document.getElementById('view_more_donors').style.display = 'none';
    
    if(document.getElementById('loading_image'))
     document.getElementById('loading_image').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/sescrowdfunding/name/profile-donors',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('donor_results').innerHTML = document.getElementById('donor_results').innerHTML + responseHTML;
        
        if(document.getElementById('view_more_donors'))
          document.getElementById('view_more_donors').destroy();
        
        if(document.getElementById('loading_image'))
         document.getElementById('loading_image').destroy();
               if(document.getElementById('donors_loading_image'))
         document.getElementById('donors_loading_image').destroy();
      }
    }));
    return false;
  }
</script>
<?php if (empty($this->viewmore)): ?>
  <ul id="donor_results" class="sescf_donors_list sesbasic_bxs sesbasic_clearfix">
<?php endif; ?>
  <?php foreach($this->paginator as $getAllDoner): 
      $user = Engine_Api::_()->getItem('user', $getAllDoner->user_id);
    ?>
    <li class="sescf_donors_list_item sesbasic_clearfix sesbasic_bxs sesevent_grid_btns_wrap" style="width:200px;">
      <div class="sescf_donors_list_item_inner prelative sesbasic_clearfix">
        <div class="sescf_donors_list_item_thumb prelative" style="height:200px;">
          <?php if($user->photo_id) { ?>
            <?php $photo = $user->getPhotoUrl('thumb.profile'); ?>
          <?php } else { ?>
            <?php $photo = $this->baseUrl() . '/application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
          <?php } ?>
          <span class="sescf_donors_list_item_thumb_img" style="background-image:url(<?php echo $photo; ?>);"></span>
          <?php $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency(); ?>
          <a href="<?php echo $user->getHref(); ?>" class="sescf_donors_list_item_thumb_overlay"></a>
          <?php if(in_array('donationAmount', $this->show_criteria)): ?>
            <div class="sescf_donors_list_item_amount">
              <?php $totalGainAmountwithCu = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($getAllDoner->total_amount,$currency); ?>
              <?php echo $totalGainAmountwithCu; ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="sescf_donors_list_item_details sesbasic_clearfix">
          <div class="sescf_donors_list_item_title centerT">
            <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
          </div>
          <?php if(in_array('date', $this->show_criteria)): ?>
            <div class="sescf_donors_list_item_date centerT sesbasic_text_light">
              <?php echo $this->timestamp($getAllDoner->creation_date); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </li>
  <?php endforeach; ?>

  <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="clr" id="donors_loading_image"></div>
      <div class="sesbasic_view_more sesbasic_load_btn" id="view_more_donors" onclick="donorsLoadMore();" style="display: block;">
        <a href="javascript:void(0);" id="feed_viewmore_link" class="sesbasic_animation sesbasic_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
      </div>
      <div class="sesbasic_view_more_loading" id="loading_image" style="display: none;">
        <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php if (empty($this->viewmore)): ?>
  </ul>
<?php endif; ?>
