<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: list.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2>
  <?php echo $this->translate('Recent Entries')?>
</h2>

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
  <ul class='sesproducts_entrylist'>
  <?php foreach ($this->paginator as $item): ?>
    <li>
      <span>
        <h3>
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
        </h3>
        <div class="sesproduct_entrylist_entry_date">
         <?php echo $this->translate('by');?> <?php echo $this->htmlLink($item->getParent(), $item->getParent()->getTitle()) ?>
          <?php echo $this->timestamp($item->publish_date) ?>
        </div>
        <div class="sesproduct_entrylist_entry_body">
          <?php echo $this->string()->truncate($this->string()->stripTags($item->body), 300) ?>
        </div>
        <?php if ($item->comment_count > 0) :?>          
          <?php echo $this->htmlLink($item->getHref(), $this->translate(array('%s comment', '%s comments', $this->comment_count), $this->locale()->toNumber($this->comment_count)) , array('class' => 'buttonlink icon_comments')) ?>
        <?php endif; ?>
      </span>
    </li>
  <?php endforeach; ?>
  </ul>

<?php elseif( $this->category || $this->tag ): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('%1$s has not published a product entry with that criteria.', $this->owner->getTitle()); ?>
    </span>
  </div>

<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('%1$s has not written a product entry yet.', $this->owner->getTitle()); ?>
    </span>
  </div>
<?php endif; ?>

<?php echo $this->paginationControl($this->paginator, null, null, array(
  'pageAsQuery' => true,
  'query' => $this->formValues,
  //'params' => $this->formValues,
)); ?>


<script type="text/javascript">
  $$('.core_main_sesproduct').getParent().addClass('active');
</script>
