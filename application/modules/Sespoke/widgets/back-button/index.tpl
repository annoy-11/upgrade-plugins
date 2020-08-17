<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php if (empty($this->viewmore)): ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/styles/styles.css'); ?>
<?php endif; ?>
<?php if($this->viewMore): ?>
<script type="text/javascript">
  
  function viewMore<?php echo $this->identity ?>() {
    if ($('view_more_<?php echo $this->identity ?>'))
      $('view_more_<?php echo $this->identity ?>').style.display = "<?php echo ( $this->results->count() == $this->results->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('view_more_<?php echo $this->identity ?>'))
      document.getElementById('view_more_<?php echo $this->identity ?>').style.display = 'none';
    
    if(document.getElementById('loading_image_<?php echo $this->identity ?>'))
     document.getElementById('loading_image_<?php echo $this->identity ?>').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/sespoke/name/back-button/',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->results->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('pokeback_results_<?php echo $this->identity ?>').innerHTML = document.getElementById('pokeback_results_<?php echo $this->identity ?>').innerHTML + responseHTML;
        
        if(document.getElementById('view_more_<?php echo $this->identity ?>'))
          document.getElementById('view_more_<?php echo $this->identity ?>').destroy();
        
        if(document.getElementById('loading_image_<?php echo $this->identity ?>'))
         document.getElementById('loading_image_<?php echo $this->identity ?>').destroy();
      }
    }));
    return false;
  }
</script>
<?php endif; ?>
<?php if($this->showType):?>
  <?php if (empty($this->viewmore)): ?>
  <ul class="sespoke_list sespoke_clearfix sespoke_bxs" id= "pokeback_results_<?php echo $this->identity ?>">
    <?php endif; ?>
    <?php foreach($this->results as $item): 
    
    $manageActions = Engine_Api::_()->getItem('sespoke_manageaction', $item['manageaction_id']); 
    if($manageActions->member_levels) {
      $member_levels = json_decode($manageActions->member_levels);
    }
    $user = Engine_Api::_()->getItem('user', $item['poster_id']);
    $name = ucfirst($manageActions->name);
    $icon = $manageActions['icon'];
    $action = $manageActions->action;
    ?>
    <?php $icon = Engine_Api::_()->storage()->get($icon, '')->getPhotoUrl(); ?>
    <?php if(in_array($this->viewer_level_id, $member_levels)): ?>
      <li id="cancel_request_<?php echo $item['poke_id'] ?>" class="sespoke_clearfix">
      	<div class="sespoke_list_thumb">
        	<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.profile', $user->getTitle())) ?>
        </div>
        <div class='sespoke_list_info'>
          <div class='sespoke_list_info_title'>
            <a href="javascript:void(0)" onclick="cancelRequest(<?php echo $item['poke_id'] ?>)" class="sespoke_close_btn fa fa-close"></a>
            <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
          </div>
          <div class="sespoke_list_info_stat">
            <?php if($action == 'action'): ?>
              <?php echo $this->translate(ucfirst($manageActions->verb)); echo $this->translate(" You!"); ?>
            <?php else: ?>          
              <?php echo $this->translate("Sent to you!"); ?>
            <?php endif; ?>
          </div>
          <div class="sespoke_list_info_stat sespoke_text_light">
            <?php echo $this->timestamp($item->creation_date); ?>
          </div>
          <div class="sespoke_list_info_btn">
            <a href="javascript:void(0);" onclick="backRequest(<?php echo $item['poke_id'] ?>)" class="sespoke_button sespoke_bxs sespoke_button">
              <i style="background-image:url(<?php echo $icon ?>);"></i>
              <?php if($action == 'gift'): ?>
                <?php echo $this->translate("Send Back"); ?>
              <?php else: ?>
                <?php echo $this->translate(ucfirst($manageActions->name)); echo $this->translate(" Back"); ?>
              <?php endif; ?>
            </a>
          </div>
        </div>
      </li>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($this->viewMore && !empty($this->results) && $this->results->count() > 1): ?>
      <?php if ($this->results->getCurrentPageNumber() < $this->results->count()): ?>
        <div class="clear" id="viewmore_scroll"></div>
        <div class="sespoke_load_btn" id="view_more_<?php echo $this->identity ?>" onclick="viewMore<?php echo $this->identity ?>();" style="display: block;">
          <a href="javascript:void(0);" class="sespoke_link_btn" id="feed_viewmore_link_<?php echo $this->identity ?>"><i class="fa fa-repeat"></i><span><?php $this->translate('View More'); ?></span></a>
        </div>
        <div class="sespoke_load_btn" id="loading_image_<?php echo $this->identity ?>" style="display: none;">
          <span class="sespoke_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <?php if (empty($this->viewmore)): ?>
  </ul>
  <?php endif; ?>
  
<?php else : ?>

  <?php if (empty($this->viewmore)): ?>
  <ul class="sespoke_sidebar_list sespoke_clearfix sespoke_bxs" id= "pokeback_results_<?php echo $this->identity ?>">
    <?php endif; ?>
    <?php foreach($this->results as $item): 
    
    $manageActions = Engine_Api::_()->getItem('sespoke_manageaction', $item['manageaction_id']); 
    if($manageActions->member_levels) {
      $member_levels = json_decode($manageActions->member_levels);
    }
    $user = Engine_Api::_()->getItem('user', $item['poster_id']);
    $name = ucfirst($manageActions->name);
    $icon = $manageActions['icon'];
    $action = $manageActions->action;
    ?>
    <?php $icon = Engine_Api::_()->storage()->get($icon, '')->getPhotoUrl(); ?>
    <?php if(in_array($this->viewer_level_id, $member_levels)): ?>
      <li id="cancel_request_<?php echo $item['poke_id'] ?>" class="sespoke_clearfix">
        <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle()), array('class' => 'sespoke_sidebar_list_thumb')) ?>
        <div class='sespoke_sidebar_list_info'>
          <div class='sespoke_sidebar_list_title'>
            <a href="javascript:void(0)" onclick="cancelRequest(<?php echo $item['poke_id'] ?>)" class="sespoke_close_btn fa fa-close"></a>
            <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
          </div>
          <div class="sespoke_list_info_stat">
            <?php if($action == 'action'): ?>
              <?php echo $this->translate(ucfirst($manageActions->verb)); echo $this->translate(" You!"); ?>
            <?php else: ?>          
              <?php echo $this->translate("Sent to you!"); ?>
            <?php endif; ?>
          </div>
          <div class="sespoke_list_info_stat sespoke_text_light">
            <?php echo $this->timestamp($item->creation_date); ?>
          </div>
          <div class="sespoke_sidebar_list_btn">
 						<a href="javascript:void(0);" onclick="backRequest(<?php echo $item['poke_id'] ?>)" style="background-image:url(<?php echo $icon ?>);">
              <?php if($action == 'gift'): ?>
                <?php echo $this->translate("Send Back"); ?>
              <?php else: ?>
                <?php echo $this->translate(ucfirst($manageActions->name)); echo $this->translate(" Back"); ?>
              <?php endif; ?>
            </a>
          </div>
        </div>
      </li>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($this->viewMore && !empty($this->results) && $this->results->count() > 1): ?>
      <?php if ($this->results->getCurrentPageNumber() < $this->results->count()): ?>
        <div class="clear" id="viewmore_scroll"></div>
        <div class="sespoke_load_btn" id="view_more_<?php echo $this->identity ?>" onclick="viewMore<?php echo $this->identity ?>();" style="display: block;">
          <a href="javascript:void(0);" class="sespoke_link_btn" id="feed_viewmore_link_<?php echo $this->identity ?>"><i class="fa fa-repeat"></i><span><?php $this->translate('View More'); ?></span></a>
        </div>
        <div class="sespoke_load_btn" id="loading_image_<?php echo $this->identity ?>" style="display: none;">
          <span class="sespoke_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <?php if (empty($this->viewmore)): ?>
  </ul>
  <?php endif; ?>
  
<?php endif; ?>
<script>
  
  function backRequest(id) {
           
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sespoke/index/back-request',
      data: {
        format: 'json',
        'id': id,
      },
      onSuccess: function(responseJSON) {
        $('cancel_request_'+ id).remove();
      }
    })); 
    
  }   
  
  function cancelRequest(id) {
    
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sespoke/index/cancel-request',
      data: {
        format: 'json',
        'id': id,
      },
      onSuccess: function(responseJSON) {
        $('cancel_request_'+ id).remove();
      }
    }));  
    
  }
</script>