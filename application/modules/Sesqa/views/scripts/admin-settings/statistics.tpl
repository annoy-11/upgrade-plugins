<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesqa/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings'>
    <?php //echo $this->form->render($this); ?>
  </div>
</div>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Question Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Questions created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Questions:" ?></strong></td>
            <td><?php echo $this->questions; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Questions:" ?></strong></td>
            <td><?php echo $this->featuredquestions; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Questions:" ?></strong></td>
            <td><?php echo $this->sponquestions; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Hot Questions:" ?></strong></td>
            <td><?php echo $this->hotquestions; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Questions:" ?></strong></td>
            <td><?php echo $this->veriquestions; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Questions:" ?></strong></td>
            <td><?php echo $this->favquestions; ?></td>
          </tr>
          
          <tr>
            <td><strong class="bold"><?php echo "Total Open Questions:" ?></strong></td>
            <td><?php echo $this->opnquestions; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Closed Questions:" ?></strong></td>
            <td><?php echo $this->closequestions; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Liked Questions:" ?></strong></td>
            <td><?php echo $this->totalLikes; ?></td>
          </tr>   
          
          <tr>
            <td><strong class="bold"><?php echo "Total Answered Questions:" ?></strong></td>
            <td><?php echo $this->totalAnswer; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Followed Questions:" ?></strong></td>
            <td><?php echo $this->followAnswer; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Voted Questions:" ?></strong></td>
            <td><?php echo $this->voteAnswer; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Down Voted Questions:" ?></strong></td>
            <td><?php echo $this->downvote; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Upvoted Questions:" ?></strong></td>
            <td><?php echo $this->upvote; ?></td>
          </tr> 
           
          
        </tbody>
      </table>
    </div>
  </form>
</div>