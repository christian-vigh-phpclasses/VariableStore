# INTRODUCTION #

A *VariableStore* is simply some kind of Dictionary object that is able to store variable name/value pairs, allowing variable values to reference the contents of other variables in the same store.

Defining a **VariableStore** and adding variables to it is really simple :

	<?php
		require_once ( 'Variables.phpclass' ) ;

		$store 	= new VariableStore ( ) ; 
		$store -> Define ( 'MYVAR1', 'value of MYVAR1' ) ;
		$store -> Define ( 'MYVAR2', 'value of MYVAR2' ) ;
		// etc.

		echo "Value of MYVAR1 is : " . $store[ 'MYVAR1' ] ;

Variable values can reference other variables ; when retrieving their value, their contents will be expanded :

		$store 	= new VariableStore ( ) ; 
		$store -> Define ( 'word1', 'Hello' ) ;
		$store -> Define ( 'word2', 'world' ) ;
		$store -> Define ( 'sentence', '$(word1) $(word2) !' ) ;

		echo $store [ 'sentence' ] 		// Will display : "Hello world !"

You have a faster way to initialize a **VariableStore** object, since you can pass an array of variable name/value pairs to the constructor :

		$variables 	=
		   [
				'MYVAR1' 	=>  'value of MYVAR1',
				'MYVAR2' 	=>  'value of MYVAR2'
		    ] ;

		$store 		=  new VariableStore ( $variables ) ;

You can even pass a **VariableStore** object itself to the constructor :

		$store2 	=  new VariableStore ( $store ) ;

In fact you can pass any number of arrays or **VariableStore** objects to the constructor. There is also a *Load()* method that accepts the same kind of arguments, but that you can call later, after object instantiation :

		$variables1 	=  [ ... ] ;
		$variables2 	=  [ ... ] ;
		...
		$variablesn		=  [ ... ] ;

		$store 			=  new VariableStore ( ) ;
		... some code here ...
		$store -> Load ( $variables1, $variables2, ..., $variablesn ) ;

Last, but not least, you can include your environment variables in a variable store ; this can simply be done by providing the appropriate option flags to the constructor :

		$store 		=  new VariableStore ( VariableStore::OPTION_DEFAULT | VariableStore::OPTION_USE_ENVIRONMENT_VARIABLES ) ;

That way, all the environment variables defined in your shell session will be included into your variable store object. And, even more, every change you will do to one of your environment variables will be also reflected in your session environment.

To be sure of what is inside your **VariableStore** object, simply call the *ToArray()* method :

		print_r ( $store -> ToArray ( ) ) ;

Variable stores accept various options when instantiating them ; you can also check for variable existence, undefine variables, retrieve variable values (either expanded or not). Have a look at the **Reference** section for more information.

# WHY USING A VARIABLE STORE ? #

The first obvious advantage of using a variable store is expanding variable values that reference other variables defined in the same store, and not elsewhere in your code or in your session environment.

A more realistic usage is provided by the following class, which allows to parse and save .INI files :

[http://www.phpclasses.org/package/9413-PHP-Load-and-edit-configuration-INI-format-files.html](http://www.phpclasses.org/package/9413-PHP-Load-and-edit-configuration-INI-format-files.html "Extended Ini File: Load and edit configuration INI format files")

Coupled with the **VariableStore** class, it will allow you to reference variables from within your .INI file, and even provide a whole section that will allow you to define variables later referenced in setting values defined in the same file.

# DEPENDENCIES #

This packages uses the following one :

[http://www.phpclasses.org/package/9904-PHP-Store-associative-array-with-case-insensitive-keys.html](http://www.phpclasses.org/package/9904-PHP-Store-associative-array-with-case-insensitive-keys.html "PHP Associative Array Key Case Insensitive")

The source code for this class has been provided here for your convenience, but it may not be the latest version.

# REFERENCE #

This section provides a reference to the **VariableStore** object.

## Referencing other variables from a variable's value ##

When setting a variable's value, the following constructs are considered as variable references :

	$varname
	$(varname)
	${varname}

Circular variable references will generate an exception, as in the following example :

	$store -> Define ( 'VAR1', '$(VAR2)' ) ;
	$store -> Define ( 'VAR2', '$(VAR1)' ) ;
	echo $store [ 'VAR1' ] ;

Note that variable values are not expanded when they are defined, but only when they are retrieved using the array access operator.

Only the variables defined in you **VariableStore** instance can be referenced in variable values.


## METHODS ##

### CONSTRUCTOR ###

	$store	=  new VariableStore ( $init_values, $options, $parser ) ;

Builds a **VariableStore** object, using the specified parameters, which can be in any order :

- *$init_values* (array or VariableStore object) : any number of array specifying variable name/value pairs, or existing objects of type **VariableStore**. The resulting variable store object will contain all the variable definitions specified here. Note that you can use the *Load()* function later to initialize the object with additional initialization values. Initialization values are optional.
- *$options* (integer) : A combination of the *OPTION\_\** flags (see the corresponding section in the **CONSTANTS** paragraph).
- *$parser* (VariableParser object) : An instance of a **VariableParser** object. If not specified, the default parser will be used (currently, only the **ShellVariableParser** class is implemented).

**NOTES** :

- If you want to use the default flags, together with additional one, you will still have to specify them ; for example, to use the *OPTION\_USE\_ENVIRONMENT\_VARIABLES* flag while preserving the default one, you will need the following :

		$store 	=  new VariableStore ( VariableStore::OPTION_DEFAULT | VariableStore::OPTION_USE_ENVIRONMENT_VARIABLES ) ;

- The **VariableParser** class is used for parsing references to variables when expanding a variable value ; currently, only the **ShellVariableParser** class is implemented, and allows the following constructs for referencing a variable :

		$varname
		$(varname)
		${varname}

- Parameters can be specified in any order.

### Define ###

	$store -> Define ( $name, $value, $export = false ) ;

Defines a new variable in the variable store. The *$value* parameter can contain reference to other variables defined in the variable store, but they will only be expanded when their value will be retrieved using the array access operator.

If the *$export* parameter is set to *true*, any modification to the variable (value change or deletion of the variable using the *Undefine()* method) will affect the corresponding variable in your environment.


### Expand ###

	$str	=  $store -> Expand ( $value, $accept_escapes = false ) ;

Expands the specified string value, using the variables defined in the current **VariableStore** object.

If the *$accept\_escapes* parameter is set to true, a backslah before a character in the variable's value will return the character as is.


### Export ###

	$store -> Export ( $name ) ;

Exports the specified variable to the environment (ie, the variable value will be able to be retrieved using the *getenv()* function).


### IsDefined ###

	$bool	=  $store -> IsDefined ( $name ) ;

Checks if the specified variable is defined in the store.


### Load ###

	$store -> Load ( array_or_store... ) ;

Adds any number of arrays of variable name/value pairs or **VariableStore** objects to the current variable store.

Arrays can contain nested arrays or VariableStore objects.


### ToArray ###

	$array	=  $store -> ToArray ( $expand = false ) ;

Converts a VariableStore to an associative array containing variable name/value pairs.

If the *$expand* parameter is set to *true*, variable contents will be expanded before return.


### Undefine ###

	$store -> Undefine ( $name ) ;

Removes the specified variable from the variable store.


## PROPERTIES ##

### Options ###

Combination of *OPTION\_\** flags specified to the constructor.

## CONSTANTS ##

### OPTION\_\* constants ####

A combination of the following flags, which influence the behavior of the **VariableStore** object :

- *OPTION\_CASE\_INSENSITIVE* : variable names are case-insensitive
- *OPTION\_USE\_ENVIRONMENT\_VARIABLES* : Environment variables will be automatically included in your variable store (no need to provide specific initialization values to the class constructor or the *Load()* method).
- *OPTION\_WARN\_IF\_UNDEFINED* : When this flag is specified, a warning will be issued if a referenced variable does not exist in the variable store. This can happen in two ways :
	- When referencing a variable directly ; for example :

			echo $store [ 'MyUndefinedVariable' ] ;
	 
	- When retrieving the value of a variable that references an undefined variable :

			$store [ 'MyVariable' ] 	=  'some text : $(MyUndefinedVariable)'

- *OPTION\_RECURSIVE* : When expanding variable values, recursively process contents returned after variable expansion until the resulting value contains no more variable references. If not specified, variable expansion will not go beyond the first level.
- *OPTION\_NONE* : No specific option will take place.
- *OPTION\_DEFAULT* : Implies the following flags :
	- *OPTION\_WARN\_IF\_UNDEFINED*
	- *OPTION\_RECURSIVE*
	- *OPTION\_CASE\_INSENSITIVE* (on Windows platforms only)

## INTERFACES ##

The following section lists the interfaces implemented by the **VariableStore** class.

### ArrayAccess ###

Allows access to variable values using the following notation :

	$store [ 'myvar' ] ;

Note that this will expand the contents of the *myvar* variable ; to retrieve the raw contents, prepend a sharp sign to the variable name :

	$store [ '#myvar' ] ;

### Countable ###

Allows for the use of the *count()* function on a **VariableStore** object ; returns the number of variables currently defined.

### IteratorAggregate ###

Allows for the use of the *foreach()* construct on a **VariableStore** object.
