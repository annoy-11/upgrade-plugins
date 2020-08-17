<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: billing.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="courses_checkout_body" >
    <?php echo $this->form->render($this); ?>
</div>
<style>
    .courses_required{
        color:red;
    }
    .error-message{
        display:none;
        font-size: 85%;
        margin:5px 0;
    }
</style>
<script type="application/javascript">
    
    sesJqueryObject(document).ready(function (e) {
        sesJqueryObject('#country').trigger('onchange');
    });
    function getStates(value,id,selectedVal) { 
        sesJqueryObject.post('courses/cart/get-state',{country_id:value,selected:selectedVal},function (response) { 
            sesJqueryObject('#'+id).removeAttr('data-rel');
            sesJqueryObject('#'+id).html(response);
        })
    }
</script>
