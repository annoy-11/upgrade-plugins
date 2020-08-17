<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: view-dashboard-signature.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<table style="width: 650px; ">
    <tr>
        <th>Name</th>
      <?php $user = Engine_Api::_()->getItem('user', $this->data['owner_id']); ?>
        <td><?php echo isset($this->data['owner_id']) && $this->data['owner_id']>0 ?  $this->translate($user->getTitle()) : $this->data['first_name']." ".$this->data['last_name']; ?></td>
    </tr>

    <tr>
        <th>Email</th>
        <td><?php echo isset($this->data['owner_id']) && $this->data['owner_id']>0 ?  $this->translate($user->email) : $this->data['email']; ?></td>
    </tr>


    <tr>
        <th>Location</th>
        <td><?php echo $this->data['location']; ?></td>
    </tr>
    <tr>
        <th>Support Statement</th>
        <td><?php echo $this->data['support_statement']; ?></td>
    </tr>

    <tr>
        <th>Support Reason</th>
        <td><?php echo $this->data['support_reason']; ?></td>
    </tr>
    <tr>
        <th>Created Date</th>
        <td><?php echo $this->data['creation_date']; ?></td>
    </tr>
</table>
<button type="button" onclick="parent.Smoothbox.close();">Close</button>