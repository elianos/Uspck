<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace FrontendModule;

/**
 * Fronted Base presenter.
 * 
 * Class preparing data for all others presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{
	
	public function formatTemplateFiles()
	{
		$name = $this->getName();
		$presenter = substr($name, strrpos(':' . $name, ':'));
		if($this->getParam('web')){
			$db = $this->context->getService('database');
	      	$res = $db->table('core_webs')->find($this->getParam('web'))->fetch();
	      	$template = $res->template;
		}else{
			$template = '';
		}
      	$dir = dirname(dirname($this->getReflection()->getFileName()));
		return array(
			"$dir/templates/$template/$presenter/$this->view.latte",
			"$dir/templates/$template/$presenter.$this->view.latte",
			"$dir/templates/$template/$presenter/$this->view.phtml",
			"$dir/templates/$template/$presenter.$this->view.phtml",
			"$dir/templates/default/$presenter/$this->view.latte",
			"$dir/templates/default/$presenter.$this->view.latte",
			"$dir/templates/default/$presenter/$this->view.phtml",
			"$dir/templates/default/$presenter.$this->view.phtml",
		);
	}
	
	public function formatLayoutTemplateFiles()
	{
		$name = $this->getName();
		$presenter = substr($name, strrpos(':' . $name, ':'));
		$layout = $this->layout ? $this->layout : 'layout';
		$dir = dirname(dirname($this->getReflection()->getFileName()));
		if($this->getParam('web')){
			$db = $this->context->getService('database');
	      	$res = $db->table('core_webs')->find($this->getParam('web'))->fetch();
	      	$template = $res->template;
		}else{
			$template = '';
		}
		$list = array(
			"$dir/templates/$template/$presenter/@$layout.latte",
			"$dir/templates/$template/$presenter.@$layout.latte",
			"$dir/templates/$template/$presenter/@$layout.phtml",
			"$dir/templates/$template/$presenter.@$layout.phtml",
			"$dir/templates/default/$presenter/@$layout.latte",
			"$dir/templates/default/$presenter.@$layout.latte",
			"$dir/templates/default/$presenter/@$layout.phtml",
			"$dir/templates/default/$presenter.@$layout.phtml",
		);
		do {
			$list[] = "$dir/templates/$template/@$layout.latte";
			$list[] = "$dir/templates/$template/@$layout.phtml";
			$list[] = "$dir/templates/default/@$layout.latte";
			$list[] = "$dir/templates/default/@$layout.phtml";
			$dir = dirname($dir);
		} while ($dir && ($name = substr($name, 0, strrpos($name, ':'))));
		return $list;
	}
}
