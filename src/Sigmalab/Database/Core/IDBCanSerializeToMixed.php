<?php

namespace Sigmalab\Database\Core;

use Sigmalab\Database\DatabaseArgumentException;

interface IDBCanSerializeToMixed
{
	/** Methods provides export object according column specification
	 * @return mixed
	 * @throws DatabaseArgumentException
	 */
	public function serializeToMixed();
}