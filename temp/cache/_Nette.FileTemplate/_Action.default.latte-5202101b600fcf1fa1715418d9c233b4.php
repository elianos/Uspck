<?php //netteCache[01]000394a:2:{s:4:"time";s:21:"0.45903800 1320524258";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:72:"E:\workplace\uspck-new\app\FrontendModule\templates\Action\default.latte";i:2;i:1320524257;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"37828b8 released on 2011-05-30";}}}?><?php

// source file: E:\workplace\uspck-new\app\FrontendModule\templates\Action\default.latte

?><?php list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'pqrsnr4j4h')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb6f04233f78_content')) { function _lb6f04233f78_content($_l, $_args) { extract($_args)
?>
<ul>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($years) as $year): ?>
	<li><a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("action:default", array('id' => $param['id'], 'rok' => $year->years))) ?>
"><?php echo Nette\Templating\DefaultHelpers::escapeHtml($year->years, '') ?></a></li>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
</ul>

<ul>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($actions) as $action): ?>
	<li>
		<a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("action:detail", array('id' => $param['id'], 'inid' => $action->id))) ?>
">
			<?php echo Nette\Templating\DefaultHelpers::escapeHtml($action->name, '') ?>

		</a>
	</li>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
</ul>
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
