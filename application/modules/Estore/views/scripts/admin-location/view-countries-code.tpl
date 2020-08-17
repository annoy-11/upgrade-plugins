<div class="global_form_popup">

  <table class="admin_table">
    <tr>
      <th><?php echo $this->translate("Country Name") ?></th>
      <th><?php echo $this->translate("Country Code") ?></th>
    </tr>
    <?php foreach ($this->countries as  $cnt) : ?>
          <tr>
            <td><?php echo $cnt->name; ?></td>
            <td><?php echo $cnt->sortname; ?></td>
          </tr>
    <?php endforeach; ?>
  </table>
  
  <div class='buttons' style="margin-top: 15px;">
    <button type='button' name="cancel" onclick="javascript:parent.Smoothbox.close();"><?php echo $this->translate("Close") ?></button>
  </div>
</div>