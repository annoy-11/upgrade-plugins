<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sessportz/externals/styles/styles.css'); ?>

<div class="sessportz_landing_table sesbasic_bxs">
  <table class="results-table">
    <tbody>
      <tr class="table-row-title">
        <td class="tbl-td td-title"><?php echo $this->translate("POS"); ?></td>
        <td class="tbl-td td-title"><?php echo $this->translate("TEAM"); ?></td>
        <td class="tbl-td td-title"><?php echo $this->translate("W"); ?></td>
        <td class="tbl-td td-title"><?php echo $this->translate("D"); ?></td>
        <td class="tbl-td td-title"><?php echo $this->translate("L"); ?></td>
        <td class="tbl-td td-title"><?php echo $this->translate("PTS"); ?></td>
      </tr>
      <?php $i = 1; ?>
      <?php foreach($this->results as $result) { ?>
        <tr class="table-row even">
          <td class="tbl-td"><?php echo $i; ?></td>
          <td class="tbl-td td-team"><span class="tbl-logo-wrap"> <img src="<?php echo $result->getPhotoUrl(); ?>" alt=""> </span> <span class="table-team-name"><?php echo $result->name; ?></span></td>
          <td class="tbl-td"><?php echo !empty($result->wins) ? $result->wins : 0; ?></td>
          <td class="tbl-td"><?php echo !empty($result->draw) ? $result->draw : 0; ?></td>
          <td class="tbl-td"><?php echo !empty($result->loss) ? $result->loss : 0; ?></td>
          <td class="tbl-td"><?php echo !empty($result->points) ? $result->points : 0; ?></td>
        </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>
