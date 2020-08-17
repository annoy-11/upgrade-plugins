<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: deletedesignation.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<form method="post" class="global_form_popup">
  <div>
    <h3><?php echo $this->translate("Delete Designation?") ?></h3>
    <p>
      <?php echo $this->translate("Are you sure that you want to delete this designation? It will not be recoverable after being deleted.") ?>
    </p>
    <br />
    <p>
      <input type="hidden" name="confirm" value="<?php echo $this->designation_id ?>"/>
      <button type='submit'><?php echo $this->translate("Delete") ?></button>
      <?php echo $this->translate(" or ") ?> 
      <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'>
        <?php echo $this->translate("Cancel") ?>
      </a>
    </p>
  </div>	
</form>
<?php if (@$this->closeSmoothbox): ?>
  <script type="text/javascript">
    TB_close();
  </script>
<?php endif; ?>