<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
			  <div class='settings sesbasic_admin_form'>
					<div class='settings'>
					  <form class="global_form">
					    <div>
					      <h3><?php echo $this->translate("Videos Statistics") ?> </h3>
					      <p class="description">
					        <?php echo $this->translate("Below are some valuable statistics for the Videos created on this site:"); ?>
					      </p>
					      <table class='admin_table' style="width: 50%;">
					        <tbody>
					          <tr>
					            <td><strong class="bold"> <?php echo "Total Business Videos:" ?></strong></td>
					            <td><?php echo $this->totalvideo; ?></td>
					          </tr>
					          <tr>
					            <td><strong class="bold"> <?php echo "Total Featured Videos:" ?></strong></td>
					            <td><?php echo $this->totalvideofeatured; ?></td>
					          </tr>
					          <tr>
					            <td><strong class="bold"> <?php echo "Total Sponsored Videos:" ?></strong></td>
					            <td><?php echo $this->totalvideosponsored; ?></td>
					          </tr>
					          <tr>
					            <td><strong class="bold"> <?php echo "Total Favourite Videos:" ?></strong></td>
					            <td><?php echo $this->totalvideofavourite; ?></td>
					          </tr>
					          <tr>
					            <td><strong class="bold"> <?php echo "Total Rated Videos:" ?></strong></td>
					            <td><?php echo $this->totalvideorated; ?></td>
					          </tr>          

					        </tbody>
					      </table>
					    </div>
					  </form>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>
