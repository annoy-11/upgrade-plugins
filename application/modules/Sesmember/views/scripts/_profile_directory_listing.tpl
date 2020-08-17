<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _userAge.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<ul class="iwr_members_listing">
  <?php if(count($members) > 0) { ?>
  <?php foreach($members as $member) { ?>
    <li class="iwr_members_list_item">
      <article class="sesbasic_clearfix">
        <div class="_thumb">
        	<?php echo $this->htmlLink($member->getHref(), $this->itemPhoto($member, 'thumb.icon', $member->getTitle())) ?>
        </div>
        <div class="_cont"><div class="_title"><a href="<?php echo $member->getHref(); ?>"><?php echo $member->getTitle(); ?></a></div></div>
      </article>
    </li>
  <?php } ?>
  <?php } else { ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('There are no members.'); ?>
      </span>
    </div>
  <?php } ?> 
</ul>