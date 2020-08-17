<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: variations.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array(
	'product' => $this->product,
      ));	
?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    	<div class="sesbasic_dashboard_form">
      <div class="sesproduct_seo_add_product">
          <h3><?php echo $this->translate('Product Variations'); ?></h3>
          <p><?php echo $this->translate('Product Variations can be created as combinations of Product Attributes of "Select Box" type.'); ?></p>
          <br />
          <?php if(count($this->attributes) > 0): ?>
          <div style="display:inline-block;">
            <a class="openSmoothbox sesbasic_button" href="<?php echo $this->url(array('product_id' => $this->product->custom_url,'action'=>'variation-create'), 'sesproduct_cartproducts', true); ?>"><i class="fa fa-plus"></i><?php echo $this->translate("Create Variation"); ?></a>
          </div>
          <?php endif; ?>
          <?php if(count($this->attributes)){ ?>
          <h3><?php echo $this->translate("Attribute and their Price relation."); ?></h3>
          <?php } ?>
          <?php foreach($this->attributes as $attribute){ ?>
            <h3><?php echo $attribute['label']; ?></h3>
          <?php //get variation
            $options = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOptionFields($attribute['field_id']);
          ?>
          <?php if( count($options) > 0): ?>
          <div class="estore_variation_table sesbasic_dashboard_table sesbasic_bxs">
              <form method="post" onsubmit="return false;">
                  <table>
                      <thead>
                      <tr>
                          <th class="centerT"><?php echo $this->translate("Title"); ?></th>
                          <th class="centerT"><?php echo $this->translate("Type") ?></th>
                          <th class="centerT"><?php echo $this->translate("Price") ?></th>
                          <th class="centerT"><?php echo $this->translate("Options") ?></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($options as $item): ?>
                      <tr>
                          <td class="centerT"><?php echo $item['label'] ?></td>
                          <td class="centerT"><?php echo $item['type'] == 1  ? $this->translate("Increment(+)") : $this->translate("Decrement(-)"); ?></td>
                          <td class="centerT"><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice($item['price'],Engine_Api::_()->sesproduct()->getCurrentCurrency(),''); ?></td>
                          <td class="table_options centerT">
                              <?php echo $this->htmlLink($this->url(array('product_id' => $this->product->custom_url,'action'=>'option-edit','option_id'=>$item['option_id'],'from'=>'variation'), 'sesproduct_cartproducts', true), $this->translate(""), array('class' => 'fa fa-edit smoothbox','title'=>$this->translate("Edit"))) ?>
                              <?php echo $this->htmlLink($this->url(array('product_id' => $this->product->custom_url,'action'=>'option-delete-variation','option_id'=>$item['option_id']), 'sesproduct_cartproducts', true), $this->translate(""), array('class' => 'fa fa-trash smoothbox','title'=>$this->translate("Delete"))) ?>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
              </form>
          </div>
          <?php else: ?>
          <div class="tip">
              <span>
                  <?php echo $this->translate('No variation created in this attribute.'); ?>
              </span>
          </div>
          <?php endif; ?>
          <?php } ?>

          <br>
          <h3 style="font-weight: bold"><?php echo $this->translate("Variations"); ?></h3>
          <?php if( count($this->variations) > 0): ?>
          <div class="estore_variation_table sesbasic_dashboard_table sesbasic_bxs">
              <form method="post">
                  <table>
                      <thead>
                      <tr>
                          <th><?php echo $this->translate("Variation Name"); ?></th>
                          <th class="centerT"><?php echo $this->translate("price") ?></th>
                          <th class="centerT"><?php echo $this->translate("Quantity") ?></th>
                          <th class="centerT"><?php echo $this->translate("Status") ?></th>
                          <?php foreach($this->attributes as $attribute){ ?>
                          <th class="centerT"><?php echo $attribute['label']; ?></th>
                          <?php } ?>
                          <th class="centerT"><?php echo $this->translate("Option") ?></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php $optionData = $this->options; ?>
                      <?php foreach ($this->variations as $item):
                        $options = explode(',',$item['options']);

                        $name = "";
                        foreach($options as $option){
                            $name .= $optionData[$option].' - ';
                        }

                      ?>
                      <tr>
                          <td><?php echo trim($name,' - '); ?></td>
                          <td class="centerT"><?php echo ($item['type'] == 1  ? "+" : "-").Engine_Api::_()->sesproduct()->getCurrencyPrice($item['price'],Engine_Api::_()->sesproduct()->getCurrentCurrency(),'');; ?></td>
                          <td class="centerT"><input style="width: 60px;" type="text" name="combination_<?php echo $item['combination_id']; ?>" value="<?php echo $item['quantity']; ?>"></td>
                          <?php if (!empty($item['status'])): ?>
                          <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'sesproduct_cartproducts', 'action' => 'enable-combination','product_id'=>$this->product->custom_url, 'id' => $item['combination_id']), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('class'=>'sesproduct_tax_enadisable','title' => $this->translate('Disable Combination')))) ?>
                          </td>
                          <?php else: ?>
                          <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'sesproduct_cartproducts', 'action' => 'enable-combination','product_id'=>$this->product->custom_url, 'id' => $item['combination_id']), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('class'=>'sesproduct_tax_enadisable','title' => $this->translate('Enable Combination')))) ?>
                          </td>
                          <?php endif; ?>
                          <?php foreach($options as $option){ ?>
                            <td class="centerT"><?php echo $optionData[$option]; ?></td>
                          <?php
                            } ?>

                          <?php if(count($this->attributes) != count($options)){ ?>
                            <?php $left = count($this->attributes) - count($options); ?>
                            <?php for($i = 0;$i<count($left);$i++){ ?>
                            <td class="centerT">-</td>

                            <?php } ?>
                          <?php } ?>
                          <td class="table_options centerT">
                              <?php echo $this->htmlLink($this->url(array('product_id' => $this->product->custom_url,'action'=>'delete-combination','combination_id'=>$item['combination_id']), 'sesproduct_cartproducts', true), $this->translate(""), array('class' => 'fa fa-trash smoothbox','title'=>$this->translate("Delete"))) ?>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
                  <div class="buttons fleft clr" style="margin-top: 10px;">
                      <button type="submit" name="variation_submit"><?php echo $this->translate("Save Changes"); ?></button>
                  </div>
              </form>
          </div>
          <?php else: ?>
          <div class="tip">
              <span>
                  <?php echo $this->translate('No variation created in this attribute.'); ?>
              </span>
          </div>
          <?php endif; ?>

      </div>

    <script type="application/javascript">
        sesJqueryObject(document).on('click','.sesproduct_tax_enadisable',function (e) {
            e.preventDefault();
            var that = sesJqueryObject(this).parent();
            if(sesJqueryObject(that).hasClass('active'))
                return;
            var url = sesJqueryObject(that).attr('href');
            sesJqueryObject(that).addClass('active');
            sesJqueryObject(this).attr('src','application/modules/Core/externals/images/loading.gif');
            sesJqueryObject.post(url,{},function (response) {
                var res = sesJqueryObject.parseJSON(response);
                sesJqueryObject(that).removeClass('active');
                if(res == 1){
                    sesJqueryObject(that).find('img').attr('src','application/modules/Sesbasic/externals/images/icons/check.png');
                }else{
                    sesJqueryObject(that).find('img').attr('src','application/modules/Sesbasic/externals/images/icons/error.png');
                }
            });
        });
        function onOptionEdit() {
            window.location.reload();
        }
    </script>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
