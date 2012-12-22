<?php

/**
 * 
 * Phones related data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Phones extends Generator_Base {

    /**
     * Generates a random phone number.
     * 
     * Example:
     *      number('(nnn) nnn-nnnn');
     *  
     * @access	public
     * @param	string      $format     Desired format, using "n" as placeholder
     * @return  string
     */
    public function number($format = '(nnn) nnn-nnnn') {
        return $this->format($format);
    }

}

// end of: generator_phones.php
// location: ./generators/generator_phones.php