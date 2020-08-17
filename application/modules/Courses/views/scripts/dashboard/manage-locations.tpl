<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-locations.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
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
        <h3><?php echo $this->translate('Manage Locations') ?> </h3>
        <p><?php echo $this->translate("Below, you can manage your course locations on which tax will apply."); ?></p>
        <br />
          <?php if(empty($this->isreturn) && !$this->is_admin){ ?>
            <a class="fa fa-plus courses_link_btn sesbasic_button openSmoothbox" href="<?php echo $this->url(array('course_id' => $this->course->custom_url,'tax_id'=>$this->tax_id,'action'=>'create-location'), 'courses_dashboard', true); ?>"><?php echo $this->translate('Add Location');?></a>
          <?php } ?>
    </div>
    <?php endif;?>
    <div id="courses_manage_taxes_content" style="position: relative;">
        <?php if( count($this->paginator) > 0): ?>
        <div class="courses_content_count">
            <?php echo  $this->translate(array('%s location found', '%s locations found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
        </div>
        <div class="courses_dashboard_table sesbasic_bxs">
            <form method="post" id="multidelete_form" onsubmit="return multiDelete();" >
                <table>
                    <thead>
                    <tr>
                        <th class="centerT">
                            <input type="checkbox" value="0" onclick="selectAll()">
                        </th>
                        <th class="centerT"><?php echo $this->translate("Country"); ?></th>
                        <th class="centerT"><?php echo $this->translate("State") ?></th>
                        <th class="centerT"><?php echo $this->translate("Tax Rate") ?></th>
                        <th class="centerT"><?php echo $this->translate("Status") ?></th>
                        <th class="centerT"><?php echo $this->translate("Creation Date") ?></th>
                        <th class="centerT"><?php echo $this->translate("Options") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($this->paginator as $item): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="delete_<?php echo $item->getIdentity(); ?>" value="<?php echo $item->getIdentity(); ?>" class="courses_select_all">
                        </td>
                        <td class="centerT"><?php echo $item->country_id ? Engine_Api::_()->getItem('courses_country',$item->country_id)->name : "All Countries"; ?></td>
                        <td class="centerT"><?php echo $item->state_id ? Engine_Api::_()->getItem('courses_state',$item->state_id)->name : "All States"; ?></td>
                       <td class="centerT">
                           <?php
                                echo $item->tax_type ? $item->value.'%' : Engine_Api::_()->courses()->getCurrencyPrice($item->value,Engine_Api::_()->courses()->getCurrentCurrency(),'');
                           ?>
                       </td>
                        <?php if (!empty($item->status)): ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'courses_dashboard', 'action' => 'enable-location-tax','course_id'=>$this->course->custom_url, 'tax_id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('class'=>'courses_tax_enadisable','title' => $this->translate('Disable Tax')))) ?>
                            </td>
                        <?php else: ?>
                            <td align="center" class="centerT">
                              <?php echo $this->htmlLink(array('route' => 'courses_dashboard', 'action' => 'enable-location-tax','course_id'=>$this->course->custom_url, 'tax_id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('class'=>'courses_tax_enadisable','title' => $this->translate('Enable Tax')))) ?>
                            </td>
                        <?php endif; ?>
                        <td class="centerT">
                            <?php echo $this->locale()->toDateTime($item->creation_date) ?>
                        </td>
                        <td class="table_options centerT">
                            <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'create-location','id'=>$item->getIdentity()), 'courses_dashboard', true), $this->translate(""), array('class' => 'fa fa-pencil openSmoothbox','title'=>$this->translate("Edit"))) ?>
                            <?php echo $this->htmlLink($this->url(array('course_id' => $this->course->custom_url,'action'=>'delete-location-tax','tax_id'=>$item->getIdentity()), 'courses_dashboard', true), $this->translate(""), array('class' => 'courses_ajax_delete fa fa-trash','data-value'=>'Are you sure want to delete this tax? It will not be recoverable after being deleted.','title'=>$this->translate("Delete"))) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(empty($this->is_admin)){ ?>
                <div class="buttons fleft clr" style="margin-top: 10px;">
                    <button type="submit"><?php echo $this->translate("Delete Selected"); ?></button>
                </div>
                <?php } ?>
                <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "courses"),array('identityWidget'=>'manage_locations')); ?>
            </form>
        </div>
        <?php else: ?>
        <div class="tip">
      <span>
      	<?php if(!$this->is_search_ajax){ ?>
          <?php
                echo $this->translate('Admin have not added any location yet.');
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
          'url':  "<?php echo $this->url(array('course_id' => $this->course->custom_url,'action'=>'manage-locations','tax_id'=>$this->tax_id,'is_admin'=>$this->is_admin), 'courses_dashboard', true); ?>",
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
