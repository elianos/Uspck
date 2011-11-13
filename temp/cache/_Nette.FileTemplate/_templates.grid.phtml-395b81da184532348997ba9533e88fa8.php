<?php //netteCache[01]000378a:2:{s:4:"time";s:21:"0.03138700 1320519162";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:56:"E:\workplace\uspck-new\libs\Gridito\templates\grid.phtml";i:2;i:1314768178;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"37828b8 released on 2011-05-30";}}}?><?php

// source file: E:\workplace\uspck-new\libs\Gridito\templates\grid.phtml

?><?php list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'kzbkgitdxb')
;//
// block _
//
if (!function_exists($_l->blocks['_'][] = '_lb10f97f6236__')) { function _lb10f97f6236__($_l, $_args) { extract($_args); $control->validateControl(false)
?>
<div class="gridito">
<?php if (isset($windowOutput)): ?>

<?php call_user_func(reset($_l->blocks['window']), $_l, get_defined_vars())  ?>

<?php else: ?>

<?php call_user_func(reset($_l->blocks['grid']), $_l, get_defined_vars()) ; endif ?>
</div>
<?php
}}

//
// block window
//
if (!function_exists($_l->blocks['window'][] = '_lb1953b207e4_window')) { function _lb1953b207e4_window($_l, $_args) { extract($_args)
?>
        <h2><?php echo Nette\Templating\DefaultHelpers::escapeHtml($windowLabel, '') ?></h2>
        <?php echo $windowOutput ?>

<?php
}}

//
// block grid
//
if (!function_exists($_l->blocks['grid'][] = '_lb40ff0c763c_grid')) { function _lb40ff0c763c_grid($_l, $_args) { extract($_args)
?>

<?php call_user_func(reset($_l->blocks['flashes']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['toptoolbar']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['data']), $_l, get_defined_vars())  ?>

<?php call_user_func(reset($_l->blocks['paginator']), $_l, get_defined_vars())  ?>

<?php
}}

//
// block flashes
//
if (!function_exists($_l->blocks['flashes'][] = '_lb28ba46e4f1_flashes')) { function _lb28ba46e4f1_flashes($_l, $_args) { extract($_args)
;$iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($flashes) as $flash): ?>
        <div<?php if ($_l->tmp = trim(implode(" ", array_unique(array('gridito-flash', $flash->type === 'error' ? 'ui-state-error' : 'ui-state-highlight', 'ui-corner-all'))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>>
            <span<?php if ($_l->tmp = trim(implode(" ", array_unique(array('ui-icon', $flash->type === 'error' ? 'ui-icon-alert' : 'ui-icon-info'))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>></span>
            <?php echo Nette\Templating\DefaultHelpers::escapeHtml($flash->message, '') ?>

        </div>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ;
}}

//
// block toptoolbar
//
if (!function_exists($_l->blocks['toptoolbar'][] = '_lbd01c577528_toptoolbar')) { function _lbd01c577528_toptoolbar($_l, $_args) { extract($_args)
;if ($control->hasToolbar()): ?>
        <div class="gridito-toolbar">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($control['toolbar']->getComponents()) as $button): if (is_object($button)) $_ctrl = $button; else $_ctrl = $control->getWidget($button); if ($_ctrl instanceof Nette\Application\UI\IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render() ;$iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
        </div>
<?php endif ;
}}

//
// block data
//
if (!function_exists($_l->blocks['data'][] = '_lb9f03f7207d_data')) { function _lb9f03f7207d_data($_l, $_args) { extract($_args)
?>

<?php if ($control->getModel()->count() > 0): ?>

<?php call_user_func(reset($_l->blocks['table']), $_l, get_defined_vars())  ?>

<?php else: ?>
            <?php call_user_func(reset($_l->blocks['emptyResult']), $_l, get_defined_vars())  ?>

<?php endif ?>

<?php
}}

//
// block table
//
if (!function_exists($_l->blocks['table'][] = '_lb0be34bf8a9_table')) { function _lb0be34bf8a9_table($_l, $_args) { extract($_args)
?>
            <table class="gridito-table">
                <thead>
                    <tr>
<?php call_user_func(reset($_l->blocks['tableheader']), $_l, get_defined_vars())  ?>
                    </tr>
                </thead>
                <tbody>
<?php call_user_func(reset($_l->blocks['tablebody']), $_l, get_defined_vars())  ?>
                </tbody>
            </table>
<?php
}}

//
// block tableheader
//
if (!function_exists($_l->blocks['tableheader'][] = '_lb1368ee05ef_tableheader')) { function _lb1368ee05ef_tableheader($_l, $_args) { extract($_args)
;$iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($control['columns']->getComponents()) as $column): ?>
                        <th>
<?php call_user_func(reset($_l->blocks['tableheadercontent']), $_l, get_defined_vars())  ?>
                        </th>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ;if ($control->hasActions()): ?>
                        <th></th>
<?php endif ;
}}

//
// block tableheadercontent
//
if (!function_exists($_l->blocks['tableheadercontent'][] = '_lb4d1d7b8b39_tableheadercontent')) { function _lb4d1d7b8b39_tableheadercontent($_l, $_args) { extract($_args)
;if ($column->isSortable()): ?>
                            <span class="gridito-sorting">
<?php if ($column->getSorting() === null): ?>
                                <a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("sort!", array($column->getName(), 'asc'))) ?>
"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($control->getAjaxClass()))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>><span class="ui-icon ui-icon-carat-2-n-s"></span></a>
<?php endif ;if ($column->sorting === 'asc'): ?>
                                <a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("sort!", array($column->getName(), 'desc'))) ?>
"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($control->getAjaxClass()))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>><span class="ui-icon ui-icon-triangle-1-n"></span></a>
<?php endif ;if ($column->sorting === 'desc'): ?>
                                <a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("sort!", array(null, null))) ?>
"<?php if ($_l->tmp = trim(implode(" ", array_unique(array($control->getAjaxClass()))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>><span class="ui-icon ui-icon-triangle-1-s"></span></a>
<?php endif ?>
                            </span>
<?php endif ?>
                            <?php echo Nette\Templating\DefaultHelpers::escapeHtml($column->getLabel(), '') ?>

<?php
}}

//
// block tablebody
//
if (!function_exists($_l->blocks['tablebody'][] = '_lb21594ea0b4_tablebody')) { function _lb21594ea0b4_tablebody($_l, $_args) { extract($_args)
;$iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($control->getModel()->getItems()) as $item): ?>
                    <tr<?php if ($_l->tmp = trim(implode(" ", array_unique(array($control->getRowClass($iterator, $item)))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($control['columns']->getComponents()) as $column): ?>
                        <td<?php if ($_l->tmp = trim(implode(" ", array_unique(array('gridito-cell', $column->getCellClass($iterator, 'item'), $control->isColumnHighlighted($column) ? 'ui-state-highlight':null))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>>
<?php if (is_object($column)) $_ctrl = $column; else $_ctrl = $control->getWidget($column); if ($_ctrl instanceof Nette\Application\UI\IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->renderCell($item) ?>
                        </td>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ;if ($control->hasActions()): ?>
                        <td class="gridito-actioncell">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($control['actions']->getComponents()) as $button): if (is_object($button)) $_ctrl = $button; else $_ctrl = $control->getWidget($button); if ($_ctrl instanceof Nette\Application\UI\IPartiallyRenderable) $_ctrl->validateControl(); $_ctrl->render($item) ;$iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
                        </td>
<?php endif ?>
                    </tr>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ;
}}

//
// block emptyResult
//
if (!function_exists($_l->blocks['emptyResult'][] = '_lb1043e53d3c_emptyResult')) { function _lb1043e53d3c_emptyResult($_l, $_args) { extract($_args)
;
}}

//
// block paginator
//
if (!function_exists($_l->blocks['paginator'][] = '_lb7226c4cc34_paginator')) { function _lb7226c4cc34_paginator($_l, $_args) { extract($_args)
;$paginator = $control->getPaginator() ;if ($paginator->pageCount > 1): ?>
        <div class="gridito-paginator">
<?php if (!$paginator->isFirst()): ?>
            <a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("changePage!", array('page' => $paginator->page - 1))) ?>
"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('gridito-button', $control->getAjaxClass()))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>>Previous</a>
<?php endif ?>

<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($paginationSteps) as $page): ?>
            <a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("changePage!", array('page' => $page))) ?>
"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('gridito-button', $control->getAjaxClass(), $paginator->page === $page ? 'disabled':null))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>
><?php echo Nette\Templating\DefaultHelpers::escapeHtml($page, '') ?></a>
			<?php if ($iterator->nextValue > $page + 1): ?><span>…</span><?php endif ?>

<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>

<?php if (!$paginator->isLast()): ?>
            <a href="<?php echo Nette\Templating\DefaultHelpers::escapeHtml($control->link("changePage!", array('page' => $paginator->page + 1))) ?>
"<?php if ($_l->tmp = trim(implode(" ", array_unique(array('gridito-button', $control->getAjaxClass()))))) echo ' class="' . Nette\Templating\DefaultHelpers::escapeHtml($_l->tmp) . '"' ?>>Next</a>
<?php endif ?>
        </div>
<?php endif ;
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
?><div id="<?php echo $control->getSnippetId('') ?>"><?php call_user_func(reset($_l->blocks['_']), $_l, $template->getParams()) ?>
</div><?php 
// template extending support
if ($_l->extends) {
	ob_end_clean();
	Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
