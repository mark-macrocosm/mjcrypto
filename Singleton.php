<?php

// Don't include external libraries

/**
 * Please fix the items marked with "@TODO" in this class
 * 
 * Follow the https://www.php-fig.org/psr/psr-2/ coding style guide.
 * 
 * One exception to PSR-2: opening braces MUST always be on the same line 
 * for classes, methods, functions, and control structures
 */
class Singleton { // opening braces on the same line (see above)

    /**
     * Singleton instance
     * 
     * @var Singleton
     */
    protected static $_instance = null;
    
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
     * Get a singleton instance
     * 
     * @return Singleton
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    /**
     * Inaccessible constructor
     */
    protected function __construct () {}
    
    /**
     * Prevents this class from being cloned
     */
    protected function __clone() {}
    
    /**
     * Display user name
     * 
     * @param string $name User-provided name
     */
    public function userEcho($name) {
        // Prevent XSS
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        echo "The value of 'name' is '{$name}'";
    }
    
    /**
     * Query by user name
     * 
     * @param string $name User-provided name
     */
    public function userQuery($name) {
        // Never store DB credentials in plain text
        # $db = new mysqli("localhost","root","","users");

        // Prevent SQL injections; escape the string or use prepared statements
        $name = mysqli_real_escape_string($db, $name);
        $sql = "SELECT * FROM `users` WHERE `name` = '{$name}' LIMIT 1";
        
        // The SQL is already malformed at this point
        # $name = mysqli_real_escape_string($db, $name);
        
        // Don't assume/change return type
        # return $result->num_rows;
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
        // Don't alter the function behavior; one return per function
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
        return $_GET['name'] ?? $_POST['name'] ?? 'nobody';
    }
    
    /**
     * Method chaining
     */
    public function methodChained() {
        return $this;
    }
    
    /**
     * Immutables are hard to find
     * 
     * @return int|null
     */
    public function checkValue($value) {
        $result = null;

        // We should't use constants (strings, ints) locally
        // Store them as class constants instead
        switch ($value) {
            case self::STRING_A_LONG:
                $result = INT_A;
                break;

            case self::STRING_B_LONG:
                $result = INT_B;
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
        // No need to type cast to string, preg_match will do that
        # $time24Hour = trim($time24Hour);
        
        // This is a string, implicitly converted to true
        # $time24Hour = ('([01]?[0-9]|2[0-3]):[0-5][0-9]') ? $time24Hour.':00' : $time24Hour;
        
        // Regex fails to catch 20:15
        // Regex catches 0:00:00 by mistake (hours should be left-padded)
        # $pattern = '([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]';

        // No other sanitization is needed except the regex
        // 0 left padding - so [01]\d instad of [01]?\d (02:00 instead of 2:00)
        // DRY - don't repeat yourself, the 00-59 minute/second block can appear once or twice
        // Don't use capturing blocks if you don't need them - (?:) instead of ()
        // preg_match returns 0,1 or false; expected return value is boolean
        return !!preg_match('#^(?:[01]\d|2[0-3])(:[0-5]\d){1,2}$#', $time24Hour);
    }
}

/*EOF*/
