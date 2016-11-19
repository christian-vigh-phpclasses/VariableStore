<?php
	/****************************************************************************************************

		This example demonstrates how to define, check for existence and undefine environment 
		variables in a VariableStore object.

	 ****************************************************************************************************/

	require_once ( '../Variables.phpclass' ) ;

	if  ( php_sapi_name ( )  !=  'cli' )
		echo "<pre>" ;

	$store	=  new VariableStore ( ) ;
	echo "Defining variable 'VAR'...\n" ;

	// Define the 'VAR' variable in the variable store 
	$store [ 'VAR' ]	= 'value of the VAR variable' ;		// We could
	echo "Value of variable VAR : \"" . $store [ 'VAR' ] . "\"\n" ;
	
	// Check if the 'VAR' variable is defined
	echo "Is variable VAR defined ? " . ( ( $store -> IsDefined ( 'VAR' ) ) ? 'yes' : 'no' ) . "\n" ;

	// Undefine variable 'VAR'
	$store -> Undefine ( 'VAR' ) ;
	echo "Is variable VAR still defined after a call to Undefine('VAR') ? " . ( ( $store -> IsDefined ( 'VAR' ) ) ? 'yes' : 'no' ) . "\n" ;
