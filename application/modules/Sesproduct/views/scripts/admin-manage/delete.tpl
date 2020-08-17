<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<form method="post" class="global_form_popup">
<div>
  <h3><?php echo $this->translate("Delete Product?") ?></h3>
  <p>
    <?php echo $this->translate("Are you sure that you want to delete this product entry? It will not be recoverable after being deleted.") ?>
  </p>
  <br />
  <p>
    <input type="hidden" name="confirm" value="<?php echo $this->product_id?>"/>
    <button type='submit'><?php echo $this->translate("Delete") ?></button>
    <?php echo $this->translate(" or ") ?> 
    <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'>
    <?php echo $this->translate("cancel") ?></a>
  </p>
</div>
  </form>

<?php if( @$this->closeSmoothbox ): ?>
<script type="text/javascript">
  TB_close();
</script>
<?php endif; ?>
