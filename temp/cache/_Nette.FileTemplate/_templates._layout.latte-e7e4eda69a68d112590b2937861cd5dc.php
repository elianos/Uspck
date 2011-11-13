<?php //netteCache[01]000387a:2:{s:4:"time";s:21:"0.75626600 1320572124";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:65:"E:\workplace\uspck-new\app\FrontendModule\templates\@layout.latte";i:2;i:1320524989;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"37828b8 released on 2011-05-30";}}}?><?php

// source file: E:\workplace\uspck-new\app\FrontendModule\templates\@layout.latte

?><?php list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'mjkhacab5l')
;//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lbb7fd98eb5d_head')) { function _lbb7fd98eb5d_head($_l, $_args) { extract($_args)
;
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="Nette Framework web application skeleton" />
<?php if (isset($robots)): ?>
	<meta name="robots" content="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($robots, '"') ?>" />
<?php endif ?>

	<title>Nette Application Skeleton</title>

	<link rel="stylesheet" media="screen,projection,tv" href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($basePath, '"') ?>/css/screen.css" type="text/css" />
	<link rel="stylesheet" media="print" href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($basePath, '"') ?>/css/print.css" type="text/css" />
	<link rel="shortcut icon" href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($basePath, '"') ?>/favicon.ico" type="image/x-icon" />

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($basePath, '"') ?>/js/netteForms.js"></script>
	<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars()); } ?>

</head>

<body>
	<div id="navigation">
		<ul><?php Nette\Diagnostics\Debugger::barDump(get_defined_vars(), "Template " . str_replace(dirname(dirname($template->getFile())), "\xE2\x80\xA6", $template->getFile())) ?>

<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($navigation_list) as $part): ?>
				<a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link($part->presenter.':'.$part->action, array('id' => $part->id))) ?>
"><?php echo Nette\Templating\DefaultHelpers::escapeHtml($part->name, '') ?></a>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
		</ul>
	</div>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($flashes) as $flash): ?>
	<div class="flash <?php echo Nette\Templating\DefaultHelpers::escapeHtml($flash->type, '"') ?>
"><?php echo Nette\Templating\DefaultHelpers::escapeHtml($flash->message, '') ?></div>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

<?php Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParams()) ?>
</body>
</html>
<?php 
// template extending support
if ($_l->extends) {
	ob_end_clean();
	Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
