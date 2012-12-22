<?php

/**
 *
 * Business related data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Business extends Generator_Base {

    var $nameFormats = array(
        '{People:lastName}',
        '{People:lastName} & {People:lastName}',
        '{People:lastName} and {People:lastName}',
        '{People:lastName} {Business:sector}',
        '{People:lastName} & {People:lastName} {Business:sector}',
        '{People:lastName} and {People:lastName} {Business:sector}',
        '{People:lastName}\'s {Business:sector}'
    );

    /**
     * Generates a random company name.
     *  
     * @access	public
     * @param	string      $sectors    Desired sectors, separated by ","
     * @param	int/boolean $suffix     If true, adds a company suffix
     * @param	string      $format     The desired random company name format
     * @return  string
     */
    public function companyName($sectors = '', $suffix = 50, $format = '') {
        if ($format == '')
            $format = $this->choose($this->nameFormats);

        $format = $this->parse($format, $sectors);

        if (is_int($suffix))
            if (mt_rand(0, 100) < $suffix)
                $format .= ' ' . $this->companySuffix;
            else
            if ($suffix === true)
                $format .= ' ' . $this->companySuffix;

        return $format;
    }

}

// end of: generator_business.php
// location: ./generators/generator_business.php