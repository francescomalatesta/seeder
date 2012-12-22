<?php

/**
 * 
 * Places related data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Places extends Generator_Base {

    var $cityNameFormats = array(
        '{People:firstName}{Places:citySuffix}',
        '{People:lastName}{Places:citySuffix}',
        '{People:lastName} {Places:citySuffix}',
        '{Places:cityPrefix} {People:lastName}',
        '{Places:cityPrefix}{Places:citySuffix}'
    );
    var $streetNameFormats = array(
        '{People:lastName} {Places:streetSuffix}',
        '{People:lastName} {Places:cityPrefix} {Places:streetSuffix}'
    );
    var $addressFormats = array(
        '{Places:buildingNumber} {Places:street}'
    );

    /**
     * Generates a random city name choosing a random format from $cityNameFormats.
     *  
     * @access	public
     * @return  string
     */
    public function city() {
        $city = $this->parse($this->choose($this->cityNameFormats));
        $city = explode(' ', $city);

        if (count($city) > 1) {
            foreach ($city as $k => $v) {
                $city[$k][0] = strtoupper($city[$k][0]);
            }
        }

        $city = implode(' ', $city);

        return $city;
    }

    /**
     * Generates a random address choosing a random format from $addressFormats.
     *  
     * @access	public
     * @return  string
     */
    public function address() {
        return $this->parse($this->choose($this->addressFormats));
    }

    /**
     * Generates a street name choosing a random format from $addressFormats.
     *  
     * @access	public
     * @return  string
     */
    public function street() {
        $street = $this->parse($this->choose($this->streetNameFormats));
        $street = explode(' ', $street);

        if (count($street) > 1) {
            foreach ($street as $k => $v) {
                $street[$k][0] = strtoupper($street[$k][0]);
            }
        }

        $street = implode(' ', $street);

        return $street;
    }

    /**
     * Generates a random building number.
     *  
     * @access	public
     * @return  string
     */
    public function buildingNumber() {
        return $this->int(1, 200);
    }

    /**
     * Generates a random postal code.
     *  
     * @access	public
     * @param	string      $format    Desired format. Default is 'nnnnn'.
     * @return  string
     */
    public function postalCode($format = 'nnnnn') {
        return $this->format($format);
    }

    /**
     * Generates a random latitude.
     *  
     * @access	public
     * @return  string
     */
    public function latitude() {
        return number_format(mt_rand(-180000000, 180000000) / 1000000, 6);
    }

    /**
     * Generates a random longitude.
     *  
     * @access	public
     * @return  string
     */
    public function longitude() {
        return number_format(mt_rand(-180000000, 180000000) / 1000000, 6);
    }

}

// end of: generator_places.php
// location: ./generators/generator_places.php