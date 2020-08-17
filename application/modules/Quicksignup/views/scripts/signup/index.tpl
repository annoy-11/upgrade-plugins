<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<h2>
    <?php echo ($this->title ? $this->translate($this->title) : '' );  ?>
</h2>



<?php
echo $this->partial($this->script[0], $this->script[1], array(
    'form' => $this->form
));
?>
