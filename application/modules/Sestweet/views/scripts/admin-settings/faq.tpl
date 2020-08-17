<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sestweet/views/scripts/dismiss_message.tpl'; ?>
<div class="sesbasic_faqs">
  <ul>
    <li>
      <div class="faq_ques"><?php echo $this->translate("Question: After upgrading my SocialEngine, I do not see TinyMce Editor on my website. What should I do?");?></a></div>
      <div class='faq_ans'>
        <?php echo $this->translate("Ans: As we informed you during the activation of the plugin that we need to update code in 2 files of SocialEngine’s Libraries, so after the upgrade of SocialEngine, our code is lost from those 2 files. So, now you need to add the code again into those files, and for that please use any of the 2 methods mentioned below:");?><br /><br />
        <p style="float:right;"><?php echo "<a href='admin/sestweet/settings/codewrite' class='sesbasic_button'>Update Code</a>"; ?></p>
        <p class="bold"><?php echo $this->translate("Method 1: Automatic Updation of code into the files.");?></p>
        <p><?php echo "If you have not done any custom work in the files: application >> libraries >> Engine >> View >> Helper >> FormTinyMce.php and application >> libraries >> Engine >> View >> Helper >> TinyMce.php, then you can use this method."; ?></p><br />
        <p class="bold"><?php echo "Method 2: Manual Updation of code into the files." ?></p>
        <p><?php echo "If you have done any custom work in the file: application >> libraries >> Engine >> View >> Helper >> FormTinyMce.php, then please write the code manually to make this plugin work:"; ?></p>
        <p><b class="bold">Step 1: </b> Open below file:</p>
        <p>File at path: 'application/libraries/Engine/View/Helper/FormTinyMce.php'</p>
        <p><b class="bold">Step 2: </b> Search the line of code as shown below:</p>
        <code class="codebox"><?php echo '$this'.'->view->tinyMce()->setOptions($attribs['."'editorOptions'".']);'; ?></code>
        <p><b class="bold">Step 3: </b> Replace the code in step 2 with the code mentioned below:</p>
        <code class="codebox">
          <?php echo '$this'.'->view->tinyMce()->setOptions($attribs['."'editorOptions'".']);'; ?><br />
          <?php echo '//Add Tweet Option'; ?><br />
          <?php echo 'if(!empty($attribs["editorOptions"]['."'toolbar1'".'])) {'; ?><br />
          <?php echo '$plugin = $attribs["editorOptions"];'; ?><br />
          <?php echo 'if(is_string($plugin["plugins"])) {'; ?><br />
          <?php echo '$plugin["plugins"] = $plugin["plugins"]'.'.",tweet";'; ?><br />
          <?php echo '$plugin["toolbar1"] = $plugin["plugins"];'; ?><br />
          <?php echo '} else {'; ?><br />
          <?php echo '$plugin["plugins"][] = "tweet";'; ?><br />
          <?php echo '$plugin["toolbar1"][] = "tweet";'; ?><br />
          <?php echo '}'; ?><br />
          <?php echo '$this->view->tinyMce()->setOptions($plugin);'; ?><br />
          <?php echo '}'; ?>
        </code>
        <p><b class="bold">Step 4: </b> Open below file:</p>
        <p>File at path: 'application/libraries/Engine/View/Helper/TinyMce.php'</p>
        <p><b class="bold">Step 5: </b> Search the line of code as shown below:</p>
        <code class="codebox"><?php echo "'searchreplace'"; ?></code>
        <p><b class="bold">Step 6: </b> Replace the code in step 5 with the code mentioned below:</p>
        <code class="codebox">
          <?php echo "'searchreplace','tweet'"; ?><br />
        </code>
      </div>
    </li>
  </ul>
</div>