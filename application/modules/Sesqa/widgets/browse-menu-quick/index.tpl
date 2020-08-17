<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<button type="button" class="post_question"><?php echo $this->translate($this->title); ?></button>
<script type="application/javascript">

sesJqueryObject('.post_question').click(function(){
  var url = "<?php echo $this->url(array('action'=>'create'),'sesqa_general',true); ?>";
    window.location.href = url;
})
</script>
