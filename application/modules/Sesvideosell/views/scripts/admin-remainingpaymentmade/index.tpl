<?php

?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesvideosell/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Payments Made") ?></h3>
<p><?php echo $this->translate('This page lists all the payments which you made to the video owners for their videos sold from your website.'); ?></p>
<br />
<?php $counter = $this->paginator->getTotalItemCount(); ?> 
<?php if( count($this->paginator) ): ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s entry found.', '%s entries found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="clear" style="overflow:auto;">
    <table class='admin_table'>
      <thead>
        <tr>
          <th><?php echo $this->translate("Video Owner") ?></th>
          <th><?php echo $this->translate("Total Payment Made") ?></th>     
        </tr>
      </thead>
      <tbody>
        <?php foreach ($this->paginator as $item): ?>
          <?php $user = Engine_Api::_()->getItem('user',$item->user_id); 
            if(!$user)
              continue;
          ?>
          <tr>
            <td><a href="<?php echo $user->getHref(); ?>" target="_blank"><?php echo $user->getTitle(); ?></a></td>
            <td><?php echo $item->totalAmount; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
  </form>
  <br/>
  <div>
    <?php echo $this->paginationControl($this->paginator); ?>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("No payments have been made yet.") ?>
    </span>
  </div>
<?php endif; ?>
</div>