<?php
namespace Database;


/** \ingroup table_relations
   Relation adapter for loading Dictionary
   objects as members of  Data
*/
class AnotherDataDictionaryRelation extends \Sigmalab\Database\Relations\DBRelationAdapter
{
	/** @inheritDoc */
	protected function getObject( int $objectId, int $memberId ):\Sigmalab\Database\Core\DBObject
	{
		$obj = new Another;

		$obj->owner_id = $objectId;
		$obj->child_id = $memberId;
		return( $obj );
	}

	/** @inheritDoc */
	protected function getDataObject(int $objectId ) : \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Data();
		$obj->data_id = $objectId;
		return( $obj );
	}
	/** @inheritDoc */
	protected function getMemberObject(int $memberId ): \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Dictionary();
		$obj->dictionary_id = $memberId;
		return( $obj );
	}
	/** returns foreing keys for linking
	 */
	protected function getForeignKeys()
	{
		return( [
			AnotherFields::owner_id,
			AnotherFields::child_id
		] );
	}

	/** select Database\Dictionary objects by Data primary key ID.
	 * @param int $objectID  primary key of Data.
	 * @param \Sigmalab\Database\Core\IDataSource $ds
	 * @return \Database\Dictionary[]  collection ob member objects.
	 * @throws \Sigmalab\Database\DatabaseException
	*/
	public function selectDictionarys( int $objectID, \Sigmalab\Database\Core\IDataSource $ds ):array
	{
		//return $this->select( $objectID, $ds);
		//KPHP mode
		return array_map(function (\Sigmalab\Database\Core\IDataObject $x) {
			return instance_cast($x, \Database\Dictionary::class);},
			$this->select( $objectID, $ds));
	}
}

  
