<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-photo.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (!$this->is_ajax) {
echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition));
?>
<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
  <?php } ?>
    <div class="sesbasic_dashboard_form">
        <div class="epetition_edit_photo_petition">
          <?php echo $this->form->render() ?>
        </div>
    </div>
  <?php if (!$this->is_ajax) { ?>
</div>
    </div>
<?php } ?>


<script type="application/javascript">
    sesJqueryObject(document).on('submit', '#EditPhoto', function (e) {
        if (sesJqueryObject('#Filedata-label').find('label').hasClass('required') && sesJqueryObject('#Filedata').val() === '') {
            var objectError = sesJqueryObject('#Filedata');
            alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
            var errorFirstObject = sesJqueryObject(objectError).parent().parent();
            sesJqueryObject('html, body').animate({
                scrollTop: errorFirstObject.offset().top
            }, 2000);
            return false;
        }
    });
</script>