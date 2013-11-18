<?php
/*
 * Art Wijmo menu: simple template - main template file
 *
 * @version		1.0.3
 * @author		Artetics
 * @copyright	Copyright (c) 2009 www.artetics.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 */
error_reporting(E_ERROR);

$moduleParams = $params['moduleParams'];
$moduleId = $params['moduleId'];
$menu = $params['menu'];
$menuId = $params['menuId'];
$selectedId = $params['selectedId'];
$selectedIndex = $params['selectedIndex'];
$theme = $params['theme'];

if (!function_exists('artWijmoMenuSimple_traverseMenuChildrenItems')) {
	function artWijmoMenuSimple_traverseMenuChildrenItems($menu, $parentId = 0, $showTypeElm, $theme, $moduleParams, $showType = null) {
    $Itemid = JRequest::getString('Itemid');
    
    $cc = count($menu);
    $j = 1;
    
    $menuItemParams = new JRegistry;
		foreach ($menu as $menuItem) {
			if ((isset($menuItem->parent) && $menuItem->parent != $parentId) || (isset($menuItem->parent_id) && $menuItem->parent_id != $parentId)) continue;
			$link = $menuItem->link;
      
      $menuItemParams->loadString($menuItem->params);
      if ($menuItemParams && $menuItemParams->get('menu_image')) {
        $menuItem->menu_image = $menuItemParams->get('menu_image');
      }
      
			if ($menuItem->type == 'menulink') {
				$jMenu = &JSite::getMenu();
				$itemIdStrPos = strpos($menuItem->link, 'Itemid=');
				$newItem = $jMenu->getItem(substr($menuItem->link, $itemIdStrPos + 7));
			} else if ($menuItem->type == 'alias') {
        $jMenu = &JSite::getMenu();
				$newItem = $jMenu->getItem(substr($menuItem->params, 17, strpos($menuItem->params, '",') - 17));
        $link = $newItem->link;
      }
			else if ($link && ($menuItem->type == 'component' || strpos($link, 'http') !== 0)) {
				$link .= (strpos($link, '?') !== false) ? '&' : '?';
				$link .= 'Itemid=' . $menuItem->id;
			}
			$app = &JFactory::getApplication();
			$router = &$app->getRouter();
			$link = JRoute::_($link, false);
      
      $addClass = '';
      $classString = '';
      if ($Itemid == $menuItem->id) {
        $classString .= 'menuactive';
      }
      if ((isset($menuItem->children) && count($menuItem->children) > 0) && !$moduleParams['parentClickable']) {
        $link = 'javascript:void(0);';
      }
      if (!$link) {
      $link = 'javascript:void(0);';
      }
      if ($addClass) {
        $classString .= ' ' . $addClass . '';
      }
      if (!$menuItem->name) {
        $menuItem->name = $menuItem->title;
      }
      if ($menuItem->type == 'separator') {
      ?>
        <li class="wijmo-wijmenu-separator ui-state-default ui-corner-all"></li>
      <?php
      } else
	?>
			<li class="<?php echo $classString; ?>">
      <a rel="<?php echo $menuItem->id; ?>" href="<?php echo $link;?>" <?php if ($menuItem->browserNav && $menuItem->browserNav != 0) {echo 'target="_blank"';};?>>
      <?php if ($menuItem->menu_image) { ?><img src="<?php echo $menuItem->menu_image; ?>" alt="<?php echo $menuItem->name; ?>" /> <?php } ?>
      <?php echo $menuItem->name;?></a>
	<?php
			if (isset($menuItem->children) && count($menuItem->children) > 0) {
				echo '<ul>';
				artWijmoMenuSimple_traverseMenuChildrenItems($menuItem->children, $menuItem->id, $showTypeElm, $theme, $moduleParams, $showType);
				echo '</ul>';
			}
	?>
			</li>
	<?php
    $j++;
		}
	}
}

if ($menu) {
  $document = &JFactory::getDocument();
  $document->addStyleSheet( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/base-reset.css');
  
  if ($moduleParams['theme'] == 2) {
    $document->addStyleSheet( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/themes/aristo/jquery-wijmo2.css');
  } else {
    $document->addStyleSheet( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/themes/aristo/jquery-wijmo.css');
  }
  $document->addStyleSheet( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/themes/wijmo/jquery.wijmo.wijsuperpanel.css');
  $document->addStyleSheet( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/themes/wijmo/jquery.wijmo.wijmenu.css');
  
  if (array_key_exists ('loadJQuery', $moduleParams) && $moduleParams['loadJQuery']) {
    $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/external/jquery-1.4.3.min.js');
  }
  $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/external/jquery-ui-1.8.6.custom.min.js');
  $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/external/jquery.mousewheel.min.js');
  $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/external/jquery.bgiframe-2.1.3-pre.js');
  $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/wijmo/jquery.wijmo.wijutil.js');
  $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/wijmo/jquery.wijmo.wijsuperpanel.js');
  $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/wijmo/jquery.wijmo.wijmenu.js');
  $document->addScript( JURI::root() . 'modules/mod_artwijmomenu/mod_artwijmomenu/stuff/wijmo/jquery.nc.js');
  if ($moduleParams['mode'] == 'default') {
    $document->addCustomTag('<script id="scriptInit" type="text/javascript">awmJquery(document).ready(function () {awmJquery("#flyoutmenu' . $moduleId . '").wijmenu({orientation: "' . $moduleParams['orientation'] . '", trigger: ".wijmo-wijmenu-item",triggerEvent: "' . $moduleParams['trigger'] . '"});});awmJquery(window).load(function () {awmJquery("#artwijmomenucontainer_' . $moduleId . '").show();});</script>');
  } else {
    $document->addCustomTag('<script id="scriptInit" type="text/javascript">awmJquery(document).ready(function () {awmJquery("#flyoutmenu' . $moduleId . '").wijmenu({orientation: "' . $moduleParams['orientation'] . '", trigger: ".wijmo-wijmenu-item",triggerEvent: "' . $moduleParams['trigger'] . '",mode: "' . $moduleParams['mode'] . '"});});awmJquery(window).load(function () {awmJquery("#artwijmomenucontainer_' . $moduleId . '").show();});</script>');
  }
?>

<div id="artwijmomenucontainer_<?php echo $moduleId; ?>" class="artwijmomenucontainer" style="display:none">
<ul id="flyoutmenu<?php echo $moduleId; ?>">
	<?php
    $version = new JVersion(); 
    if ($version->RELEASE >= 1.6) {
      artWijmoMenuSimple_traverseMenuChildrenItems($menu, 1, $showTypeElm, $theme, $moduleParams, $showType);
    } else {
      artWijmoMenuSimple_traverseMenuChildrenItems($menu, 0, $showTypeElm, $theme, $moduleParams, $showType);
    }
	?>
	</ul>
</div>
<?php
}
?>

<!-- Art Wijmo Menu Joomla! module. Copyright (c) 2010 Artetics, www.artetics.com.com -->
<!-- http://www.artetics.com/ARTools/art-wijmomenu -->