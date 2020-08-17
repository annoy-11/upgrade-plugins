<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: victory.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<script>
    sesJqueryObject(document).ready(function () {
     if(confirm('Are you sure? Do you want to add this petition victory'))
     {
         var url=en4.core.baseUrl+"petitions/dashboard/victory/<?php echo $this->slug; ?>";
         sesJqueryObject.ajax({
             url: url,
             type: "POST",
             data: {id : '<?php echo $this->epetition_id; ?>'},
             dataType: "json",
             success: function(html)
             {
                 if(html['status'])
                 {
                     var newurl=en4.core.baseUrl+"petition/<?php echo $this->slug; ?>";
                     alert(html['msg']);
                     window.location.href=newurl;

                 }
             }
         });

     }
    });
</script>