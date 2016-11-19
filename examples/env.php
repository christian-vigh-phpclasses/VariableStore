<?php
	/****************************************************************************************************

		This example demonstrates how to include environment variables in a VariableStore object.

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

	// Initialize our variable store
	$store		=  new VariableStore ( $variables, VariableStore::OPTION_DEFAULT | VariableStore::OPTION_USE_ENVIRONMENT_VARIABLES ) ;

	// Show the contents of our variable store - it should contain the variables 'word1', 'word2', 'sentence' and
	// all the environment variables defined in your session
	echo "Contents of variable store that includes variables 'word1', 'word2', 'sentence' plus all environment variables :\n" ;
	print_r ( $store -> ToArray ( ) ) ;
