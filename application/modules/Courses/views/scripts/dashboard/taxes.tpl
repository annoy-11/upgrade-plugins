<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: taxes.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php
if(!$this->is_search_ajax):
if(!$this->is_ajax):
echo $this->partial('dashboard/left-bar.tpl', 'courses', array('course' => $this->course));?>
<div class="courses_dashboard_content sesbm sesbasic_clearfix">
    <?php endif; endif;?>
    <?php if(!$this->is_search_ajax): ?>
    <div class="courses_dashboard_content_header sesbasic_clearfix">
        <h3><?php echo $this->translate('Manage Your Course Taxes') ?></h3>
        <p><?php echo $this->translate("Below, create tax for your course. You can also manage the existing tax here."); ?></p>
        <br />
        <a class="courses_link_btn sesbasic_button fa fa-plus openSmoothbox" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'create-tax'), 'courses_dashboard', true); ?>"><?php echo $this->translate('Create Course Tax');?></a>
    </div>

    <div class="courses_browse_search courses_browse_search_horizontal courses_dashboard_search_form">
        <?php //echo $this->searchForm->render($this); ?>
    </div>
    <?php endif;?>
    <div id="courses_manage_taxes_content">
        <?php if(count($this->taxes) > 0): ?>
        <div class="courses_content_count">
            <?php echo  $this->translate(array('%s tax found', '%s taxes found', $this->taxes->getTotalItemCount()), $this->locale()->toNumber($this->taxes->getTotalItemCount())); ?>
        </div>
        <div class="courses_dashboard_table sesbasic_bxs">
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
                            <input type="checkbox" name="delete_<?php echo $item->getIdentity(); ?>" value="<?php echo $item->getIdentity(); ?>" class="courses_select_all">
                        </td>
                        <td class="centerT"><?php echo $item->title ?></td>
                        <td class="centerT"><?php echo $item->type == 1  ? $this->translate("Billing Address") : $this->translate(""); ?></td>
                        <?php if (!empty($item->status)): ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'enable-tax','tax_id'=>$item->getIdentity()), 'courses_dashboard', true), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('class'=>'courses_tax_enadisable','title' => $this->translate('Disable Tax')))) ?>
                            </td>
                        <?php else: ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'enable-tax','tax_id'=>$item->getIdentity()), 'courses_dashboard', true), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('class'=>'courses_tax_enadisable','title' => $this->translate('Enable Tax')))) ?>
                            </td>
                        <?php endif; ?>
                        <td class="table_options centerT">
                            <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'manage-locations','tax_id'=>$item->getIdentity()), 'courses_dashboard', true), $this->translate(""), array('class' => 'fa fa-globe courses_dashboard_nopropagate_content sesbasic_button','title'=>$this->translate("Manage Locations"))) ?>
                            <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'edit-tax','tax_id'=>$item->getIdentity()), 'courses_dashboard', true), $this->translate(""), array('class' => 'fa fa-pencil openSmoothbox sesbasic_button','title'=>$this->translate("Edit"))) ?>
                            <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'delete-tax','tax_id'=>$item->getIdentity()), 'courses_dashboard', true), $this->translate(""), array('class' => 'courses_ajax_delete fa fa-trash  sesbasic_button','data-value'=>'Are you sure want to delete this tax? It will not be recoverable after being deleted.','title'=>$this->translate("Delete"))) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="buttons fleft clr" style="margin-top: 10px;">
                    <button type="submit"><?php echo $this->translate("Delete Selected"); ?></button>
                </div>
                <?php echo $this->paginationControl($this->taxes, null, array("_pagging.tpl", "courses"),array('identityWidget'=>'manage_taxes')); ?>
            </form>
        </div>
        <?php else: ?>
          <div class="tip">
            <span>
              <?php if(!$this->is_search_ajax){ ?>
                <?php
                      echo $this->translate('You have not added any tax for your course yet. Get started by <a href="'. $this->url(array('course_id' => $this->course->custom_url,'action'=>'create-tax'), 'courses_dashboard', true).'" class="openSmoothbox">creating</a> one.');
                  }else{
                      echo $this->translate('No Tax were found matching your selection.');
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
            'url':  "<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'taxes'), 'courses_dashboard', true); ?>",
            'data': {
                format: 'html',
                is_ajax : 1,
                page:pageNum,
            },
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
                sesJqueryObject('.courses_dashboard_content').html(responseHTML);
            }
        }));
        requestPagging.send();
        return false;
    }
</script>
