<?php
	/****************************************************************************************************

		This example demonstrates how to :
		- Create a variable store and initialize it with a set of variable name/value pairs.
		- Show the contents of the store, expanding the variable values or not
		- Show the contents of a variable after expansion

	 ****************************************************************************************************/

	require_once ( '../Variables.phpclass' ) ;

	if  ( php_sapi_name ( )  !=  'cli' )
		echo "<pre>" ;

	// Initialization values for variables - 3 variables are defined here, 'word1', 'word2' and 'sentence'
	// The 'sentence' variable value references variables 'word1' and 'word2'.
	$variables	=
	   [
		'word1'		=> 'Hello',
		'word2'		=>  'world',
		'sentence'	=>  '$(word1) $(word2) !'
	    ] ;

	// Initialize the variable store
	$store	=  new VariableStore ( $variables ) ;
	
	// Show variable names and values, without expanding the references to existing variables in their values
	echo "Defined variables (with no expansion) :\n" ;
	print_r ( $store -> ToArray ( ) ) ;
	echo "\n\n" ;

	// Same, but variable values are expanded
	echo "Defined variables (with expansion) :\n" ;
	print_r ( $store -> ToArray ( true ) ) ;
	echo "\n\n" ;

	// Shows the expanded value of the 'sentence' variable - note that it requires the VariableStore::OPTION_RECURSIVE flag
	// to be set, which is the default
	echo "Value of variable 'sentence' : " ; print_r ( $store [ 'sentence' ] ) ;