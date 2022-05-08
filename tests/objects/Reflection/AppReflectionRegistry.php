<?php
namespace Reflection;
use Sigmalab\SimpleReflection\ClassRegistry;

class AppReflectionRegistry
{
	public static function init()
	{
		ClassRegistry::init();
		\Database\DataNotNullableId_reflection::registerClass();
		\Database\DataDateTimeId_reflection::registerClass();
		\Database\DictionaryId_reflection::registerClass();
		\Database\Dictionary_reflection::registerClass();
		\Database\table_t_link_reflection::registerClass();
		\Database\AnotherId_reflection::registerClass();
		\Database\Another_reflection::registerClass();
		\Database\table_t_baseId_reflection::registerClass();
		\Database\table_t_linkId_reflection::registerClass();
		\Database\DataId_reflection::registerClass();
		\Database\Data_reflection::registerClass();
		\Database\table_t_base_reflection::registerClass();
		\Database\DataDateTime_reflection::registerClass();
		\Database\DataNotNullable_reflection::registerClass();
		\Database\DataId_reflection::registerClass();
		
	}
}
