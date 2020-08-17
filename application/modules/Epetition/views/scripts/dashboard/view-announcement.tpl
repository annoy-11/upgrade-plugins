<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: view-announcement.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="epetition_announcement_form sesbasic_dashboard_form sesbm sesbasic_clearfix sesbasic_bxs">
  <table style="width:90%;">
      <tr>
          <th>Title</th>
          <td><?php echo $this->data['title']; ?></td>
      </tr>
  
      <tr>
          <th>Description</th>
          <td><?php echo $this->data['description']; ?></td>
      </tr>
  </table>
</div>