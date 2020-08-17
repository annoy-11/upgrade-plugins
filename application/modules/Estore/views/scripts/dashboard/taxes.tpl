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
        <h3><?php echo $this->translate('Manage Your Store Taxes') ?></h3>
        <p><?php echo $this->translate("Below, create tax for your store. You can also manage the existing tax here."); ?></p>
        <a class="estore_link_btn fa fa-plus openSmoothbox" href="<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'create-tax'), 'estore_dashboard', true); ?>"><?php echo $this->translate('Create Store Tax');?></a>
    </div>

    <div class="estore_browse_search estore_browse_search_horizontal estore_dashboard_search_form">
        <?php //echo $this->searchForm->render($this); ?>
    </div>
    <?php endif;?>
    <div id="estore_manage_taxes_content">
        <?php if( count($this->taxes) > 0): ?>
        <div class="estore_content_count">
            <?php echo  $this->translate(array('%s tax found', '%s taxes found', $this->taxes->getTotalItemCount()), $this->locale()->toNumber($this->taxes->getTotalItemCount())); ?>
        </div>
        <div class="estore_dashboard_table sesbasic_bxs">
            <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
                <table>
                    <thead>
                    <tr>
                        <th class="centerT">
                            <input type="checkbox" value="0" onclick="selectAll()">
                        </th>
                        <th class="centerT"><?php echo $this->translate("Title"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Rate Depend On") ?></th>
                        <th class="centerT"><?php echo $this->translate("Status") ?></th>
                        <th class="centerT"><?php echo $this->translate("Options") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($this->taxes as $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="delete_<?php echo $item->getIdentity(); ?>" value="<?php echo $item->getIdentity(); ?>" class="estore_select_all">
                        </td>
                        <td class="centerT"><?php echo $item->title ?></td>
                        <td class="centerT"><?php echo $item->type == 1  ? $this->translate("Billing Address") : $this->translate("Shipping Address"); ?></td>
                        <?php if (!empty($item->status)): ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'estore_dashboard', 'action' => 'enable-tax','store_id'=>$this->store->custom_url, 'tax_id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('class'=>'estore_tax_enadisable','title' => $this->translate('Disable Tax')))) ?>
                            </td>
                        <?php else: ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'estore_dashboard', 'action' => 'enable-tax','store_id'=>$this->store->custom_url, 'tax_id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('class'=>'estore_tax_enadisable','title' => $this->translate('Enable Tax')))) ?>
                            </td>
                        <?php endif; ?>
                        <td class="table_options centerT">
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-locations','tax_id'=>$item->getIdentity()), 'estore_dashboard', true), $this->translate(""), array('class' => 'fa fa-globe estore_dashboard_nopropagate_content','title'=>$this->translate("Manage Locations"))) ?>
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'edit-tax','tax_id'=>$item->getIdentity()), 'estore_dashboard', true), $this->translate(""), array('class' => 'fa fa-pencil openSmoothbox','title'=>$this->translate("Edit"))) ?>
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'delete-tax','tax_id'=>$item->getIdentity()), 'estore_dashboard', true), $this->translate(""), array('class' => 'estore_ajax_delete fa fa-trash','data-value'=>'Are you sure want to delete this tax? It will not be recoverable after being deleted.','title'=>$this->translate("Delete"))) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="buttons fleft clr" style="margin-top: 10px;">
                    <button type="submit"><?php echo $this->translate("Delete Selected"); ?></button>
                </div>
                <?php echo $this->paginationControl($this->taxes, null, array("_pagging.tpl", "estore"),array('identityWidget'=>'manage_taxes')); ?>

            </form>
        </div>
        <?php else: ?>
        <div class="tip">
      <span>
      	<?php if(!$this->is_search_ajax){ ?>
          <?php
                echo $this->translate('You have not added any tax for your store yet. Get started by <a href="'. $this->url(array('store_id' => $this->store->custom_url,'action'=>'create-tax'), 'estore_dashboard', true).'" class="openSmoothbox">creating</a> one.');
        	  }else{
          	    echo $this->translate('No tickets were found matching your selection.');
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
    function paggingNumbermanage_taxes(pageNum){
        sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
        requestPagging= (new Request.HTML({
            method: 'post',
            'url':  "<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'taxes'), 'estore_dashboard', true); ?>",
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