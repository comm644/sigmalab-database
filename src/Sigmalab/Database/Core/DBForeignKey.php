<?php

namespace Sigmalab\Database\Core;

class DBForeignKey
{
	/** tag from owner object. owner primary key */
	public IDBColumnDefinition $ownerTag;

	/** tag from foreign object */
	public IDBColumnDefinition $foreignTag;

	public function __construct(IDBColumnDefinition $ownerTag, IDBColumnDefinition $foreignTag)
	{

		$this->ownerTag = $ownerTag;
		$this->foreignTag = $foreignTag;
	}

	public function foreignTag():\Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->foreignTag;
	}

	public function ownerTag():\Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->ownerTag;
	}
}

