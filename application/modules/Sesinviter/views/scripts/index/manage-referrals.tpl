<?php

?>
<script type="text/javascript">
function multiDelete()
{
  return confirm("<?php echo $this->translate('Are you sure you want to delete the selected entries?');?>");
}
function selectAll()
{
  var i;
  var multidelete_form = $('multidelete_form');
  var inputs = multidelete_form.elements;
  for (i = 1; i < inputs.length - 1; i++) {
    inputs[i].checked = inputs[0].checked;
  }
}
</script>
<script type="text/javascript">
  var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
  <form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
    <table class='table'>
      <thead>
        <tr>
          <th class=''><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
          <th class=''>ID</th>
          <th><?php echo $this->translate('Recipent Name') ?></th>
          <th><?php echo $this->translate('Recipent Email') ?></th>
          <th align="center"><?php echo $this->translate('Invite Type') ?></th>
          <th><?php echo $this->translate('Options') ?></th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($this->paginator as $item): ?>
            <tr>
              <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->invite_id;?>' value="<?php echo $item->invite_id ?>"/></td>
              <td><?php echo $item->invite_id ?></td>
              <?php if($item->new_user_id) { ?>
                <?php $recipentsender = Engine_Api::_()->getItem('user', $item->new_user_id); ?>
                <td><?php echo $this->htmlLink($recipentsender->getHref(), $recipentsender->getTitle()); ?></td>
              <?php } else { ?>
                <td><?php echo "---"; ?></td>
              <?php } ?>
              <td><?php echo $item->recipient_email; ?></td>
              <td><?php echo ucwords($item->import_method) ?></td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesinviter', 'controller' => 'index', 'action' => 'delete', 'id' => $item->invite_id), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
    <br/>
    <div class='buttons'>
      <button type='submit'>
        <?php echo $this->translate('Delete Selected') ?>
      </button>
    </div>
  </form>
  <?php elseif($this->search): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any entries that match your search criteria.');?>
      </span>
    </div>
  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any entries.');?>
      </span>
    </div>
  <?php endif; ?>
<?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>
<script type="text/javascript">
  $$('.core_main_sesinviter').getParent().addClass('active');
</script>
