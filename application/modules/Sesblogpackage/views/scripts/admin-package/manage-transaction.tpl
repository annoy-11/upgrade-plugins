<?php include APPLICATION_PATH .  '/application/modules/Sesblog/views/scripts/dismiss_message.tpl';?>


<?php if( !empty($this->error) ): ?>
  <ul class="form-errors">
    <li>
      <?php echo $this->error ?>
    </li>
  </ul>

  <br />
<?php /*return; */ endif; ?>

<div class='admin_search'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<div class='sesbasic_search_reasult'>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s transaction found", "%s transactions found", $count), $count) ?>  
</div>

<br />

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
   	<table class='admin_table'>
    <thead>
      <tr>
        <th style='width: 1%;' >
          <a href="javascript:void(0);">
            <?php echo $this->translate("ID") ?>
          </a>
        </th>
        <th >
          <a href="javascript:void(0);">
            <?php echo $this->translate("Blog Id") ?>
          </a>
        </th>
        <th >
          <a href="javascript:void(0);">
            <?php echo $this->translate("Blog Title") ?>
          </a>
        </th>
        <th >
          <a href="javascript:void(0);">
            <?php echo $this->translate("User Name") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("Gateway") ?>
          </a>
        </th>
        
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("State") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("Amount") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_centered'>
          <a href="javascript:void(0);">
            <?php echo $this->translate("Date") ?>
          </a>
        </th>
        <th style='width: 1%;' class='admin_table_options'>
          <?php echo $this->translate("Options") ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $this->paginator as $item ):
        $user = Engine_Api::_()->getItem('user',$item->owner_id);
        $blog = Engine_Api::_()->getItem('sesblog_blog',$item->owner_id);
        $package = Engine_Api::_()->getItem('sesblogpackage_package',$item->package_id);
        ?>
        <tr>
          <td><?php echo $item->transaction_id ?></td>
           <td><?php echo $item->blog_id ?></td>
           <td>
         	<a href="<?php echo $blog->getHref(); ?>"  target='_blank' title="<?php echo  ucfirst($blog->getTitle()) ?>">
						<?php echo $this->translate(Engine_Api::_()->sesbasic()->textTruncation($blog->getTitle(),25)) ?></a>
           </td>
           <td class='admin_table_bold'>
            <?php echo $user->__toString(); ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $item->gateway_type; ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $this->translate(ucfirst($item->state)) ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $package->getPackageDescription(); ?>
          </td>
          <td class='admin_table_centered'>
            <?php echo $this->locale()->toDateTime($item->creation_date) ?>
          </td>
          <td class='admin_table_options'>
            <a class="smoothbox" href='<?php echo $this->url(array('action' => 'detail', 'transaction_id' => $item->transaction_id, 'blog_id' => $item->blog_id));?>'>
              <?php echo $this->translate("details") ?>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
     <?php else:?>
    <div class="tip">
      <span>
        <?php echo "No Transaction found yet.";?>
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