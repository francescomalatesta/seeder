<?php

/**
 * This is the generator base class, you can create new generators starting from here.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Base {

    var $data = array();
    var $generator = null;

    /**
     * Generates a random integer number.
     *
     * @access	public
     * @param	int $min The minimum random extraction value
     * @param	int $max The maximum random extraction value
     * @return	int
     */
    public function int($min, $max) {
        return mt_rand($min, $max);
    }

    /**
     * Generates a random float number.
     *
     * @access	public
     * @param	float $min The minimum random extraction value
     * @param	float $max The maximum random extraction value
     * @param	int $digits The number of digits after the dot
     * @return	float
     */
    public function float($min, $max, $digits = 2) {
        $range = $max - $min;
        return number_format($min + $range * mt_rand(0, 32767) / 32767, $digits);
    }

    /**
     * Generates a random boolean value.
     *
     * @access	public
     * @return	boolean
     */
    public function boolean() {
        return (mt_rand(0, 1) == 1) ? true : false;
    }

    /**
     * Generates a random character using a list of ASCII codes.
     *
     * @access	public
     * @param	boolean $numbers        Includes number characters in random extraction
     * @param	boolean $upperCase      Includes upper case characters in random extraction
     * @param	boolean $specialChars   Includes special characters in random extraction
     * @return	char
     */
    public function char($numbers = true, $upperCase = false, $specialChars = false) {
        $chars = array(97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122);

        if ($numbers)
            $chars = array_merge($chars, array(48, 49, 50, 51, 52, 53, 54, 55, 56, 57));

        if ($upperCase)
            $chars = array_merge($chars, array(65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90));

        if ($specialChars)
            $chars = array_merge($chars, array(33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 58, 59, 60, 61, 62, 63, 64, 91, 92, 93, 94, 95, 96, 123, 124, 125, 126));

        return chr($this->choose($chars));
    }

    /**
     * Generates a random hexadecimal number.
     *
     * @access	public
     * @param	int $min The minimum random extraction value
     * @param	int $max The maximum random extraction value
     * @return	int
     */
    public function hex($min = 0, $max = 'F') {
        $min = hexdec($min);
        $max = hexdec($max);

        return dechex(mt_rand($min, $max));
    }

    /**
     * Generates a random octal number.
     *
     * @access	public
     * @param	int $min The minimum random extraction value
     * @param	int $max The maximum random extraction value
     * @return	int
     */
    public function oct($min = 0, $max = 7) {
        $min = octdec($min);
        $max = decoct($max);

        return decoct(mt_rand($min, $max));
    }

    /**
     * Generates a random binary number.
     *
     * @access	public
     * @return	int
     */
    public function bin() {
        return mt_rand(0, 1);
    }

    /**
     * Returns a random element from the given array.
     *
     * @access	public
     * @param	mixed $array The used array
     * @return	mixed
     */
    public function choose($array) {
        return $array[array_rand($array)];
    }

    /**
     * Parses the $format string extracting the generator name and the specific
     * generator field.
     *  
     * @access	public
     * @param	string $format The starting format string to use
     * @param	string $args Optional arguments, separed by ","
     * @return	string
     */
    public function parse($format, $args = '') {
        preg_match_all('/[\w]*:[\w\s\(\),]*/', $format, $matches);

        foreach ($matches[0] as $match) {
            $arr = explode(':', str_replace(array('{', '}'), '', $match));

            // optional substring specification search
            // example: People:lastName (0,1)
            preg_match('/[\w]* \([0-9]*,[0-9]*\)/', $arr[1], $subMatch);
            if ($subMatch != null) {
                $res = explode(' ', str_replace(array('(', ')'), '', $arr[1]));
                $arr[1] = reset($res);
            }

            if ($args != '')
                $value = $this->generator->$arr[0]->$arr[1]($args);
            else
                $value = $this->generator->$arr[0]->$arr[1];

            if ($subMatch != null) {
                $res = explode(',', end($res));
                $value = substr($value, $res[0], $res[1]);
                $match = str_replace('(', '\(', str_replace(')', '\)', $match));
            }

            $format = preg_replace('/{' . $match . '}/', $value, $format, 1);
        }

        return $format;
    }

    /**
     * Formats the given $format string, replacing the following placeholders:
     * 
     * n -> integer 0-9
     * h -> hex
     * o -> octal
     * b -> binary
     *  
     * @access	public
     * @param	string $format The starting format string to use
     * @param	string $args Optional arguments, separed by ","
     * @return	string
     */
    public function format($format) {
        $len = strlen($format);

        for ($c = 0; $c < $len; $c++) {
            switch ($format[$c]) {
                case 'n':
                    $format[$c] = $this->int(0, 9);
                    break;

                case 'h':
                    $format[$c] = $this->hex();
                    break;

                case 'o':
                    $format[$c] = $this->oct();
                    break;

                case 'b':
                    $format[$c] = $this->bin();
                    break;
            }
        }

        return $format;
    }

    /**
     * Used to call a specific method with custom arguments.
     * 
     * An error message is show if the data set doesn't exists. 
     * 
     * @access	public
     * @param	string $name The used data set.
     * @param	string $args The arguments, separed by ","
     * @return	mixed
     */
    public function __call($name, $arguments) {
        if (isset($this->data[$name])) {
            $subs = explode(',', $arguments[0]);
            $sub = $this->choose($subs);

            if (isset($this->data[$name][trim($sub)]))
                return $this->choose($this->data[$name][trim($sub)]);
            else
                return $this->choose($this->data[$name]);
        }
        else
            die('Error: data ' . $name . ' not exists!');
    }

    /**
     * Used to get a random value directly from a data set.
     * 
     * An error message is show if the data set doesn't exists.
     *  
     * @access	public
     * @param	string $name The used data set
     * @return	mixed
     */
    public function __get($name) {
        if (method_exists($this, $name))
            return call_user_func(array($this, $name));
        else {
            if (isset($this->data[$name])) {
                if (is_array(reset($this->data[$name])))
                    return $this->choose($this->choose($this->data[$name]));
                else
                    return $this->choose($this->data[$name]);
            }
            else
                die('Error: data ' . $name . ' not exists!');
        }
    }

    /**
     * Used to load data sets and generator-specific filters.
     *  
     * @access	public
     * @param	string $generator The generator's name
     */
    public function __construct($generator) {
        $dataFileName = get_class($this);
        $dataFileName = strtolower(substr($dataFileName, 10));

        $this->generator = $generator;

        if (file_exists(dirname(__FILE__) . '/data/data_' . $dataFileName . '.php')) {
            $data = array();
            require 'data/data_' . $dataFileName . '.php';

            $this->data = $data;
        }
    }

}

/**
 * 
 * Everything starts here. Create an instance of this class to start generating random data.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Seeder {

    var $generators = array();

    /**
     * Resets the random generator with the given seed
     *  
     * @access	public
     * @param	int $seed The given seed.
     */
    public function seed($seed) {
        srand($seed);
        mt_srand($seed);
    }

    function get() {
        return $this;
    }

    /**
     * Used to get a specific generator from the $generators array. It loads the
     * new generator if it's not yet in the array.
     * 
     * An error message is show if the generator doesn't exists.
     *  
     * @access	public
     * @param	string $name The desired generator
     * @return	mixed
     */
    function __get($name) {
        if (!isset($this->generators[$name])) {
            if (!file_exists(dirname(__FILE__) . '/generators/generator_' . strtolower($name) . '.php'))
                die('Error: generator_' . strtolower($name) . '.php not exists!');

            require 'generators/generator_' . strtolower($name) . '.php';

            if (class_exists('Generator_' . $name)) {
                $class = 'Generator_' . $name;
                $obj = new $class($this);

                $this->generators[$name] = $obj;
            }
            else
                die('Error: Generator_' . $name . ' class not exists!');
        }

        $this->seed(mt_rand(0, time()));

        return $this->generators[$name];
    }

    function __construct() {
        $this->generators['Base'] = new Generator_Base($this);
    }

}

// end of: seeder.php
// location: ./seeder.php