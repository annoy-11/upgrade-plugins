<?php include APPLICATION_PATH .  '/application/modules/Sesblog/views/scripts/dismiss_message.tpl';?>


<?php if( !empty($this->error) ): ?>
  <ul class="form-errors">
    <li>
      <?php echo $this->error ?>
    </li>
  </ul>

  <br />
<?php /*return; */ endif; ?>


<div>
  <?php echo $this->htmlLink(array('action' => 'create', 'reset' => false), $this->translate('Add Package'), array(
    'class' => 'buttonlink icon_plan_add',
  )) ?>
</div>

<br />


<?php //if( $this->paginator->getTotalItemCount() > 0 ): ?>
  <script type="text/javascript">
    var currentOrder = '<?php echo $this->filterValues['order'] ?>';
    var currentOrderDirection = '<?php echo $this->filterValues['direction'] ?>';
    var changeOrder = function(order, default_direction){
      // Just change direction
      if( order == currentOrder ) {
        $('direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
      } else {
        $('order').value = order;
        $('direction').value = default_direction;
      }
      $('filter_form').submit();
    }
  </script>

  <div class='admin_search'>
    <?php echo $this->formFilter->render($this) ?>
  </div>
  
  <br />
<?php //endif; ?>



<div class='sesbasic_search_reasult'>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s plan found", "%s plans found", $count), $count) ?>  
</div>

<br />

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
   <div class="sesbasic_manage_table">
   <?php $class = ( $this->order == 'package_id' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->direction) : '' ) ?>
          	<div class="sesbasic_manage_table_head <?php echo $class ?>" style="width:100%;">
              <div style="width:5%">
              <a href="javascript:void(0);" onclick="javascript:changeOrder('package_id', 'DESC');">
                <?php echo "Id";?>
               </a>
              </div>
              <?php $class = ( $this->order == 'title' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->direction) : '' ) ?>
              <div style="width:20%" class="admin_table_centered <?php echo $class ?>">
               <a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');">
               	<?php echo $this->translate("Title") ?>
               </a>
              </div>
              <?php $class = ( $this->order == 'price' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->direction) : '' ) ?>
              <div style="width:5%" class="admin_table_centered <?php echo $class ?>">
              	<a href="javascript:void(0);" onclick="javascript:changeOrder('price', 'DESC');">
              	 <?php echo $this->translate("Price") ?>
                </a>
              </div>
              <div style="width:20%"  class="admin_table_centered">
               <?php echo $this->translate("Billing Cycle") ?>
              </div>
               <?php $class = ( $this->order == 'enabled' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->direction) : '' ) ?>
              <div style="width:10%"  class="admin_table_centered">
              <a href="javascript:void(0);" onclick="javascript:changeOrder('enabled', 'DESC');">
               <?php echo $this->translate("Enabled") ?>
               </a>
              </div> 
              
               <?php $class = ( $this->order == 'enabled' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->direction) : '' ) ?>
              <div style="width:10%"  class="admin_table_centered">
              <a href="javascript:void(0);" onclick="javascript:changeOrder('highlight', 'DESC');">
               <?php echo $this->translate("Highlighted") ?>
               </a>
              </div>
              
               <?php $class = ( $this->order == 'enabled' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->direction) : '' ) ?>
              <div style="width:10%"  class="admin_table_centered">
              <a href="javascript:void(0);" onclick="javascript:changeOrder('show_upgrade', 'DESC');">
               <?php echo $this->translate("In Upgrade") ?>
               </a>
              </div>
                           
              <div style="width:10%" class="admin_table_centered">
               <?php echo $this->translate("Total Blogs") ?>
              </div>
              <div style="width:10%">
               <?php echo $this->translate("Options"); ?>
              </div>  
            </div>
          	<ul class="sesbasic_manage_table_list" id='menu_list' style="width:100%;">
            <?php foreach ($this->paginator as $item) : ?>
              <li class="item_label" id="package_<?php echo $item->package_id ?>">
                <div style="width:5%;" class="admin_table_centered">
                  <?php echo $item->package_id ?>
                </div>
                <div style="width:20%;" class="admin_table_centered">
                  <?php echo $item->title ?>
                </div>
                <div style="width:5%;" class="admin_table_centered">
                	<?php echo $this->locale()->toNumber($item->price) ? $this->locale()->toNumber($item->price) : 'FREE' ?>
                </div>
                <div style="width:20%;" class="admin_table_centered">
                	<?php echo $item->getPackageDescription() ?>
                </div>
                <div style="width:10%;" class="admin_table_centered">
                <?php if($item->default != 1){ ?>
                 	<?php if($item->enabled == 1):?>
               <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesblogpackage', 'controller' => 'package', 'action' => 'approved', 'package_id' => $item->package_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Disabled')))) ?>
	  <?php else: ?>
	    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesblogpackage', 'controller' => 'package', 'action' => 'approved', 'package_id' => $item->package_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Enabled')))) ?>
	  <?php endif; ?>
                 <?php }else{ ?>
                 	-
                 <?php  } ?>
                </div>
                
                <div style="width:10%;" class="admin_table_centered">
                <?php if($item->default != 1){ ?>
                 	<?php if($item->highlight == 1):?>
               <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesblogpackage', 'controller' => 'package', 'action' => 'highlight', 'package_id' => $item->package_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unhighlight')))) ?>
	  <?php else: ?>
	    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesblogpackage', 'controller' => 'package', 'action' => 'highlight', 'package_id' => $item->package_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Highlight')))) ?>
	  <?php endif; ?>
                 <?php }else{ ?>
                 	-
                 <?php  } ?>
                </div>
                
                <div style="width:10%;" class="admin_table_centered">
                <?php if($item->default != 1){ ?>
                 	<?php if($item->show_upgrade == 1):?>
               <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesblogpackage', 'controller' => 'package', 'action' => 'show-upgrade', 'package_id' => $item->package_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Hide from upgrade section')))) ?>
	  <?php else: ?>
	    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesblogpackage', 'controller' => 'package', 'action' => 'show-upgrade', 'package_id' => $item->package_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Show in upgrade section')))) ?>
	  <?php endif; ?>
                 <?php }else{ ?>
                 	-
                 <?php  } ?>
                </div>
                
                <div style="width:10%;" class="admin_table_centered">
                  <?php echo $this->locale()->toNumber(@$this->blogCounts[$item->package_id]) ?>
                </div>                   
                  
                <div style="width:10%;" class="admin_table_centered">          
                 <a href='<?php echo $this->url(array('action' => 'edit', 'package_id' => $item->package_id)) ?>'>
                    <?php echo $this->translate("edit") ?>
                  </a>
                  <?php if(empty($this->blogCounts[$item->package_id]) && $item->default != 1){ ?>
                    |
                    <a href='<?php echo $this->url(array('action' => 'delete', 'package_id' => $item->package_id,'format'=>'smoothbox')) ?>' class="smoothbox">
                    <?php echo $this->translate("delete") ?>
                  </a>
            		<?php } ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          </div>
     <?php else:?>
    <div class="tip">
      <span>
        <?php echo "No Package create yet.";?>
      </span>
    </div>
<?php endif; ?>
<div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'query' => $this->filterValues,
      'pageAsQuery' => true,
    )); ?>
  </div>
<script type="text/javascript"> 
  
  var SortablesInstance;

  window.addEvent('load', function() {
    SortablesInstance = new Sortables('menu_list', {
      clone: true,
      constrain: false,
      handle: '.item_label',
      onComplete: function(e) {
        reorder(e);
      }
    });
  });

 var reorder = function(e) {
     var menuitems = e.parentNode.childNodes;
     var ordering = {};
     var i = 1;
     for (var menuitem in menuitems)
     {
       var child_id = menuitems[menuitem].id;

       if ((child_id != undefined))
       {
         ordering[child_id] = i;
         i++;
       }
     }
 
    ordering['format'] = 'json';

    //Send request
    var url = '<?php echo $this->url(array("action" => "order")) ?>';
    var request = new Request.JSON({
      'url' : url,
      'method' : 'POST',
      'data' : ordering,
      onSuccess : function(responseJSON) {
      }
    });
    request.send();
  }
</script>