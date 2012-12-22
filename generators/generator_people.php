<?php

/**
 * 
 * People related data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_People extends Generator_Base {

    var $fullNameFormats = array(
        '{People:firstName} {People:lastName}',
        '{People:firstName} {People:firstName} {People:lastName}',
        '{People:firstName} {People:firstName (0,1)}. {People:lastName}'
    );
    
    /**
     * Generates a random full name.
     *  
     * @access	public
     * @return  string
     */
    public function fullName() {
        return $this->parse($this->choose($this->fullNameFormats));
    }

}

// end of: generator_people.php
// location: ./generators/generator_people.php