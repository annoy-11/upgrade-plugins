<?php

?>

<h2>
  <?php echo $this->translate('SNS DEMO Plugin') ?>
</h2>

<?php if( count($this->navigation) ): ?>
<div class='tabs'>
    <?php
    // Render the menu
    //->setUlClass()
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>

<div class='clear'>
  <div class='settings'>
    <form class="global_form">
      <div>
      <h3><?php echo $this->translate("Service Entries") ?></h3>
          <?php if(count($this->services)>0):?>

      <table class='admin_table'>
        <thead>

          <tr>
            <th><?php echo $this->translate("Service Name") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>

        </thead>
        <tbody>
          <?php foreach ($this->services as $service): ?>

          <tr>
            <td><?php echo $service->service_name?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'snsdemo', 'controller' => 'settings', 'action' => 'edit-service', 'id' =>$service->service_id), $this->translate('edit'), array(
                'class' => 'smoothbox',
              )) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'snsdemo', 'controller' => 'settings', 'action' => 'delete-service', 'id' =>$service->service_id), $this->translate('delete'), array(
                'class' => 'smoothbox',
              )) ?>
            </td>
          </tr>

          <?php endforeach; ?>

        </tbody>
      </table>

      <?php else:?>
      <br/>
      <div class="tip">
      <span><?php echo $this->translate("There are currently no services.") ?></span>
      </div>
      <?php endif;?>
      <br/>

      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'snsdemo', 'controller' => 'settings', 'action' => 'add-service'), $this->translate('Add New Service'), array(
      'class' => 'smoothbox buttonlink',
      'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Core/externals/images/admin/new_service.png);')) ?>
      </div>
    </form>
  </div>
</div>
