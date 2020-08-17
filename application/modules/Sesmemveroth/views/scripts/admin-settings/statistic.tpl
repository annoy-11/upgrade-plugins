<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmemveroth/views/scripts/dismiss_message.tpl';?>
<h3>Statistics</h3>
<p>This page list the total number of Verifications, Users Verified and Users Verifiers.</p><br />
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
          <tr>
            <td><strong class="bold"><?php echo "Total Users Verified:" ?></strong></td>
            <td><?php echo '0'; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Users Verifiers:" ?></strong></td>
            <td><?php echo count($this->allverifiers); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
</div>
