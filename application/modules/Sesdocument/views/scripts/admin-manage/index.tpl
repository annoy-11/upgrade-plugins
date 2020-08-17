
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<script type="text/javascript">
  var currentOrder = '<?php echo $this->order ?>';
  var currentOrderDirection = '<?php echo $this->order_direction ?>';
  var changeOrder = function(order, default_direction){
    // Just change direction
    if( order == currentOrder ) {
      $('order_direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
    } else {
      $('order').value = order;
      $('order_direction').value = default_direction;
    }
    $('filter_form').submit();
  }

  function multiDelete() {
    return confirm("<?php echo $this->translate('Are you sure you want to delete the selected documents?');?>");
  }

  function selectAll() {
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length; i++) {
      if (!inputs[i].disabled) {
        inputs[i].checked = inputs[0].checked;
      }
    }
  }

</script>

<?php include APPLICATION_PATH .  '/application/modules/Sesdocument/views/scripts/dismiss_message.tpl';?>

<h3><?php echo $this->translate("Manage Documents") ?></h3>
<p><?php echo $this->translate('This page lists all of the documents your users have created. You can use this page to monitor these documents and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific document. Leaving the filter fields blank will show all the documents on your social network. <br /> Below, you can also choose any number of documents as Documents of the Day, Featured, Sponsored, Verified. You can also Approve and Disapprove documents.'); ?></p>
<br />

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s fdocument found.', '%s documents found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>

  
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="admin_table_form">
      <table class='admin_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('sesdocument_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('user_id', 'ASC');"><?php echo $this->translate("Owner") ?></a></th>
            <th><a href="javascript:void(0);"><?php echo $this->translate("Category"); ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('is_approved', 'ASC');" title="Approved"><?php echo $this->translate("A") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('featured', 'ASC');" title="Featured"><?php echo $this->translate("F") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('sponsored', 'ASC');" title="Sponsored"><?php echo $this->translate("S") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('verified', 'ASC');" title="Verified"><?php echo $this->translate("V") ?></a></th>
            <th align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('offtheday', 'ASC');" title="Of the Day"><?php echo $this->translate("OTD") ?></a></th>
            <th><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'ASC');"><?php echo $this->translate("Creation Date") ?></a></th>

            <th><?php echo $this->translate("Options") ?></th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $item): ?>
          <tr>
            <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->sesdocument_id;?>' value="<?php echo $item->sesdocument_id; ?>" /></td>
            <td><?php echo $item->sesdocument_id ?></td>
            <td><?php echo $this->htmlLink($item->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),16)), array('title' => $item->getTitle(), 'target' => '_blank')) ?></td>
            <td><?php echo $this->htmlLink($item->getOwner()->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getOwner()->getTitle(),16)), array('title' => $this->translate($item->getOwner()->getTitle()), 'target' => '_blank')) ?></td>
       
            <td>
              <?php  
              $catgoryId = $item->category_id;

              $category = Engine_Api::_()->getItem('sesdocument_category', $catgoryId);
              echo $category->category_name; ?>
            </td>
            <td class="admin_table_centered">
              <?php if($item->is_approved == 1):?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'approved', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unapprove')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'approved', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Approve')))) ?>
              <?php endif; ?>
            </td>

            <td class="admin_table_centered">
             <?php if($item->is_approved == 1){?>
              <?php if($item->featured == 1):?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'featured', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Featured')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => '-manage', 'action' => 'featured', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Featured')))) ?>
              <?php endif; ?>
              <?php }else{ ?>
                  -
              <?php } ?>
            </td>
            <td class="admin_table_centered">
            <?php if($item->is_approved == 1){?>
              <?php if($item->sponsored == 1):?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'sponsored', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Sponsored')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'sponsored', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Sponsored')))) ?>
              <?php endif; ?>
              <?php }else{ ?>
                  -
              <?php } ?>          
            </td>
            <td class="admin_table_centered">
             <?php if($item->is_approved == 1){?>
              <?php if($item->verified == 1): ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'verify', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Verified')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'verify', 'id' => $item->sesdocument_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Verified')))) ?>
            <?php endif; ?>
            <?php }else{ ?>
                  -
              <?php } ?> 
            </td>
            <td class="admin_table_centered">
          <?php if($item->is_approved == 1){?>
          <?php if(strtotime($item->enddate) < strtotime(date('Y-m-d')) && $item->offtheday == 1){ 
                    Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument')->update(array(
                        'offtheday' => 0,
                        'startdate' =>'',
                        'enddate' =>'',
                      ), array(
                        "sesdocument_id = ?" => $item->sesdocument_id,
                      ));
                      $itemofftheday = 0;
               }else
                $itemofftheday = $item->offtheday; ?>
              <?php if($itemofftheday == 1):?>  
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'oftheday', 'id' => $item->sesdocument_id, 'type' => 'sesdocument', 'param' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Edit Document of the Day'))), array('class' => 'smoothbox')); ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'oftheday', 'id' => $item->sesdocument_id, 'type' => 'sesdocument', 'param' => 1), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Make Document of the Day'))), array('class' => 'smoothbox')) ?>
              <?php endif; ?>
              <?php }else{ ?>
                  -
              <?php } ?> 
            </td>
            <td><?php echo $item->creation_date ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'view', 'id' => $item->sesdocument_id), $this->translate("View Details"), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink($item->getHref(), $this->translate("View"), array('target' => '_blank')); ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdocument', 'controller' => 'manage', 'action' => 'delete', 'id' => $item->sesdocument_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <br />
    <div class='buttons'>
      <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
  </form>
  <br/>
  <div>
    <?php echo $this->paginationControl($this->paginator,null,null,$this->urlParams); ?>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no document created by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>
<script type="text/javascript">
  function showSubCategory(cat_id) {
    var url = en4.core.baseUrl + 'sesdocuments/index/subcategory/category_id/' + cat_id;
    en4.core.request.send(new Request.HTML({
      url: url,
      data: {
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "inline-block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "none";
            $('subcat_id').innerHTML = '';
          }
        }
      }
    }));
  }
function showSubSubCategory(cat_id) {

    var url = en4.core.baseUrl + 'sesdocuments/index/subsubcategory/subcategory_id/' + cat_id;

    en4.core.request.send(new Request.HTML({
      url: url,
      data: {
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "inline-block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
        } else {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }));
  }
  window.addEvent('domready', function() {
    if ($('category_id') && $('category_id').value == 0)
     $('subcat_id-wrapper').style.display = "none";   
		if ($('subcat_id') && $('subcat_id').value == 0)
     $('subsubcat_id-wrapper').style.display = "none"; 
  });
</script>
