<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgrouppackage/externals/styles/styles.css'); ?>
<div class="sesbasic_clearfix sesgroup_packages_transactions_header">
	<h3 class="floatL"><?php echo $this->translate("View Transactions of Group Packages"); ?></h3>
	<a href="<?php echo $this->url(array('action' => 'package'),'sesgroup_general',true);?>" class="sesbasic_icon_back sesbasic_link_btn floatR"><?php echo $this->translate("Back to Package Group");?></a>
</div>
<div class="sesgroup_packages_transactions_table">
  <table>
    <thead>
      <tr>
        <th><a href="javascript:void(0);"><?php echo $this->translate('ID');?></a> </th>
        <th> <a href="javascript:void(0);"><?php echo $this->translate('Group ID');?></a></th>
        <th> <a href="javascript:void(0);"><?php echo $this->translate('Group Title');?></a> </th>
        <th> <a href="javascript:void(0);"><?php echo $this->translate('Package');?></a> </th>
        <th class="centerT"> <a href="javascript:void(0);"><?php echo $this->translate('Gateway');?></a> </th>
        <th class="centerT"> <a href="javascript:void(0);"><?php echo $this->translate('Status');?></a> </th>
        <th> <a href="javascript:void(0);"><?php echo $this->translate('Amount');?></a> </th>
        <th> <a href="javascript:void(0);"><?php echo $this->translate('Date');?></a> </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($this->paginator as $item):?>
        <?php $user = Engine_Api::_()->getItem('user',$item->owner_id);?>
        <?php $group = Engine_Api::_()->getItem('sesgroup_group',$item->group_id);?>
        <?php $package = Engine_Api::_()->getItem('sesgrouppackage_package',$item->package_id);?>
        <tr>
          <td><?php echo $item->transaction_id ?></td>
          <td><?php echo $item->group_id ?></td>
          <td><a href="<?php echo $group->getHref(); ?>"  target='_blank' title="<?php echo  ucfirst($group->getTitle()) ?>">
            <?php echo $this->translate(Engine_Api::_()->sesbasic()->textTruncation($group->getTitle(),25)) ?>
          </a>
          </td> 
          <td><?php echo $this->translate(Engine_Api::_()->sesbasic()->textTruncation($package->title,25)) ?></td>
          <td class="centerT"><?php echo $item->gateway_type; ?></td>
          <td class="centerT"><?php echo $this->translate(ucfirst($item->state)) ?></td>
          <td><?php echo $package->getPackageDescription(); ?></td>
          <td><?php echo $this->locale()->toDateTime($item->creation_date) ?></td>
        </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>