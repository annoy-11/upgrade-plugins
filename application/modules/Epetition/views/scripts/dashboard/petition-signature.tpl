<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: petition-signature.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<!--  Side menu   -->
<?php if (!$this->is_ajax) {
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()
	->appendFile($base_url . 'externals/autocompleter/Observer.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
	->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');

echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition));
?>
<div class="epetition_create epetition_signature_dashboard sesbasic_dashboard_content sesbm sesbasic_clearfix">
  <?php } ?>
    <h3><?php echo $this->translate('Petition Signature'); ?></h3><br />
    <p><?php echo $this->translate('This page will display total signatures of this plugin and you can search the signatures based on the search criteria.'); ?></p><br />
    <?php   echo $this->form;  ?>

    <script type="text/javascript">

        function multiDelete()
        {
            return confirm("<?php echo $this->translate('Are you sure you want to delete the selected Petition entries?');?>");
        }

        function selectAll()
        {
            var i;
            var multidelete_form = $('multidelete_form');
            var inputs = multidelete_form.elements;
            for (i = 1; i < inputs.length; i++) {
                if (!inputs[i].disabled) {
                    inputs[i].checked = inputs[0].checked;
                }
            }
        }
    </script>



    <br />
    <br />

  <?php if( count($this->paginator) ): ?>
      <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
          <table class='admin_table' style="width: 100%">
              <thead>
              <tr>
                  <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
                  <th><?php echo $this->translate("Name"); ?></th>
                  <th><?php echo $this->translate("Support Statement"); ?></th>
                  <th><?php echo $this->translate("Date"); ?></th>
                  <th><?php echo $this->translate("Action"); ?></th>
              </tr>
              </thead>
              <tbody>
              <?php $c=0; foreach ($this->paginator as $item): ?>
                  <tr id="signature<?php echo $item->signature_id; ?>">
                    <?php $user = Engine_Api::_()->getItem('user', $item->owner_id); ?>
                      <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->signature_id; ?>' value="<?php echo $item->signature_id; ?>" /></td>
                      <td><?php echo isset($item->owner_id) && $item->owner_id>0 ?  "<a href=".$user->getHref().">".$this->translate($user->getTitle())."</a>" : $item->first_name." ".$item->last_name; ?></td>
                      <td><?php  echo  $this->translate($item->support_statement); ?></td>
                      <td><?php echo $this->translate(date("d/m/Y h:i A",strtotime($item->creation_date)));  ?></td>
                      <td>
                          <a class='sessmoothbox' href='<?php echo $this->url(array('action' => 'edit-dashboard-signature', 'id' => $item->signature_id));?>'>
                            <?php echo $this->translate("Edit"); ?>
                          </a>
                          |
                          <a class='sessmoothbox' href='<?php echo $this->url(array('action' => 'view-dashboard-signature', 'id' => $item->signature_id));?>'>
                            <?php echo $this->translate("view"); ?>
                          </a>
                          |
                          <a href='javaScript:void(0);' onclick='redirectfordelete("<?php echo $this->url(array('action' => 'delete-dashboard-signature'));?>","<?php echo $item->signature_id;?>")'>
                            <?php echo $this->translate("Delete"); ?>
                          </a>
                      </td>

                  </tr>
              <?php endforeach; ?>
              </tbody>
          </table>
          <br />
          <div class='buttons'>
              <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
          </div>
      </form>

      <br/>
      <div>
        <?php echo $this->paginationControl($this->paginator); ?>
      </div>

  <?php else: ?>
      <div class="tip">
    <span>
      <?php echo $this->translate("There are no signature entries for this petition.") ?>
    </span>
      </div>
  <?php endif; ?>
    <script>
        sesJqueryObject("#from_date").attr('type','date');
        sesJqueryObject("#from_date").attr('data-date','');
        sesJqueryObject("#from_date").attr('data-date-format','YYYY-mm-dd');
        sesJqueryObject("#to_date").attr('type','date');
        sesJqueryObject("#to_date").attr('data-date','');
        sesJqueryObject("#to_date").attr('data-date-format','YYYY-mm-dd');
        function redirectfordelete(url,id)
        {
            if(confirm('Are you sure to delete?'))
            {
                sesJqueryObject.ajax({
                    url: url,
                    type: "POST",
                    data: {id : id},
                    dataType: "json",
                    success: function(html) {
                        if (html['status']) {
                            sesJqueryObject("#signature"+id).remove();
                            alert(html['msg']);
                        }
                        else
                        {
                            alert(html['msg']);
                        }
                    }
                });
            }
        }
        function showAutosuggest(petitionAdmin, imageId) {
        var contentAutocomplete1 =  'contentAutocomplete-'+petitionAdmin
        contentAutocomplete1 = new Autocompleter.Request.JSON('name', "<?php echo $this->url(array('module' => 'epetition', 'controller' => 'dashboard', 'action' => 'get-members', 'epetition_id' => $this->petition->epetition_id), 'default', true) ?>", {
          'postVar': 'text',
          'minLength': 1,
          'selectMode': '',
          'autocompleteType': 'tag',
          'customChoices': true,
          'filterSubset': true,
          'maxChoices': 20,
          'cache': false,
          'multiple': false,
          'className': 'sesbasic-autosuggest',
          'indicatorClass':'input_loading',
          'injectChoice': function(token) {
            var choice = new Element('li', {
              'class': 'autocompleter-choices', 
              'html': token.photo, 
              'id':token.label
            });
            new Element('div', {
              'html': this.markQueryValue(token.label),
              'class': 'autocompleter-choice'
            }).inject(choice);
            this.addChoiceEvents(choice).inject(this.choices);
            choice.store('autocompleteChoice', token);
          }
        });
        contentAutocomplete1.addEvent('onSelection', function(element, selected, value, input) {
          if($('user_id').value != '')
          $('user_id').value = $('user_id').value+','+selected.retrieve('autocompleteChoice').id;
          else
          $('user_id').value = selected.retrieve('autocompleteChoice').id;
          sesJqueryObject('#'+petitionAdmin).attr('rel', selected.retrieve('autocompleteChoice').id);
          sesJqueryObject('#save_button_admin').removeAttr('disabled');
        });
      }
      en4.core.runonce.add(function() {
        showAutosuggest('name','show_default_img');
      });
    </script>
