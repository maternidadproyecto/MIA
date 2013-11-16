<?php
/**
* @title		SP Image rotator module
* @website		http://www.joomshaper.com
* @copyright	Copyright (C) 2010 -2013 JoomShaper.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<script type="text/javascript">
window.addEvent('domready',function(){
	var sp_image_rotator<?php echo $uniqid; ?> = new noobSlide({
		box: document.id('sp-imr-items<?php echo $uniqid ?>'),
		items:[<?php for($i = 1; $i <= $items-1; $i++){$slideamount= $i.',' ; echo $slideamount;  }  echo $items;?>],
		size: <?php echo $width; ?>,
		autoPlay: <?php echo $autoPlay; ?>,
		interval: <?php echo $interval; ?>,
		<?php if ($showButtons) { ?>
		addButtons: {
			previous: document.id('sp-imr-prev<?php echo $uniqid; ?>'),
			next: document.id('sp-imr-next<?php echo $uniqid; ?>')},
		<?php } ?>	
		fxOptions: {
			duration: <?php echo $speed; ?>,
			transition: Fx.Transitions.<?php echo $transition; ?>,
			wait: false
		}	
	});

});
</script>

<div class="sp-image-rotator">
	<div class="sp-imr-wrapper" style="width:<?php echo $width ?>px;height:<?php echo $height ?>px">
		<div id="sp-imr-items<?php echo $uniqid ?>" class="sp-imr-items">
			<?php foreach($lists as $item) { ?>
				<div class="sp-imr-item">
					<img src="<?php echo $item['image'] ?>" alt="<?php echo $item['title'] ?>" style="height:<?php echo $height ?>px;width:<?php echo $width ?>px" />
				</div>
			<?php } ?>	
		</div>
		<?php if ($showButtons) { ?>
		<div id="sp-imr-prev<?php echo $uniqid;?>" class="sp-imr-prev"></div>
		<div id="sp-imr-next<?php echo $uniqid;?>" class="sp-imr-next"></div>
		<?php } ?>
	</div>
</div>
