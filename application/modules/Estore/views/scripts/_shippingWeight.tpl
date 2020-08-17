<?php
$weight = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_weight_matrix','lbs');
 ?>
<div id="weight-wrapper" class="form-wrapper">
  <div id="weight-label" class="form-label">
   <label for="cost" class="optional"> <?php echo $this->translate("Weight Matrix (In %s)", $weight) ?></label>
  </div>
  <div id="weight-element" style="display : inline;">
    <div style="display:inline-block;">
      <input type="text" name="weight_min" value="<?php echo isset($_POST['weight_min']) ? $_POST['weight_min'] : (!empty($this->shipping) ? $this->shipping->weight_min : '0'); ?>" id="weight_min" style="width: 60px;" />
    </div>
    -
    <div style="display:inline;">
    <input type="text" name="weight_max" value="<?php echo isset($_POST['weight_max']) ? $_POST['weight_max'] : (!empty($this->shipping) ? $this->shipping->weight_max : ''); ?>" id="weight_max" style="width: 60px;" /></div>
  </div>
</div>