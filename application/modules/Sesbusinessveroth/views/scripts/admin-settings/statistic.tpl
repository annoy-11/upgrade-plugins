<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessveroth
 * @package    Sesbusinessveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<?php if( count($this->subNavigation) ): ?>
  <div class='sesbasic-admin-sub-tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
  </div>
<?php endif; ?>
<h3>Statistics</h3>
<p>This page list the total number of Verifications, Businesses Verified and Businesses Verifiers.</p><br />
<div class='settings'>
  <form class="global_form" style="float:left;">
    <div>
      <h3><?php echo $this->translate("Statistics") ?> </h3>
      <table class='admin_table' style="width: 400px;border-width:1px;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Verifications:" ?></strong></td>
            <td><?php echo count($this->allverifications); ?></td>
          </tr>
<!--          <tr>
            <td><strong class="bold"><?php //echo "Total Businesses Verified:" ?></strong></td>
            <td><?php //echo '0'; ?></td>
          </tr>-->
          <tr>
            <td><strong class="bold"><?php echo "Total Businesses Verifiers:" ?></strong></td>
            <td><?php echo count($this->allverifiers); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
</div>
