<?php
	/****************************************************************************************************

		This example demonstrates various ways to initialize a variable store.

	 ****************************************************************************************************/

	require_once ( '../Variables.phpclass' ) ;

	if  ( php_sapi_name ( )  !=  'cli' )
		echo "<pre>" ;

	// Initialization values for variables - 3 variables are defined here, 'word1', 'word2' and 'sentence'
	// The 'sentence' variable value references variables 'word1' and 'word2'.
	$variables1	=
	   [
		'word1'		=> 'Hello',
		'word2'		=>  'world',
		'sentence'	=>  '$(word1) $(word2) !'
	    ] ;

	// We first define a variable store, $store1, initialized with the $variables1 array
	$store1		=  new VariableStore ( $variables1 ) ;

	$variables2	=
	   [
		'v1'		=>  'v1 value',
		'v2'		=>  'v2 value' 
	    ] ;

	$variables3	=  
	   [
		'v3'		=>  'v3 value',
		'v4'		=>  'v4 value' 
	    ] ;

	// We initialize a variable store ($main_store) with the contents of the $store1 variable store object 
	// and the $variable2 array
	$main_store	=  new VariableStore ( $store1, $variables2 ) ;
	echo "After initialization with \$store1 object and \$variables array :\n" ;
	print_r ( $main_store -> ToArray ( ) ) ;
	echo "\n\n" ;

	// We use the Load() method to add the contents of the $variables3 array to our $main_store object
	$main_store -> Load ( $variables3 ) ;
	echo "After loading \$variables3 array :\n" ;
	print_r ( $main_store -> ToArray ( ) ) ;
	echo "\n\n" ;

	// And finally, we define a variable named 'myvar' in our $main_store object
	$main_store -> Define ( 'myvar', 'the value of myvar' ) ;
	echo "After defining the 'myvar' variable : \n" ;
	print_r ( $main_store -> ToArray ( ) ) ;
	echo "\n\n" ;
