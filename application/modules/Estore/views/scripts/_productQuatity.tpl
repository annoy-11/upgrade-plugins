<div id="product-wrapper" class="form-wrapper">
  <div id="product-label" class="form-label">
   <label for="cost" class="optional"> <?php echo $this->translate("Product Quantity") ?></label>
  </div>
  <div id="product-element" style="display : inline;">
    <div style="display:inline-block;">
      <input type="text" name="product_min" value="<?php echo isset($_POST['product_min']) ? $_POST['product_min'] : (!empty($this->shipping) ? $this->shipping->product_min : '1'); ?>" id="product_min" style="width: 60px;" />
    </div>
    -
    <div style="display:inline;">
    <input type="text" name="product_max" value="<?php echo isset($_POST['product_max']) ? $_POST['product_max'] : (!empty($this->shipping) ? $this->shipping->product_max : ''); ?>" id="product_max" style="width: 60px;" /></div>
  </div>
</div>