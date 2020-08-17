
<?php include APPLICATION_PATH .  '/application/modules/Sesdocument/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Documents Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Documents created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total documents:" ?></strong></td>
            <td><?php echo $this->totaldocument ? $this->totaldocument : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved documents:" ?></strong></td>
            <td><?php echo $this->totalapproveddocument ? $this->totalapproveddocument : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured documents:" ?></strong></td>
            <td><?php echo $this->totaldocumentfeatured ? $this->totaldocumentfeatured : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored documents:" ?></strong></td>
            <td><?php echo $this->totaldocumentsponsored ? $this->totaldocumentsponsored : 0; ?></td>
          </tr>
        
          <tr>
            <td><strong class="bold"><?php echo "Total Verified documents:" ?></strong></td>
            <td><?php echo $this->totaldocumentverified ? $this->totaldocumentverified : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite documents:" ?></strong></td>
            <td><?php echo $this->totaldocumentfavourite ? $this->totaldocumentfavourite : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?></strong></td>
            <td><?php echo $this->totaldocumentcomments ? $this->totaldocumentcomments : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?></strong></td>
            <td><?php echo $this->totaldocumentviews ? $this->totaldocumentviews : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?></strong></td>
            <td><?php echo $this->totaldocumentlikes ? $this->totaldocumentlikes : 0; ?></td>
          </tr> 
        
        </tbody>
      </table>
    </div>
  </form>
</div>