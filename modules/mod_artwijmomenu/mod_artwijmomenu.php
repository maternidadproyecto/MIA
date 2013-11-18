<?php
/*
 * Art Wijmo Menu
 *
 * @version		1.0.0
 * @author		Artetics
 * @copyright	Copyright (c) 2010 www.artetics.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 */

defined('_JEXEC') or die('Restricted access');
error_reporting(E_ERROR);
require_once(JPATH_SITE . DS . 'modules' . DS . 'mod_artwijmomenu' . DS . 'mod_artwijmomenu' . DS . 'helpers' . DS . 'artwijmomenuhelper.php');

global $Itemid;
$showHiddenMenuItems = $params->get('showHiddenMenuItems', false);
$menuType = $params->get('menuType', 'mainmenu');
$showType = $params->get('showType', 'ipod');
$orientation = $params->get('orientation', 'horizontal');
$trigger = $params->get('trigger', 'mouseenter');
$parentClickable = $params->get('parentClickable', 0);
$mode = $params->get('mode', 'default');
$loadJQuery = $params->get('loadJQuery', 1);
$theme = $params->get('theme', 1);

$user =& JFactory::getUser();
if ($user) {
	$userId = $user->get('id');
}
$isUserLoggedIn = $userId > 0 ? true: false;
$menu = ArtWijmoMenuHelper::getMenu($menuType, ($isUserLoggedIn || $showHiddenMenuItems));

$selectedId = ArtWijmoMenuHelper::getParentMenuItemId($menu, $Itemid);
$selectedIndex = ArtWijmoMenuHelper::getMenuItemIndex($menu, $selectedId);
$moduleId = $module->id;

$menuParams = array();

$menuParams = ArtWijmoMenuHelper::getModuleParams($menuParams, $params);
ArtWijmoMenuHelper::renderMenu($showType, array('menu' => $menu, 
											  'moduleParams' => $menuParams, 
											  'selectedId' => $selectedId,
											  'selectedIndex' => $selectedIndex,
											  'moduleId' => $module->id));

?>