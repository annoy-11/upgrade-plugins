<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: sent.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>



<?php include APPLICATION_PATH .  '/application/modules/Sesbrowserpush/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">

function multiDelete()

{

  return confirm("<?php echo $this->translate("Are you sure you want to delete the selected slides ?") ?>");

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

      <h3>Sent Notifications</h3>

      <p>This page lists all the notifications sent by you. Below, you can also choose to re-send the notifications</p>

      <br class="clear" />

      <div class='admin_search sesbrowsepush_admin_search'>

        <?php echo $this->formFilter->render($this) ?>

      </div>

      <br />

      <?php if( count($this->paginator) ): ?>

        <div class="sesbrowsepush_search_reasult">

          <?php echo $this->translate(array('%s sent notification found.', '%s sent notifications found', count($this->paginator)), $this->locale()->toNumber(count($this->paginator))) ?>

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

                          $image = $baseURL.$image; ?>

                        <img src="<?php echo $image; ?>" style="height:50px; width:50px">

                        <?php  

                       }

                      }else

                        echo "-";

                     }else echo "-"; ?>

                  </td>

                  <td><?php echo $item->getTitle(); ?></td>

                  <td><?php echo $item->getDescription(); ?></td>

                   <td><?php echo $item->scheduled_time; ?></td>

                  <td class="admin_table_url"><?php echo $item->link; ?></td>

                  <td>

                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'scheduled', 'action' => 'resend', 'id' => $item->getIdentity(), 'param' => '1'), $this->translate("Edit & Resend"), array('class' => 'smoothbox')); ?>
                    <?php if(!empty($item->sent)) { ?>
                    |
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'scheduled', 'action' => 'report', 'scheduled_id' => $item->getIdentity()), $this->translate("Report"), array('class' => 'smoothbox')); ?>
                    <?php } ?>

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

            <?php echo $this->translate("There are no scheduled notification created by you yet.") ?>

          </span>

        </div>

      <?php endif; ?>

    </div>

  </div>

</div>

