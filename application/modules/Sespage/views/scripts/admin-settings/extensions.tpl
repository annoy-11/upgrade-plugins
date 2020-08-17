<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<?php $moduleApi = Engine_Api::_()->getDbTable('modules', 'core'); ?>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Page Directories Extensions") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are page directories extensions."); ?>
      </p>
      <?php if($moduleApi->isModuleEnabled('sespageveroth') || $moduleApi->isModuleEnabled('sespagepoll') || $moduleApi->isModuleEnabled('sespageurl') || $moduleApi->isModuleEnabled('sespagevideo') || $moduleApi->isModuleEnabled('sespagepackage') || $moduleApi->isModuleEnabled('sespageteam') || $moduleApi->isModuleEnabled('sespagenote') || $moduleApi->isModuleEnabled('sespageoffer')) { ?>
        <table class='admin_table' style="width: 100%;">
          <tbody>
            <?php if($moduleApi->isModuleEnabled('sespageveroth')) { ?>
              <tr>
                <td class="extname"><a <?php if($moduleApi->isModuleEnabled('sespageveroth')) { ?> href="admin/sespageveroth/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-verification-by-members-extension/" <?php } ?> >Page Verification by Members Extension</a></td>
              </tr>
            <?php } ?>
            <?php if($moduleApi->isModuleEnabled('sespagepoll')) { ?>
                <tr>  
                  <td class="extname"><a <?php if($moduleApi->isModuleEnabled('sespagepoll')) { ?> href="admin/sespagepoll/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-polls-extension/" <?php } ?> >Page Polls Extension</a></td>
                </tr>
            <?php } ?>
            <?php if($moduleApi->isModuleEnabled('sespageurl')) { ?>
                <tr> 
                  <td class="extname"><a <?php if($moduleApi->isModuleEnabled('sespageurl')) { ?> href="admin/sespageurl/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-short-url-extension/" <?php } ?> >Page Short URL Extension</a></td>
                </tr>
              <?php } ?>
              <?php if($moduleApi->isModuleEnabled('sespagevideo')) { ?>
                <tr>
                  <td class="extname"><a <?php if($moduleApi->isModuleEnabled('sespagevideo')) { ?> href="admin/sespagevideo/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-videos-extension/" <?php } ?> >Page Videos Extension</a></td>
                </tr>
              <?php } ?>
              <?php if($moduleApi->isModuleEnabled('sespagepackage')) { ?>
                <tr>
                <td class="extname"><a <?php if($moduleApi->isModuleEnabled('sespagepackage')) { ?> href="admin/sespagepackage/package/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-directories-packages-for-allowing-page-creation-extension/" <?php } ?>>Page Directories – Packages for Allowing Page Creation Extension</a></td>
                </tr> 
              <?php } ?>
              <?php if($moduleApi->isModuleEnabled('sespageteam')) { ?>
                <tr>
                <td><strong class="bold"><a <?php if($moduleApi->isModuleEnabled('sespageteam')) { ?> href="admin/sespageteam/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-team-showcase-extension/" <?php } ?> >Page Team Showcase Extension</a></strong></td></tr>
              <?php } ?>
              <?php if($moduleApi->isModuleEnabled('sespagenote')) { ?>
                <tr><td><strong class="bold"><a <?php if($moduleApi->isModuleEnabled('sespagenote')) { ?> href="admin/sespagenote/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-directories-packages-for-allowing-page-creation-extension/" <?php } ?> >Page Notes Extension</a></strong></td></tr>
              <?php } ?>
              <?php if($moduleApi->isModuleEnabled('sespageoffer')) { ?>
                <tr><td><strong class="bold"><a <?php if($moduleApi->isModuleEnabled('sespageoffer')) { ?> href="admin/sespageoffer/settings" <?php } else { ?> href="https://www.socialenginesolutions.com/social-engine/page-directories-packages-for-allowing-page-creation-extension/" <?php } ?> >Page Offers Extension</a></strong></td></tr>
              <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        <div class="tip">
          <span>
            <?php echo $this->translate("There are no extensions yet.") ?>
          </span>
        </div>
      <?php } ?>
    </div>
  </form>
</div>
<style type="text/css">
.extname a{font-weight:bold;}
</style>
