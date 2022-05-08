<?php
namespace Database;


/** \ingroup table_relations
   Relation adapter for loading Data
   objects as members of  Dictionary
*/
class DictionaryDataRelation extends \Sigmalab\Database\Relations\DBRelationAdapter
{
	/** @inheritDoc */
	protected function getObject( int $objectId, int $memberId ):\Sigmalab\Database\Core\DBObject
	{
		$obj = new table_t_link;

		$obj->dictionary_id = $objectId;
		$obj->data_id = $memberId;
		return( $obj );
	}

	/** @inheritDoc */
	protected function getDataObject(int $objectId ) : \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Dictionary();
		$obj->dictionary_id = $objectId;
		return( $obj );
	}
	/** @inheritDoc */
	protected function getMemberObject(int $memberId ): \Sigmalab\Database\Core\DBObject
	{
		$obj = new \Database\Data();
		$obj->data_id = $memberId;
		return( $obj );
	}
	/** returns foreing keys for linking
	 */
	protected function getForeignKeys()
	{
		return( [
			table_t_linkFields::dictionary_id,
			table_t_linkFields::data_id
		] );
	}

	/** select Database\Data objects by Dictionary primary key ID.
	 * @param int $objectID  primary key of Dictionary.
	 * @param \Sigmalab\Database\Core\IDataSource $ds
	 * @return \Database\Data[]  collection ob member objects.
	 * @throws \Sigmalab\Database\DatabaseException
	*/
	public function selectDatas( int $objectID, \Sigmalab\Database\Core\IDataSource $ds ):array
	{
		//return $this->select( $objectID, $ds);
		//KPHP mode
		return array_map(function (\Sigmalab\Database\Core\IDataObject $x) {
			return instance_cast($x, \Database\Data::class);},
			$this->select( $objectID, $ds));
	}
}

  

    

