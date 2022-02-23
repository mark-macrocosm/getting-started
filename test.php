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
    private $_name;
    private $value;
    static $_instance;

    private function __construct($_name,$value)
    {
        //initialise the object
        $this->_name = $_name;
        $this->value = $value;
    }

    private function __clone()
    {
        //do nothing (this overwrites the special PHP method __clone())
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
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
        if(file_exists($path)) {
            readfile($path);
        }
    }

    /**
     * Nested conditions
     */
    public function nestedConditions() {

        if (!$conditionA) {
            echo '^A';
        }elseif (!$conditionB) {
            echo '^B';
        }elseif (!$conditionC) {
            echo '^C';
        }else{
            echo 'ABC';
        }
    }

    /**
     * Return statements
     *
     * @return boolean
     */
    public function returnStatements() {
        if ($conditionA) {
            $a = 'A';
            return $a;
        } else {
            return false;
        }
    }

    /**
     * Null coalescing
     */
    public function nullCoalescing() {
        $name = $_GET['user'] ?? $_POST['user'] ?? 'nobody';
        return $name;
    }

    /**
     * Method chaining
     */
    public function methodChained() {
        $programmer = (new Programmer)->born()->eat()->sleep()->code()->die();

//        $object->methodA()
//            ->methodB()
//            ->methodC()
//            ->methodD();
    }

    /**
     * Immutables are hard to find
     */
    public function checkValue($value) {
        $result = null;

        // easily replaceable
        switch ($value) {
            case 'stringA':
                $result = 1;
                break;

            case 'stringB':
                $result = 2;
                break;
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
        // @TODO Implement RegEx and return type; validate & sanitize input
        $regex = "([01]?[0-9]|2[0-3]):[0-5][0-9]";
        return preg_match($regex, $time24Hour);
    }

}

/*EOF*/
