<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: shippings.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
if(!$this->is_search_ajax):
if(!$this->is_ajax):
echo $this->partial('dashboard/left-bar.tpl', 'estore', array('store' => $this->store));?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix">
    <?php endif; endif;?>
    <?php if(!$this->is_search_ajax): ?>
    <div class="estore_dashboard_content_header sesbasic_clearfix">
        <h3><?php echo $this->translate('Manage Shipping Methods') ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.minimum.shippingcost')){ ?>
            <span class="floatR"><?php echo $this->translate("Minimum Shipping Cost: %s",Engine_Api::_()->estore()->getCurrencyPrice($this->store->minimum_shipping_cost,Engine_Api::_()->estore()->getCurrentCurrency(),'')); ?></span>
            <?php } ?>
        </h3>
        <div>
            <a class="estore_link_btn estore_dashboard_nopropagate_content" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'create-shipping'), 'estore_dashboard', true); ?>"><i class="fa fa-plus"></i> <?php echo $this->translate('Create Shipping Method');?></a>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.minimum.shippingcost')){ ?>
                    <a class="estore_link_btn openSmoothbox" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'minimum-shipping-cost'), 'estore_dashboard', true); ?>">
                        <i class="fa fa-plus"></i> <?php echo $this->translate('Set Minimum Shipping Cost');?>
                    </a>
            <?php } ?>
            <?php if( count($this->paginator) > 0){ ?>
                <a href="<?php echo $this->url(array('action'=>'create','store_id'=>$this->subject()->getIdentity()),'sesproduct_general',true); ?>" class="estore_link_btn"><?php echo $this->translate("Create Product"); ?></a>
            <?php } ?>
        </div>
        <br />

        <p><?php echo $this->translate("Below, you can create the Shipping Method for your store."); ?></p>
    </div>
    <?php endif;?>
    <div id="estore_manage_taxes_content">
        <?php if( count($this->paginator) > 0): ?>
        <div class="estore_content_count">
            <?php echo  $this->translate(array('%s shipping method found', '%s shipping methods found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
        </div>
        <div class="estore_dashboard_table sesbasic_bxs" style="position: relative;">
            <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
                <table>
                    <thead>
                    <tr>
                        <th class="centerT">
                            <input type="checkbox" value="0" onclick="selectAll()">
                        </th>
                        <th class="centerT"><?php echo $this->translate("Title"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Price"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Country"); ?></th>
                        <th class="centerT"><?php echo $this->translate("States"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Weight Limit"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Delivery Time"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Method Types"); ?></th>

                        <th class="centerT"><?php echo $this->translate("Limit"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Status") ?></th>
                        <th class="centerT"><?php echo $this->translate("Creation Date"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Options") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($this->paginator as $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="delete_<?php echo $item->getIdentity(); ?>" value="<?php echo $item->getIdentity(); ?>" class="estore_select_all">
                        </td>
                        <td class="centerT"><?php echo $item->title ?></td>
                        <td class="centerT">
                        <?php if($item->price_type == 1) { ?>
                          <?php echo $item->price.'%'; ?>
                        <?php } else { ?>
                          <?php echo Engine_Api::_()->estore()->getCurrencyPrice($item->price,Engine_Api::_()->estore()->getCurrentCurrency(),''); ?>
                        <?php } ?>
                        </td>

                        <td class="centerT"><?php echo $item->country_id ? Engine_Api::_()->getItem('estore_country',$item->country_id)->name : "All Countries"; ?></td>
                        <td class="centerT"><?php echo $item->state_id ? Engine_Api::_()->getItem('estore_state',$item->state_id)->name : "All States"; ?></td>


                        <td class="centerT"><?php echo $item->weight_min .' - '.($item->weight_max ? $item->weight_max.' '.Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_weight_matrix','lbs') : 0); ?></td>
                        <td class="centerT"><?php echo $item->delivery_time; ?></td>
                        <td class="centerT"><?php
                            if($item->types == 0){
                                echo $this->translate("Cost & Weight");
                            }else if($item->types == 1){
                                echo $this->translate("Weight");
                            }else{
                                echo $this->translate("Product Quatity & Weight");
                            }

                        ?></td>
                        <td>
                            <?php if($item->types == 0){ ?>
                                <?php if($item->cost_min){
                                    echo Engine_Api::_()->estore()->getCurrencyPrice($item->cost_min,Engine_Api::_()->estore()->getCurrentCurrency(),'');
                                }else{
                                     echo Engine_Api::_()->estore()->getCurrencyPrice($item->cost_min,Engine_Api::_()->estore()->getCurrentCurrency(),'');
                                } ?>
                            -
                                <?php if($item->cost_max){
                                    echo Engine_Api::_()->estore()->getCurrencyPrice($item->cost_max,Engine_Api::_()->estore()->getCurrentCurrency(),'');
                                }else{
                                    echo Engine_Api::_()->estore()->getCurrencyPrice($item->cost_max,Engine_Api::_()->estore()->getCurrentCurrency(),'');
                                } ?>
                            <?php }else{ ?>
                            <?php if($item->product_min){
                                    echo $item->product_min;
                                }else{
                                    echo "0";
                                } ?>
                            -
                                <?php if($item->product_max){
                                 echo $item->product_max;
                                }else{
                                 echo "0";
                                } ?>
                            <?php } ?>

                        </td>
                        <?php if (!empty($item->status)): ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'estore_dashboard', 'action' => 'enable-shipping','store_id'=>$this->store->custom_url, 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('class'=>'estore_tax_enadisable','title' => $this->translate('Disable Shipping Method')))) ?>
                            </td>
                        <?php else: ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'estore_dashboard', 'action' => 'enable-shipping','store_id'=>$this->store->custom_url, 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('class'=>'estore_tax_enadisable','title' => $this->translate('Enable Shipping Method')))) ?>
                            </td>
                        <?php endif; ?>
                        <td><?php echo $this->timestamp(strtotime($item->creation_date)); ?></td>
                        <td class="table_options centerT">
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'create-shipping','id'=>$item->getIdentity()), 'estore_dashboard', true), $this->translate(""), array('class' => 'fa fa-edit estore_dashboard_nopropagate_content','title'=>$this->translate("Edit"))) ?>
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'delete-shipping','id'=>$item->getIdentity()), 'estore_dashboard', true), $this->translate(""), array('class' => 'estore_ajax_delete fa fa-trash','data-value'=>'Are you sure want to delete this shipping method? It will not be recoverable after being deleted.','title'=>$this->translate("Delete"))) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="buttons fleft clr" style="margin-top: 10px;">
                    <button type="submit"><?php echo $this->translate("Delete Selected"); ?></button>
                </div>
                <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "estore"),array('identityWidget'=>'manage_shipping')); ?>

            </form>
        </div>
        <?php else: ?>
        <div class="tip">
      <span>
      	<?php if(!$this->is_search_ajax){ ?>
          <?php
                echo $this->translate('You have not added any Shipping Method for your store yet. Get started by <a href="'. $this->url(array('store_id' => $this->store->custom_url,'action'=>'create-shipping'), 'estore_dashboard', true).'" class="estore_dashboard_nopropagate_content">creating</a> one.');
        	  }
          ?>
      </span>
        </div>
        <?php endif; ?>
    </div>
    <?php if(!$this->is_search_ajax):
    if(!$this->is_ajax): ?>
</div>
</div>
</div>
<?php endif; endif; ?>

<script type="application/javascript">
    var requestPagging;
    function paggingNumbermanage_shipping(pageNum){
        sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
        requestPagging= (new Request.HTML({
            method: 'post',
            'url':  "<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'shippings'), 'estore_dashboard', true); ?>",
            'data': {
                format: 'html',
                is_ajax : 1,
                page:pageNum,
            },
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
                sesJqueryObject('.estore_dashboard_content').html(responseHTML);
            }
        }));
        requestPagging.send();
        return false;
    }
</script>
