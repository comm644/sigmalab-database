<?php
/******************************************************************************
 * Copyright (c) 2007-2008 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : DB default result container
 * File       : DBDefaultREsultContainer.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 ******************************************************************************/


namespace Sigmalab\Database\Core;

use Sigmalab\SimpleReflection\ReflectionBooster;

class DBDefaultResultContainer extends DBResultContainer
{
	/** @var  IDataObject */
	public IDataObject $proto;
	public bool $signUseID = true;

	public function __construct(IDataObject $proto, bool $signUseID)
	{
		$this->proto = $proto;
		$this->signUseID = $signUseID;
	}

	/**
	 * Default result container performs copying all incoming row keys as object members.
	 *
	 * @param array $sqlLine associtive array read from SQL
	 * @return IDataObject  created via cloning
	 */
	public function fromSQL(array $sqlLine) : IDataObject
	{
		$object =  $this->proto->createSelf();
		ReflectionBooster::setAsMixedFromMixed($object, $sqlLine);
		return $object;
	}

	/**
	 * @param IDataObject $object
	 * @noinspection PhpMissingParentCallCommonInspection
	 */
	public function add(IDataObject $object): void
	{
		if (($this->signUseID === true) && ($this->proto !== null)) {
			$pos = $object->primary_key_value();
			$this->data[$pos] = $object;
		} else {
			$this->data[] = $object;
		}
	}
}

