<?php

require_once('Chain.php');


/**
 * Please fix the items marked with "@TODO" in this class
 * 
 * Follow the https://www.php-fig.org/psr/psr-2/ coding style guide.
 * 
 * One exception to PSR-2: opening braces MUST always be on the same line 
 * for classes, methods, functions, and control structures
 */
class Singleton 
{
    // @TODO Implement Singleton functionality
    
    /**
     * Display user name
     * 
     * @param string $name User-provided name
     */
    public function userEcho($name) {
        $name = trim($this->sanitizeInput($name));

        echo "The value of 'name' is '{$name}'";
    }
    
    /**
     * Query by user name
     * 
     * @param string $name User-provided name
     */
    public function userQuery($name) {
        // @TODO Validate & sanitize $name
        $db = new mysqli("localhost","root","","users");

        // connection check
        if ($db->connect_errno) {
            echo "Connection error: " . $db->connect_error;
            exit();
        }

        $sql = "SELECT * FROM `users` WHERE `name` = '{$name}' LIMIT 1";

        $name = mysqli_real_escape_string($db, $name);

        $result = mysqli_query($db, $sql);

        return $result->num_rows;
    }
    
    /**
     * Output the contents of a file
     * 
     * @param string $path User-provided file path
     */
    public function userFile($path) {
        // @TODO Validate & sanitize $path
        $path = filter_var($path, FILTER_SANITIZE_URL);
        readfile($path);
    }
    
    /**
     * Nested conditions
     */
    public function nestedConditions() {
        // @TODO Untangle nested conditions
        $conditionA = true;
        $conditionB = true;
        $conditionC = false;

        if (! $conditionA){
            echo '^A';
        }
        
        if ($conditionA && (! $conditionB)){
            echo '^B';
        }

        if ($conditionA && $conditionB && (! $conditionC)){
            echo '^C';
        }

        if ($conditionA && $conditionB && $conditionC){
            echo 'ABC';
        }
    }
    
    /**
     * Return statements
     * 
     * @return boolean
     */
    public function returnStatements() {
        // @TODO Fix
        $conditionA = 'A';

        return ($conditionA) ? true : false;
    }
    
    /**
     * Null coalescing
     */
    public function nullCoalescing() {
        // @TODO Simplify

        return $_GET['name'] ?? $_POST['name'] ?? 'nobody';
    }
    
    /**
     * Method chaining
     */
    public function methodChained() {
        // @TODO Implement method chaining

        return (new Chain)
            ->name('Angela Markov')
            ->age(50)
            ->gender('Female')
            ->bio();
    }
    
    /**
     * Immutables are hard to find
     */
    public function checkValue($value) {
        $result = null;
        
        // @TODO Make all the immutable values (int, string) in this class 
        // easily replaceable
        switch ($value) {
            case 'stringA':
                $result = 1;
                break;
                
            case 'stringB':
                $result = 2;
                break;
            
            default:
            $result = 0;
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
        $time24Hour = trim($time24Hour);
        $time24Hour = ('([01]?[0-9]|2[0-3]):[0-5][0-9]') ? $time24Hour.':00' : $time24Hour;

        $pattern = '([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]';

        return preg_match('%'.$pattern.'%', $time24Hour);
    }


    protected function sanitizeInput($string, $length = null, $html = false, $strip_tags = true){

        $length = 0 + $length;

		if(! $html){
            return ($length > 0) ? substr(addslashes(trim(preg_replace('/<[^>]*>/', '', $string))),0,$length) : 
                addslashes(trim(preg_replace('/<[^>]*>/', '', $string)));
        }

        $string = utf8_decode(trim($string)); // avoid unicode code issues

        $allow  = "<b><h1><h2><h3><h4><h5><h6><br><br /><hr><hr /><em><strong><a><ul>
            <ol><li><dl><dt><dd><table><tr><th><td><blockquote><address><div><p><span><i><u><s><sup><sub><style><tbody>";
        
        if($strip_tags){
            $string = strip_tags($string, $allow);
        }

        // convert HTML characters
		$string = str_replace("#", "#", htmlentities($string));
		$string = addslashes(str_replace("%", "%", $string));
		if($length > 0){
            $string = substr($string, 0, $length);
        }

		return $string;
    }
}