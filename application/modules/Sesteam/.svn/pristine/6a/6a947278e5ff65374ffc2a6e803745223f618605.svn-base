<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _browseUsers.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(count($this->users) > 0):  ?>
<?php if($this->template_settings == 1): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/members/_teamtemplate1.tpl'; ?> 
  <?php elseif($this->template_settings == 2): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/members/_teamtemplate2.tpl'; ?>
  <?php elseif($this->template_settings == 3): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/members/_teamtemplate3.tpl'; ?>
  <?php elseif($this->template_settings == 4): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/members/_teamtemplate4.tpl'; ?>
  <?php elseif($this->template_settings == 5): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/members/_teamtemplate5.tpl'; ?>
  <?php elseif($this->template_settings == 6): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/members/_teamtemplate6.tpl'; ?>
<?php endif; ?>

<?php if( $this->users ):
    $pagination = $this->paginationControl($this->users, null, null, array(
      'pageAsQuery' => true,
      'query' => $this->formValues,
    ));
  ?>
  <?php if( trim($pagination) ): ?>
    <div class='browsemembers_viewmore' id="browsemembers_viewmore">
      <?php echo $pagination ?>
    </div>
  <?php endif ?>
<?php endif; ?>
<script type="text/javascript">
  page = '<?php echo sprintf('%d', $this->page) ?>';
  totalUsers = '<?php echo sprintf('%d', $this->totalUsers) ?>';
  userCount = '<?php echo sprintf('%d', $this->userCount) ?>';
</script>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("Sorry, no results matching your search criteria were found.") ?>
    </span>
  </div>
<?php endif; ?>