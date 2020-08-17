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
  function sidebardonorsLoadMore() {
  
    if ($('sidebar_view_more'))
      $('sidebar_view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('sidebar_view_more'))
      document.getElementById('sidebar_view_more').style.display = 'none';
    
    if(document.getElementById('sidebar_loading_more'))
     document.getElementById('sidebar_loading_more').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/sescrowdfunding/name/profile-donors-sidebar',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('donor_sidebar').innerHTML = document.getElementById('donor_sidebar').innerHTML + responseHTML;
        
        if(document.getElementById('sidebar_view_more'))
          document.getElementById('sidebar_view_more').destroy();
        
        if(document.getElementById('sidebar_loading_more'))
         document.getElementById('sidebar_loading_more').destroy();
               if(document.getElementById('donors_sidebar_loading_more'))
         document.getElementById('donors_sidebar_loading_more').destroy();
      }
    }));
    return false;
  }
</script>
<?php if (empty($this->viewmore)): ?>
  <ul id="donor_sidebar" class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs">
<?php endif; ?>
  <?php foreach($this->paginator as $getAllDoner):
    $user = Engine_Api::_()->getItem('user', $getAllDoner->user_id); ?>
    <li class="sesbasic_clearfix sescf_sidebar_list">
      <div class="sescf_sidebar_list_img">
        <?php if($user->photo_id) { ?>
          <?php $photo = $user->getPhotoUrl('thumb.icon'); ?>
        <?php } else { ?>
          <?php $photo = $this->baseUrl() . '/application/modules/User/externals/images/nophoto_user_thumb_profile.png'; ?>
        <?php } ?>
        <a href="<?php echo $user->getHref(); ?>"><img src="<?php echo $photo; ?>" alt=""></a>
        </div>
      <div class="sescf_sidebar_list_cont sesbasic_clearfix">
        <div class="sescf_sidebar_list_name">
          <a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a>
        </div>
        <?php $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency(); ?>
        <?php if(in_array('donationAmount', $this->show_criteria)): ?>
          <div class="sescf_sidebar_list_amount">
            <?php $totalGainAmountwithCu = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($getAllDoner->total_amount,$currency); ?>
            <?php echo $totalGainAmountwithCu; ?>
          </div>
        <?php endif; ?>
        <?php if(in_array('date', $this->show_criteria)): ?>
          <div class="sescf_sidebar_list_date sesbasic_text_light">
            <?php echo $this->timestamp($getAllDoner->creation_date); ?>
          </div>
        <?php endif; ?>
      </div>
    </li>
  <?php endforeach; ?>
  <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="clr" id="donors_sidebar_loading_more"></div>
      <div class="sesbasic_view_more sesbasic_load_btn" id="sidebar_view_more" onclick="sidebardonorsLoadMore();" style="display: block;">
        <a href="javascript:void(0);" id="feed_viewmore_link" class="sesbasic_animation sesbasic_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
      </div>
      <div class="sesbasic_view_more_loading" id="sidebar_loading_more" style="display: none;">
        <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php if (empty($this->viewmore)): ?>
  </ul>
<?php endif; ?>
