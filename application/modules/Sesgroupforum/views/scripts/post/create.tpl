<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
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
<?php echo $this->htmlLink(array('route'=>'sesgroupforum_general'), $this->translate("Sesgroupforums"));?>
  &#187; <?php echo $this->htmlLink(array('route'=>'sesgroupforum', 'forum_id'=>$this->sesgroupforum->getIdentity()), $this->sesgroupforum->getTitle());?>
  &#187; <?php echo $this->htmlLink(array('route'=>'sesgroupforum_topic', 'topic_id'=>$this->topic->getIdentity()), $this->topic->getTitle());?>
  &#187 <?php echo $this->translate('Post Reply');?>
</h2>
<?php echo $this->form->render($this) ?>
