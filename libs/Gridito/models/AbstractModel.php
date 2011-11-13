<?php

namespace Gridito;

/**
 * Abstract Gridito model
 *
 * @author Jan Marek
 * @license MIT
 */
abstract class AbstractModel implements IModel
{
	/** @var array */
	private $limit;

	/** @var array */
	private $offset;

	/** @var array */
	private $sorting = array(null, null);

	/** @var string */
	private $primaryKey = 'id';

	/** @var int */
	private $count = null;



	abstract protected function _count();



	public function setLimit($limit)
	{
		$this->limit = $limit;
	}



	public function getLimit()
	{
		return $this->limit;
	}



	public function getOffset()
	{
		return $this->offset;
	}



	public function setOffset($offset)
	{
		$this->offset = $offset;
	}



	/**
	 * Set sorting
	 * @param string $column column
	 * @param string $type asc or desc
	 * @return array
	 */
	public function setSorting($column, $type)
	{
		return $this->sorting = array($column, $type);
	}



	public function getSorting()
	{
		return $this->sorting;
	}



	public function setPrimaryKey($name)
	{
		$this->primaryKey = $name;
	}



	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}



	public function getUniqueId($item)
	{
		return $item->{$this->getPrimaryKey()};
	}



	public function getItemsByUniqueIds(array $uniqueIds)
	{
		return array_map(array($this, 'getItemByUniqueId'), $uniqueIds);
	}



	public function count()
	{
		if ($this->count === null) {
			$this->count = $this->_count();
		}

		return $this->count;
	}

}