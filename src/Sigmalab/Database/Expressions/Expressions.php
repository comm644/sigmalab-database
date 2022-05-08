<?php

use Sigmalab\Database\Expressions\ECompilerSQL;

/** multiargument expression
 */
class SQLExpression
{
	/**
	 * @var string
	 */
	public string $mode = ECompilerSQL::EMPTY; //join mode
	/**
	 * @var mixed[]
	 */
	public array $args;      //array of arguments
	public string $type = '';      //type of values (need for type conversion)

	public function __construct($mode, $args)
	{
		$this->mode = $mode;
		$this->args = $args;
	}
}
define( "CLASS_Expression", SQLExpression::class) ;

define( "CLASS_ExprBool", \Sigmalab\Database\Expressions\ExprBool::class );

// logic
define( "CLASS_ExprOR", \Sigmalab\Database\Expressions\ExprOR::class);


define( "CLASS_ExprAND", \Sigmalab\Database\Expressions\ExprAND::class );

// set
define( "CLASS_ExprIN", \Sigmalab\Database\Expressions\ExprIN::class);

// bool
define( "CLASS_ExprEQ", \Sigmalab\Database\Expressions\ExprEQ::class);

define( "CLASS_ExprLike", \Sigmalab\Database\Expressions\ExprLike::class);

define( "CLASS_ExprLikeNoMask", \Sigmalab\Database\Expressions\ExprLikeNoMask::class );


define( "CLASS_ExprRaw", \Sigmalab\Database\Expressions\ExprRaw::class );


define( "CLASS_ExprMath", \Sigmalab\Database\Expressions\ExprMath::class );

