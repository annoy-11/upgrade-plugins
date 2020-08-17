<?php
$locale = Zend_Registry::get('Locale');
$currency = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->estore()->defaultCurrency()); ?>
<div id="cost-wrapper" class="form-wrapper">
  <div id="cost-label" class="form-label">
   <label for="cost" class="optional"> <?php echo $this->translate("Cost Range (In %s)", $currency) ?></label>
  </div>
  <div id="cost-element" style="display : inline;">
    <div style="display:inline-block;">
      <input type="text" name="cost_min" id="cost_min" value="<?php echo isset($_POST['cost_min']) ? $_POST['cost_min'] : (!empty($this->shipping) ? $this->shipping->cost_min : 0); ?>" style="width: 60px;" />
    </div>
    -
    <div style="display:inline;">
    <input type="text" name="cost_max" id="cost_max" style="width: 60px;" value="<?php echo isset($_POST['cost_max']) ? $_POST['cost_max'] : (!empty($this->shipping) ? $this->shipping->cost_max : ''); ?>" /></div>
  </div>
</div>