<?php

/**
 *
 * Internet related data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Internet extends Generator_Base {

    var $usernameFormats = array(
        '{People:firstName}.{People:lastName}',
        '{People:lastName}.{People:firstName}',
        '{People:firstName (0,1)}.{People:lastName}',
        '{People:lastName (0,1)}.{People:firstName}',
        '{People:firstName (0,1)}{People:lastName}',
        '{People:lastName (0,1)}{People:firstName}',
        '{People:lastName (0,3)}{People:firstName (0,3)}',
        '{People:firstName (0,3)}{People:lastName (0,3)}'
    );

    /**
     * Generates a random ipv4 address.
     *  
     * @access	public
     * @param	string  $min    The lower desired ip
     * @param	string  $max    The higher desired ip
     * @return  string
     */
    public function ipv4($min = -2147483648, $max = 2147483647) {
        if ($min != '')
            $min = ip2long($min);
        if ($max != '')
            $max = ip2long($max);

        return long2ip(mt_rand($min, $max));
    }

    /**
     * Generates a random ipv6 address.
     *  
     * @access	public
     * @return  string
     */
    public function ipv6() {
        $format = 'hhhh:hhhh:hhhh:hhhh:hhhh:hhhh:hhhh:hhhh';
        return $this->format($format);
    }

    /**
     * Generates a random MAC address.
     *  
     * @access	public
     * @return  string
     */
    public function macAddress() {
        $format = 'hh-hh-hh-hh-hh-hh';
        return $this->format($format);
    }

    /**
     * Generates a random company email address.
     *  
     * @access	public
     * @param	string  $tlds    Desired tlds to use in random extraction
     * @param	string  $sectors Desired sectors to use in random extraction
     * @return  string
     */
    public function companyMail($tlds = 'common', $sectors = '') {
        return $this->username . '@' . $this->domain($tlds, $sectors);
    }

    /**
     * Generates a random free email address.
     *  
     * @access	public
     * @return  string
     */
    public function freeEmail() {
        return $this->username . '@' . $this->freeEmailDomain;
    }

    /**
     * Generates a random username, based on people first and
     * last names.
     * 
     * Example:
     *      Name: John, Last Name: Smith
     * 
     * Result:
     *      j.smith@domain.com
     *      john.smith@domain.com
     *  
     * @access	public
     * @param	string  $min    The lower desired ip
     * @param	string  $max    The higher desired ip
     * @return  string
     */
    public function username($format = '') {
        if ($format == '')
            $format = $this->choose($this->usernameFormats);

        $format = $this->parse($format);
        return strtolower($format);
    }

    /**
     * Generates a random password.
     *  
     * @access	public
     * @param	int     $length         Desired password length. Default is 8 chars.
     * @param	boolean $numbers        Includes number characters in random extraction
     * @param	boolean $upperCase      Includes upper case characters in random extraction
     * @param	boolean $specialChars   Includes special characters in random extraction
     * @return  string
     */
    public function password($length = 8, $numbers = true, $upperCase = false, $specialChars = false) {
        $p = '';
        for ($c = 0; $c < $length; $c++) {
            $p .= $this->char($numbers, $upperCase, $specialChars);
        }

        return $p;
    }

    /**
     * Generates a random domain.
     *  
     * @access	public
     * @param	string  $tlds    Desired tlds to use in random extraction
     * @param	string  $sectors Desired sectors to use in random extraction
     * @return  string
     */
    public function domain($tlds = 'common', $sectors = '') {
        $company = explode(' ', $this->generator->Business->companyName($sectors));
        if (count($company) > 1)
            $company = reset($company) . $this->choose($company);
        else
            $company = reset($company);

        $company = str_replace(array('\'', '.', '/'), '', $company);

        return strtolower($company) . '.' . $this->tld($tlds);
    }

}

// end of: generator_internet.php
// location: ./generators/generator_internet.php