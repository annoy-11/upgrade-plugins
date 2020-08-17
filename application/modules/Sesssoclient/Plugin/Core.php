<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoclient
 * @package    Sesssoclient
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: COre.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesssoclient_Plugin_Core
{
    function get_domain($url)
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }
    public function onRenderLayoutDefault($event, $mode = null)
    {
        $domainName = str_replace('.','',$this->get_domain(trim($_SERVER["HTTP_HOST"],'/')));
        if(!empty($_COOKIE["SSOLoggedinUserId_".$domainName])) {
            Engine_Api::_()->user()->getAuth()->getStorage()->write($_COOKIE["SSOLoggedinUserId_".$domainName]);
            setcookie("SSOLoggedinUserId_".$domainName, 0, time() - (86400 * 30), "/",'.'.$this->get_domain($_SERVER["HTTP_HOST"]),
                false, false);
            //redirect user to same page
            header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
            exit();
        }
    }

    public function onRenderLayoutDefaultSimple($event)
    {
        // Forward
        return $this->onRenderLayoutDefault($event, 'simple');
    }

    public function onRenderLayoutMobileDefault($event)
    {
        // Forward
        return $this->onRenderLayoutDefault($event);
    }

    public function onRenderLayoutMobileDefaultSimple($event)
    {
        // Forward
        return $this->onRenderLayoutDefault($event);
    }
}