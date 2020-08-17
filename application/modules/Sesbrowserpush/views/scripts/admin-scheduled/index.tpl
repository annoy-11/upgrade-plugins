<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbrowserpush/views/scripts/dismiss_message.tpl';?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected notifications?") ?>");
}
function selectAll()
{
  var i;
  var multidelete_form = $('multidelete_form');
  var inputs = multidelete_form.elements;
  for (i = 1; i < inputs.length; i++) {
    if (!inputs[i].disabled) {
      inputs[i].checked = inputs[0].checked;
    }
  }
}
</script>
<div class="sesbasic-form">
	<div>
  	<div class="sesbasic-form-cont">
      <h3>Schedule Notifications</h3>
      <p>Here you can schedule & configure the push notification messages to be sent to your chosen subscribers at the dates of your choice. You can also upload image and add URL to your message. You can also test the Push Notifications by sending them to Test users first by using the "Send To Test Users" button. You can choose to make any subscriber a test user from the "<a href="admin/sesbrowserpush/settings/subscriber">Manage Subscribers</a>" section of this plugin.<br />You can also duplicate a notification to schedule the same message to be sent again.<br />You can also edit or delete notifications.</p>
      <br class="clear" />
      <div class="sesbrowsepush_search_reasult">
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'scheduled', 'action' => 'create', 'param' => '1'), $this->translate("Schedule New Notification"), array('class'=>'smoothbox sesbrowsepush_icon_add buttonlink')) ?>
      </div>
      <?php if( count($this->paginator) ): ?>
        <div class="sesbrowsepush_search_reasult">
          <?php echo $this->translate(array('%s scheduled notification found.', '%s scheduled notifications found', count($this->paginator)), $this->locale()->toNumber(count($this->paginator))) ?>
        </div>
        <div class="sesbrowsepush_admin_table">
          <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
          <table class='admin_table'>
            <thead>
              <tr>
                <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
                <th class='admin_table_short'>ID</th>
                <th class='admin_table_short'>Icon</th>
                <th><?php echo $this->translate("Title") ?></th>
                <th><?php echo $this->translate("Description") ?></th>
                <th><?php echo $this->translate("Scheduled Time") ?></th>
                <th><?php echo $this->translate("Redirect URL") ?></th>
                <th><?php echo $this->translate("Options") ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($this->paginator as $item): ?>
                <tr>
                  <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->getIdentity();?>' value='<?php echo $item->getIdentity() ?>' /></td>
                  <td><?php echo $item->getIdentity() ?></td>
                  <td>
                    <?php if($item->file_id){ 
                      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($item->file_id);
                      if( $file ) {
                        $image =  $file->map();
                        $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
                        $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
                        if(strpos($image,'http') === false){
                          $image = $baseURL.$image; } ?>
                        <img src="<?php echo $image; ?>" style="height:50px; width:50px">
                        <?php  
                       
                      }else
                        echo "-";
                     }else echo "-"; ?>
                  </td>
                  <td><?php echo $item->getTitle(); ?></td>
                  <td><?php echo $item->getDescription(); ?></td>
                  <td><?php echo $item->scheduled_time; ?></td>
                  <td class="admin_table_url"><?php echo $item->link; ?></td>
                  
                  <td>
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'scheduled', 'action' => 'create', 'id' => $item->getIdentity(), 'param' => '1'), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
                    |
                    <?php echo $this->htmlLink(
                        array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'scheduled', 'action' => 'delete', 'id' => $item->getIdentity()),
                        $this->translate("Delete"),
                        array('class' => 'smoothbox')); ?>
                    |
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'scheduled', 'action' => 'duplicate', 'id' => $item->getIdentity()), $this->translate("Duplicate Notification"), array('class' => 'smoothbox')); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <br />
          <div class='buttons'>
            <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
          </div>
          </form>
        </div>
      <?php else: ?>
        <br />
        <div class="tip">
          <span>
            <?php echo $this->translate('There are no scheduled notifications yet.') ?>
          </span>
        </div>
      <?php endif; ?>
  	</div>
	</div>
</div>    
