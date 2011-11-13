<?php

namespace Gridito;

use \Nette\Database;

/**
 * DibiFluent model
 *
 * @author Jan Marek
 * @license MIT
 */
class NetteDatabaseModel extends AbstractModel
{
	/** @var DibiFluent */
	protected $selection;

	/** @var string */
	protected $rowClass;



	/**
	 * Constructor
	 * @param \DibiFluent $fluent dibi fluent object
	 * @param string $rowClass row class name
	 */
	public function __construct(\Nette\Database\Table\Selection $selection, $rowClass = 'DataRow')
	{
		$this->selection = $selection;
		$this->rowClass = $rowClass;
	}



	public function getItemByUniqueId($uniqueId)
	{
		$selection = clone $this->selection;
		$sel = clone $this->selection;
		//$selection->where($this->getPrimaryKey(), $uniqueId);
		return $selection->where($sel->find($uniqueId)->name.'.'.$this->getPrimaryKey(), $uniqueId)->fetch();
	}



	public function getItems()
	{
		$selection = clone $this->selection;

		$selection->limit($this->getLimit(), $this->getOffset());

		list($sortColumn, $sortType) = $this->getSorting();
		if ($sortColumn) {
			$selection->order($sortColumn.' '.$sortType);
		}

		return $selection->fetchPairs('id');
	}



	/**
	 * Item count
	 * @return int
	 */
	protected function _count()
	{
		return $this->selection->count();
	}



	public function getItemValue($item, $valueName)
	{
		return $item->$valueName;
	}

}