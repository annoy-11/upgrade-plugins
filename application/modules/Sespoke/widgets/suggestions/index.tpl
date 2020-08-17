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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespoke/externals/styles/styles.css'); ?>
<?php if($this->showType) : ?>
  <ul class="sespoke_list sespoke_clearfix sespoke_bxs" id="suggestionUL_<?php echo $this->identity?>">
    <?php foreach($this->results as $item):
      $user = Engine_Api::_()->getItem('user', $item['user_id']);
      $userLevelId = $user->level_id;
      $member_levels = json_decode($this->manageactions[0]['member_levels']);
      $name  = ucfirst($this->manageactions[0]['name']);
      $icon = Engine_Api::_()->storage()->get($this->manageactions[0]['icon'], '')->getPhotoUrl();
    ?>
    <?php if(in_array($userLevelId, $member_levels)): ?>
      <li class="sespoke_clearfix" id="cancel_suggrequest_<?php echo $user->user_id ?>_<?php echo $this->identity?>">
        <div class="sespoke_list_thumb">
        <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.profile', $user->getTitle())) ?>
        </div>
        <div class='sespoke_list_info'>
          <div class='sespoke_list_info_title'>
            <a href="javascript:void(0)" onclick="cancelSuggRequest_<?php echo $this->identity?>(<?php echo $user->user_id ?>)" class="sespoke_close_btn fa fa-close"></a>
            <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
          </div>
        <div class="sespoke_list_info_btn">
          <?php	echo $this->htmlLink(array('route' => 'default', 'module' => 'sespoke', 'controller' => 'index', 'action' => 'poke', 'id' => $item['user_id'], 'manageaction_id' => $this->manageactions[0]['manageaction_id']), "<i style='background-image:url($icon);'></i> " . $this->translate($name), array('class' => 'smoothbox sespoke_button sespoke_bxs sespoke_button')) ;	?>
        </div>
        </div>
      </li>
    <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <ul class="sespoke_sidebar_list sespoke_clearfix sespoke_bxs" id="suggestionUL_<?php echo $this->identity?>">
      <?php foreach($this->results as $item):
        $user = Engine_Api::_()->getItem('user', $item['user_id']);
        $userLevelId = $user->level_id;
        $member_levels = json_decode($this->manageactions[0]['member_levels']);
        $name  = ucfirst($this->manageactions[0]['name']);
        $icon = Engine_Api::_()->storage()->get($this->manageactions[0]['icon'], '');
        if($icon) {
        $icon = $icon->getPhotoUrl();
      ?>
        <?php if(in_array($userLevelId, $member_levels)): ?>
          <li class="sespoke_clearfix" id="cancel_suggrequest_<?php echo $user->user_id ?>_<?php echo $this->identity?>">
            <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle()), array('class' => 'sespoke_sidebar_list_thumb')) ?>
            <div class='sespoke_sidebar_list_info'>
              <div class='sespoke_sidebar_list_title'>
                <a href="javascript:void(0)" onclick="cancelSuggRequest_<?php echo $this->identity?>(<?php echo $user->user_id ?>)" class="sespoke_close_btn fa fa-close"></a>
                <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
              </div>
            <div class="sespoke_sidebar_list_btn">
              <?php	echo $this->htmlLink(array('route' => 'default', 'module' => 'sespoke', 'controller' => 'index', 'action' => 'poke', 'id' => $item['user_id'], 'manageaction_id' => $this->manageactions[0]['manageaction_id']), $this->translate($name), array('class' => 'smoothbox buttonlink', 'style' => 'background-image:url("'.$icon.'");')) ;	?>
            </div>
            </div>
          </li>
        <?php endif; 
      
        } ?>
      <?php endforeach; ?>
    </ul>
<?php endif; ?>
<script>
 
  function cancelSuggRequest_<?php echo $this->identity?>(id) {
    var ulId = document.getElementById("suggestionUL_"+<?php echo $this->identity?>);
    var totalLi = ulId.children.length;
    if(totalLi == 1) {
      document.getElementById("suggestionUL_"+<?php echo $this->identity?>).innerHTML = "<div class='tip'><span>There are no more suggestions.</span></div>";
    }
    $('cancel_suggrequest_'+ id + '_' + <?php echo $this->identity?>).remove();

  }
</script>