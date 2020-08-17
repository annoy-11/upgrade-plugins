<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: general-taxes.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
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
        <h3><?php echo $this->translate('General Taxes') ?>
        </h3>
    </div>

    <?php endif;?>
    <div id="estore_manage_taxes_content" style="position: relative;">
        <div class="estore_content_count">
            <?php echo  $this->translate(array('%s General Taxes found', '%s General Taxes found', $this->taxes->getTotalItemCount()), $this->locale()->toNumber($this->taxes->getTotalItemCount())); ?>
        </div>
        <?php if( count($this->taxes) > 0): ?>
        <div class="estore_dashboard_table sesbasic_bxs">
            <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
                <table>
                    <thead>
                    <tr>
                        <th class="centerT"><?php echo $this->translate("Title"); ?></th>
                        <th class="centerT"><?php echo $this->translate("Rate Depend On") ?></th>
                        <th class="centerT"><?php echo $this->translate("Options") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($this->taxes as $item): ?>
                    <tr>
                        <td class="centerT"><?php echo $item->title ?></td>
                        <td class="centerT"><?php echo $item->type == 1  ? $this->translate("Billing Address") : $this->translate("Shipping Address"); ?></td>

                        <td class="table_options centerT">
                            <?php echo $this->htmlLink($this->url(array('store_id' => $this->store->custom_url,'action'=>'manage-locations','tax_id'=>$item->getIdentity(),'is_admin'=>true), 'estore_dashboard', true), $this->translate(""), array('class' => 'fa fa-globe estore_dashboard_nopropagate_content','title'=>$this->translate("Manage Locations"))) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php echo $this->paginationControl($this->taxes, null, array("_pagging.tpl", "estore"),array('identityWidget'=>'manage_general_taxes')); ?>
            </form>
        </div>
        <?php else: ?>
        <div class="tip">
      <span>
          <?php
                echo $this->translate('No tax added by admin yet.');

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
    function paggingNumbermanage_general_taxes(pageNum){
        sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
        requestPagging= (new Request.HTML({
            method: 'post',
            'url':  "<?php echo $this->url(array('store_id' => $this->store->custom_url,'action'=>'general-taxes'), 'estore_dashboard', true); ?>",
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
