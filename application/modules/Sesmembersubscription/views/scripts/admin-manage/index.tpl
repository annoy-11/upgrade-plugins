<?php

?>

<?php include APPLICATION_PATH .  '/application/modules/Sesmembersubscription/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings'>
    <form class="global_form">
      <div>
      <h3><?php echo $this->translate("Commission Settings") ?></h3>
      <p class="description">
        <?php echo $this->translate('Here, you can add commissions to be charged on the member subscription payment on your website. You will also see all commissions added by you here. <br /><br />Click on “Add New Commission” to add a new commission value. Here, you can add more than 1 commission based on the price of the member profile subscription. For example: You can charge 2% for a $40 and above subscription profiles and 4% for a subscription profiles upto $39.<br />Note: Please make sure, the value in "From Amount" and "To Amount" is not repeated to avoid issues.') ?>
      </p>
      
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmembersubscription', 'controller' => 'manage', 'action' => 'add'), $this->translate('Add New Entry'), array(
      'class' => 'smoothbox buttonlink',
      'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/\Sesmembersubscription/externals/images/add.png);')) ?><br/><br/>
      <?php if(count($this->results)>0):?>
        <table class='admin_table' style="width:100%;">
          <thead>
            <tr>
              <th><?php echo $this->translate("From Amount") ?></th>
              <th><?php echo $this->translate("To Amount") ?></th>
              <th align="center"><?php echo $this->translate("Commission Type") ?></th>
              <th align="center"><?php echo $this->translate("Commission Value") ?></th>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->results as $result): ?>
            <tr>
              <td><?php echo $result->from; ?></td>
              <td><?php echo $result->to; ?></td>
              <td class="admin_table_centered">
                <?php if($result->commission_type == 1) { ?>
                  <?php echo "Percentage"; ?>
                <?php } else { ?>
                  <?php echo "Fixed"; ?>
                <?php } ?>
              </td>
              <td class="admin_table_centered"><?php echo $result->commission_value; ?></td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmembersubscription', 'controller' => 'manage', 'action' => 'edit', 'id' => $result->commission_id), $this->translate('edit'), array('class' => 'smoothbox')); ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmembersubscription', 'controller' => 'manage', 'action' => 'delete', 'id' =>$result->commission_id), $this->translate('delete'), array('class' => 'smoothbox')); ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else:?>
        <br/>
        <div class="tip">
          <span><?php echo $this->translate("There are currently no results.") ?></span>
        </div>
      <?php endif;?>
      </div>
    </form>
  </div>
</div>