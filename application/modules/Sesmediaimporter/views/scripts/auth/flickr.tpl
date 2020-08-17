<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: flickr.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<style>
body{ display:none !important;}
</style>
<script type="application/javascript">
<?php if($this->success){ ?>
  //sesJqueryObject(document).ready(function(){
    <?php if(!empty($_SESSION['sesmediaadv_direct'])){ ?>
          window.location  =  '<?php echo $this->url(array("action"=>"service","type"=>"flickr"),"sesmediaimporter_general",true); ?>';
          //return;
    <?php  }else{ ?>
    window.opener.location.href = '<?php echo $this->url(array("action"=>"service","type"=>"flickr"),"sesmediaimporter_general",true); ?>';
    setTimeout(function(){
       window.close();
    }, 300);
    <?php } ?>
<?php }else{ ?>
    <?php if(!empty($_SESSION['sesmediaadv_direct'])){ ?>
          window.location  =  '<?php echo $this->url(array("action"=>"index"),"sesmediaimporter_general",true); ?>';
          return;
    <?php  } ?>
    window.close();
<?php } ?>
//});
</script>