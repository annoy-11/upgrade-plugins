<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-forum.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<script>
   function getSubCategory(value,id,selectedVal) { 
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem("category_id", value);
        } else {
            document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
        }
        sesJqueryObject.post('admin/sesforum/manage/sub-Category',{category_id:value,selected:selectedVal},function (response) { 
            sesJqueryObject('#'+id).removeAttr('data-rel');
            sesJqueryObject('#'+id).html(response);
            if(sesJqueryObject('#'+id).children().length > 1){
              sesJqueryObject('#subcat_id-wrapper').show();
            } else {
                 sesJqueryObject('#subcat_id-wrapper').hide();
            }
        })
    }
    function getSubSubCategory(value,id,selectedVal) { 
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem("subcat_id", value);
        } else {
            document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
        }
        sesJqueryObject.post('admin/sesforum/manage/sub-sub-Category',{subcat_id:value,selected:selectedVal},function (response) { 
            sesJqueryObject('#'+id).removeAttr('data-rel');
            sesJqueryObject('#'+id).html(response);
            if(sesJqueryObject('#'+id).children().length > 1){
              sesJqueryObject('#subsubcat_id-wrapper').show();
            } else {
                 sesJqueryObject('#subsubcat_id-wrapper').hide();
            }
        })
    }
    window.addEvent('domready',function(){
        sesJqueryObject('#subcat_id-wrapper').hide();
        sesJqueryObject('#subsubcat_id-wrapper').hide();
    });
</script>
