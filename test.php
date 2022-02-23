<?php

/**
 * Please fix the items marked with "@TODO" in this class
 *
 * Follow the https://www.php-fig.org/psr/psr-2/ coding style guide.
 *
 * One exception to PSR-2: opening braces MUST always be on the same line
 * for classes, methods, functions, and control structures
 */
class Singleton {
    
    /**
     * Use constants for immutable types instead of variables
     * Use descriptive names
     */
    const STRING_A      = 'A';
    const STRING_A_LONG = 'stringA';
    const STRING_B_LONG = 'stringB';
    const STRING_NON_A  = '^A';
    const STRING_NON_B  = '^B';
    const STRING_NON_C  = '^C';
    const STRING_ABC    = 'ABC';
    const INT_A         = 1;
    const INT_B         = 2;

    /**
     * Directory where users have read-only access to certain file types
     */
    const PATH_FILES = '/real/path/to/files';
    
    /**
     * Provide descriptions for properties
     * 
     * @var string
     */
    private $_name;
    
    /**
     * Use consistent naming conventions
     * Private/protected methods/properties are prefixed with underscore
     * 
     * @var mixed
     */
    private $_value;
    
    /**
     * Singleton instance
     * 
     * @var Singleton
     */
    static $_instance;

    /**
     * Private constructor
     * 
     * @param string $name
     * @param mixed  $value
     */
    private function __construct($name, $value) { // Braces on the same line (see above)
        // Initialise the object
        $this->_name = $name;
        $this->_value = $value;
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Get an instance of Singleton
     * 
     * @return Singleton
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            // This will fail as $name and $value arguments are missing!
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    /**
     * Display user name
     *
     * @param string $name User-provided name
     */
    public function userEcho($name) {
        // Optionally use less-destructive htmlentities()
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        echo "The value of 'name' is '{$name}'";
    }

    /**
     * Query by user name
     *
     * @param string $name User-provided name
     */
    public function userQuery($name) {
        $name = mysql_real_escape_string($name);
        mysql_query("SELECT * FROM `test` WHERE `name` = '{$name}' LIMIT 1");
    }

    /**
     * Output the contents of a file
     *
     * @param string $path User-provided file path
     */
    public function userFile($path) {
        // User paths are relative to this root
        $root = self::PATH_FILES;

        // The main point is to never allow users to perform directory traversal
        // Special characters like "." and ".." and direct root access should be forbidden
        // Validate relative path, file name and extension
        if (!preg_match('%^(?:allowed_subpath_a|allowed_subpath_b)\/\w+\.(?:ext|png|jpe?g)$%i', $path)) {
            throw new Exception('Invalid file path');
        }

        // File not found; also check that it's a file, not a directory
        if (!is_file("$root/$path")) {
            throw new Exception('File not found');
        }

        readfile("$root/$path");
    }

    /**
     * Nested conditions
     */
    public function nestedConditions() {
        // Don't introduce new constants
        // The do {} while(false) technique avoids multiple returns
        do {
            if (!$conditionA) {
                echo self::STRING_NON_A;
                break;
            }

            if (!$conditionB) {
                echo self::STRING_NON_B;
                break;
            }

            if (!$conditionC) {
                echo self::STRING_NON_C;
                break;
            }

            echo self::STRING_ABC;
        } while(false);
    }

    /**
     * Return statements
     *
     * @return boolean
     */
    public function returnStatements() {
        // One return per function
        // Don't alter method behavior (return string instead of boolean)
        if ($conditionA) {
            echo self::STRING_A;
        }

        // Implicit boolean conversion
        return !!$conditionA;
    }

    /**
     * Null coalescing
     */
    public function nullCoalescing() {
        // Don't change argument ("user" instead of "name")
        $name = $_GET['name'] ?? $_POST['name'] ?? 'nobody';
        return $name;
    }

    /**
     * Method chaining
     */
    public function methodChained() {
        return $this;
    }

    /**
     * Immutables are hard to find
     */
    public function checkValue($value) {
        $result = null;

        // We should't use constants (strings, ints) locally
        // Store them as class constants instead
        switch ($value) {
            case self::STRING_A_LONG:
                $result = self::INT_A;
                break;

            case self::STRING_B_LONG:
                $result = self::INT_B;
                break;

            // The default is already set, its' null
        }

        return $result;
    }

    /**
     * Check a string is a 24 hour time
     *
     * @example "00:00:00", "23:59:59", "20:15"
     * @return boolean
     */
    public function regexTest($time24Hour) {
        // Fails because there are no start and end delimiters
        // Falsely matches "0:00" (should be 0 left-padded, "00:00")
        // Falsely matchex "x0:00" and "0:00x" (sould match entire string only)
        // Does not match "23:59:59" (fails to capture seconds)
        # $regex = "([01]?[0-9]|2[0-3]):[0-5][0-9]";
        
        // \d instead of [0-9]
        // DRY - don't repeat yourself, the 00-59 minute/second block can appear once or twice
        // Don't use capturing blocks if you don't need them - (?:) instead of ()
        // preg_match returns 0,1 or false; expected return value is boolean
        return !!preg_match('#^(?:[01]\d|2[0-3])(?:\:[0-5]\d){1,2}$#', $time24Hour);
    }

}

/*EOF*/
