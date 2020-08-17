<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: process.tpl  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<script type="text/javascript">
  window.addEvent('load', function(){
    var url = '<?php echo $this->transactionUrl ?>';
    window.location.href = url;
  });
</script>