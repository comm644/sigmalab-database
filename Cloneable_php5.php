<?php

namespace Sigmalab\Database;
/**
 * \ingroup ado_basic
 *
 * base class for cloning objects
 */
class Cloneable
{
	/** clone object .
	 *
	 * \b Recommandation: use for cloning empty object. as \b prototype
	 */
	function cloneObject()
	{
		return (clone $this);
	}
}
