<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdating	
 * @package    Sesdating
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-09-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdating/externals/styles/lp-two.css'); ?>
<div class="sesdating_lp_two_members">

  <div class="sesdating_lp_members_inner">
    <h3><?php echo $this->translate("Top Members"); ?></h3>
    <div class="sesdating_lp_members sesbasic_bxs clearfix">
      <div class="members_tab">
        <button class="tablinks active" onclick="openMember(event, 'Newest')"><?php echo $this->translate("Newest"); ?></button>
        <button class="tablinks" onclick="openMember(event, 'Active')"><?php echo $this->translate("Active"); ?></button>
        <button class="tablinks" onclick="openMember(event, 'Popular')"><?php echo $this->translate("Popular"); ?></button>
      </div>
      <div id="Newest" class="tabcontent first">
          <?php foreach($this->newest_members as $newest_member) { ?>
            <a href="<?php echo $newest_member->getHref(); ?>">
              <div class="members_tab_item">
                  <div class="_img">
                    <?php echo $this->itemPhoto($newest_member, 'thumb.profile'); ?>
                  </div>
                  <div class="_cont">
                    <span class="_name"><?php echo $newest_member->getTitle(); ?></span>
                    <span class="_count sesbasic_text_light"><?php echo $this->translate(array('%s friend', '%s friends', $newest_member->member_count),$this->locale()->toNumber($newest_member->member_count)) ?></span>
                  </div>
              </div>
            </a>
          <?php } ?>
      </div>
      
      <div id="Active" class="tabcontent">
          <?php foreach($this->active_members as $newest_member) { ?>
            <a href="<?php echo $newest_member->getHref(); ?>">
              <div class="members_tab_item">
                  <div class="_img">
                    <?php echo $this->itemPhoto($newest_member, 'thumb.profile'); ?>
                  </div>
                  <div class="_cont">
                    <span class="_name"><?php echo $newest_member->getTitle(); ?></span>
                    <span class="_count sesbasic_text_light"><?php echo $this->translate(array('%s friend', '%s friends', $newest_member->member_count),$this->locale()->toNumber($newest_member->member_count)) ?></span>
                  </div>
              </div>
            </a>
          <?php } ?>
      </div>
      
      <div id="Popular" class="tabcontent">
          <?php foreach($this->popular_members as $newest_member) { ?>
            <a href="<?php echo $newest_member->getHref(); ?>">
              <div class="members_tab_item">
                  <div class="_img">
                    <?php echo $this->itemPhoto($newest_member, 'thumb.profile'); ?>
                  </div>
                  <div class="_cont">
                    <span class="_name"><?php echo $newest_member->getTitle(); ?></span>
                    <span class="_count sesbasic_text_light"><?php echo $this->translate(array('%s friend', '%s friends', $newest_member->member_count),$this->locale()->toNumber($newest_member->member_count)) ?></span>
                  </div>
              </div>
            </a>
          <?php } ?>
      </div>
    </div>
  </div>
</div>
<script>
function openMember(evt, memberName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(memberName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
