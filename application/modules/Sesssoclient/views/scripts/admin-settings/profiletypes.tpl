<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoclient
 * @package    Sesssoclient
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: profiletypes.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesssoclient/views/scripts/dismiss_message.tpl';?>
<div style="width:40%;">
  <table class="admin_table" width="100%">
    <thead>	
      <th style="width:20px;">Id</th>
      <th>Profile Type</th>
    </thead>
    <tbody>
      <?php foreach($this->profiles as $profiles){ ?>
      <tr>
        <td><?php echo $profiles["option_id"]; ?></td>
      <td><?php echo $profiles["label"]; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>