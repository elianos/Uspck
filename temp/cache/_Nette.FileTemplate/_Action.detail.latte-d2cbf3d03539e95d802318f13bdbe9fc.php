<?php //netteCache[01]000393a:2:{s:4:"time";s:21:"0.90333700 1320524320";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:71:"E:\workplace\uspck-new\app\FrontendModule\templates\Action\detail.latte";i:2;i:1320524290;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"37828b8 released on 2011-05-30";}}}?><?php

// source file: E:\workplace\uspck-new\app\FrontendModule\templates\Action\detail.latte

?><?php list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'j35h5nwh84')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb154beaca14_content')) { function _lb154beaca14_content($_l, $_args) { extract($_args)
?>
<h2><?php echo Nette\Templating\DefaultHelpers::escapeHtml($action['name'], '') ?></h2>
<?php echo Nette\Templating\DefaultHelpers::escapeHtml($action['date'], '') ?>

<?php echo Nette\Templating\DefaultHelpers::escapeHtml($action['text'], '') ?>

Galerii můete nalézt <a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("gallery:detail", array('inid' => $action->id))) ?>
">zde</a>.
<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extends) ? FALSE : $template->_extends; unset($_extends, $template->_extends);


if ($_l->extends) {
	ob_start();
} elseif (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
if (!$_l->extends) { call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()); }  
// template extending support
if ($_l->extends) {
	ob_end_clean();
	Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
