<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-ticket.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
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
        <h3><?php echo $this->translate('Manage Locations') ?> </h3>
        <p><?php echo $this->translate("Below, you can manage your store locations on which tax will apply."); ?></p>
        <div style="margin: 10px;">
        <?php if($this->is_admin){ ?>
            <a class="fa fa-arrow-left estore_link_btn estore_dashboard_nopropagate_content" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'general-taxes'), 'estore_dashboard', true); ?>"><?php echo $this->translate('Back to General Taxes');?></a>
        <?php }else{ ?>
            <a class="fa fa-arrow-left estore_link_btn estore_dashboard_nopropagate_content" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'taxes'), 'estore_dashboard', true); ?>"><?php echo $this->translate('Back to Manage Taxes');?></a>
          <?php } ?>
           <?php if(empty($this->isreturn) && !$this->is_admin){ ?>
            <a class="fa fa-plus estore_link_btn openSmoothbox" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'tax_id'=>$this->tax_id,'action'=>'create-location'), 'estore_dashboard', true); ?>"><?php echo $this->translate('Add Location');?></a>
           <?php } ?>
        </div>
    </div>
    <?php endif;?>
    <div id="estore_manage_taxes_content" style="position: relative;">
        <?php if( count($this->paginator) > 0): ?>
        <div class="estore_content_count">
            <?php echo  $this->translate(array('%s location found', '%s locations found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
        </div>
        <div class="estore_dashboard_table sesbasic_bxs">
            <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
                <table>
                    <thead>
                    <tr>
                        <?php if(empty($this->is_admin)){ ?>
                        <th class="centerT">
                            <input type="checkbox" value="0" onclick="selectAll()">
                        </th>
                        <?php } ?>
                        <th class="centerT"><?php echo $this->translate("Country"); ?></th>
                        <th class="centerT"><?php echo $this->translate("State") ?></th>
                        <th class="centerT"><?php echo $this->translate("Tax Rate") ?></th>
                        <?php if(empty($this->is_admin)){ ?>
                        <th class="centerT"><?php echo $this->translate("Status") ?></th>
                        <?php } ?>
                        <th class="centerT"><?php echo $this->translate("Creation Date") ?></th>
                        <?php if(empty($this->is_admin)){ ?>
                        <th class="centerT"><?php echo $this->translate("Options") ?></th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($this->paginator as $item): ?>
                    <tr>
                        <?php if(empty($this->is_admin)){ ?>
                        <td>
                            <input type="checkbox" name="delete_<?php echo $item->getIdentity(); ?>" value="<?php echo $item->getIdentity(); ?>" class="estore_select_all">
                        </td>
                        <?php } ?>
                        <td class="centerT"><?php echo $item->country_id ? Engine_Api::_()->getItem('estore_country',$item->country_id)->name : "All Countries"; ?></td>
                        <td class="centerT"><?php echo $item->state_id ? Engine_Api::_()->getItem('estore_state',$item->state_id)->name : "All States"; ?></td>
                       <td class="centerT">
                           <?php
                                echo $item->tax_type ? $item->value.'%' : Engine_Api::_()->estore()->getCurrencyPrice($item->value,Engine_Api::_()->estore()->getCurrentCurrency(),'');
                           ?>
                       </td>
                        <?php if(empty($this->is_admin)){ ?>
                        <?php if (!empty($item->status)): ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'estore_dashboard', 'action' => 'enable-location-tax','store_id'=>$this->store->custom_url, 'tax_id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('class'=>'estore_tax_enadisable','title' => $this->translate('Disable Tax')))) ?>
                            </td>
                        <?php else: ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'estore_dashboard', 'action' => 'enable-location-tax','store_id'=>$this->store->custom_url, 'tax_id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('class'=>'estore_tax_enadisable','title' => $this->translate('Enable Tax')))) ?>
                            </td>
                        <?php endif; ?>
                        <?php } ?>
                        <td class="centerT">
                            <?php echo $this->locale()->toDateTime($item->creation_date) ?>
                        </td>
                        <?php if(empty($this->is_admin)){ ?>
                        <td class="table_options centerT">
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'create-location','id'=>$item->getIdentity()), 'estore_dashboard', true), $this->translate(""), array('class' => 'fa fa-pencil openSmoothbox','title'=>$this->translate("Edit"))) ?>
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'delete-location-tax','tax_id'=>$item->getIdentity()), 'estore_dashboard', true), $this->translate(""), array('class' => 'estore_ajax_delete fa fa-trash','data-value'=>'Are you sure want to delete this tax? It will not be recoverable after being deleted.','title'=>$this->translate("Delete"))) ?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(empty($this->is_admin)){ ?>
                <div class="buttons fleft clr" style="margin-top: 10px;">
                    <button type="submit"><?php echo $this->translate("Delete Selected"); ?></button>
                </div>
                <?php } ?>
                <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "estore"),array('identityWidget'=>'manage_locations')); ?>
            </form>
        </div>
        <?php else: ?>
        <div class="tip">
      <span>
      	<?php if(!$this->is_search_ajax){ ?>
          <?php
            if(empty($this->is_admin)){
                echo $this->translate('You have not added any location yet. Get started by <a href="'. $this->url(array('store_id' => $this->store->custom_url,'action'=>'create-location','tax_id'=>$this->tax_id), 'estore_dashboard', true).'" class="openSmoothbox">creating</a> one.');
        	 }else{
                echo $this->translate('Admin have not added any location yet.');

            }
        	  }else{
          	    echo $this->translate('No location were found matching your selection.');
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
    function paggingNumbermanage_locations(pageNum){
        sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
        requestPagging= (new Request.HTML({
            method: 'post',
            'url':  "<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-locations','tax_id'=>$this->tax_id,'is_admin'=>$this->is_admin), 'estore_dashboard', true); ?>",
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