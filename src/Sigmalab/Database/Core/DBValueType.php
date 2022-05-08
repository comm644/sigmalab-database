<?php
/******************************************************************************
 * Copyright (c) 2003-2009 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : Database Value type
 * File       : DBValueType.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description: module describes common database types.
 *
 * 2021:  const enumeration class DBValueType
 ******************************************************************************/

namespace Sigmalab\Database\Core;

class DBValueType
{
	public const Integer = 'integer';
	public const String = 'string';
	public const Blob = 'blob';
	public const Datetime = 'datetime';
	public const Real = 'float';
	public const Float = 'float';

	public function getParamType(string $valueType):int
	{
		switch ($valueType){
			case self::Integer: return DBParamType::Integer;
			case self::Float: return DBParamType::Real;
			case self::String: return DBParamType::String;
			case self::Blob: return DBParamType::Bool;
			case self::Datetime: return DBParamType::Integer;
		}
		return DBParamType::Integer;
	}
}