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
      <h3><?php echo $this->translate("Theme Entries") ?></h3>
          <?php if(count($this->themes)>0):?>

      <table class='admin_table'>
        <thead>

          <tr>
            <th><?php echo $this->translate("Theme Name") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>

        </thead>
        <tbody>
          <?php foreach ($this->themes as $theme): ?>

          <tr>
            <td><?php echo $theme->theme_name?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'snsdemo', 'controller' => 'settings', 'action' => 'edit-theme', 'id' =>$theme->theme_id), $this->translate('edit'), array(
                'class' => 'smoothbox',
              )) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'snsdemo', 'controller' => 'settings', 'action' => 'delete-theme', 'id' =>$theme->theme_id), $this->translate('delete'), array(
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
      <span><?php echo $this->translate("There are currently no themes.") ?></span>
      </div>
      <?php endif;?>
      <br/>

      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'snsdemo', 'controller' => 'settings', 'action' => 'add-theme'), $this->translate('Add New Theme'), array(
      'class' => 'smoothbox buttonlink',
      'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Core/externals/images/admin/new_theme.png);')) ?>
      </div>
    </form>
  </div>
</div>
