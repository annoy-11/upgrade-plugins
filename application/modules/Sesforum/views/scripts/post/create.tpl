<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="text/javascript">
function showUploader()
{
  $('photo').style.display = 'block';
  $('photo-label').style.display = 'none';
}
</script>
<h2>
<?php echo $this->htmlLink(array('route'=>'sesforum_general'), $this->translate("Sesforums"));?>
  &#187; <?php echo $this->htmlLink(array('route'=>'sesforum_forum', 'forum_id'=>$this->sesforum->getIdentity()), $this->sesforum->getTitle());?>
  &#187; <?php echo $this->htmlLink(array('route'=>'sesforum_topic', 'topic_id'=>$this->topic->getIdentity()), $this->topic->getTitle());?>
  &#187 <?php echo $this->translate('Post Reply');?>
</h2>
<?php echo $this->form->render($this) ?>
