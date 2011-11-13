<?php

/**
 * CMS system
 *
 * @copyright  Copyright (c) 2012 Vlastimil Jinoch
 * @package    CMSsystem
 */

namespace Models;

/**
 * Base Model.
 * 
 * Class preparing data for all others presenter.
 *
 * @author     Vlastimil Jinoch
 * @package    CMS system
 */
abstract class BaseModel extends \Nette\Object
{
    /** @var \Nette\DI\Container */
    private $context;

    public function __construct(\Nette\DI\Container $container)
    {
        $this->context = $container;
    }

    /**
     * @return \Nette\DI\Container
     */
    final public function getContext()
    {
        return $this->context;
    }

    /**
     * @return \DibiConnection
     */
    final public function getDatabase()
    {
        return $this->context->database;
    }
}