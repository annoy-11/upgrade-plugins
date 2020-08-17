<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessiteiframe
 * @package    Sessiteiframe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: faq.tpl  2017-10-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sessiteiframe/views/scripts/dismiss_message.tpl';?>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
  </div>
<?php endif; ?>
<div class="sesbasic_faqs">
  <ul>
    <li>
      <div class="faq_ques"><?php echo $this->translate("Question: After upgrading my SocialEngine, music on my site is not playing continuously. What should I do?");?></a></div>
      <div class='faq_ans'>
        <?php echo $this->translate("Ans: As we informed you during the activation of this plugin that we have added 4 lines of code in 1 File of SocialEngine Core, so after the upgrade of SocialEngine, our code is lost from that file. Now, you need to add the code again into that file, and for that please follow steps below or use the automatic process which comes in the tip (tip is shown when the code is not there in the file.).");?><br /><br />
        <p style="float:right;"><?php echo "<a href='admin/sessiteiframe/settings/fix-default' class='sesbasic_button'>Update Code</a>"; ?></p>
        <br>
        <p><?php echo $this->translate("Follow the below steps to make this plugin work:"); ?></p>
        <p class="bold"><?php echo $this->translate("Step 1: Open below file:");?></p>
        <p><?php echo "File at path: '/application/modules/Core/layouts/scripts/default.tpl'"; ?></p><br />
        <p class="bold"><?php echo "Step 2: Insert below lines of code at the top of the opened file." ?></p>        
        <code class="codebox">
        <?php echo  '&lt;?php 
                      if(file_exists("application/modules/Sessiteiframe/views/scripts/Core/default.tpl")){
                        include("application/modules/Sessiteiframe/views/scripts/Core/default.tpl");
                      }
                      ?&gt;';
        ?>
        </code>        
      </div>
    </li>
  </ul>
</div>