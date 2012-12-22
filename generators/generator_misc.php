<?php

/**
 * 
 * Various kind of data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Misc extends Generator_Base {

    /**
     * Generates a random md5 hash.
     *  
     * @access	public
     * @return  string
     */
    public function md5() {
        return md5(mt_rand(0, @time()));
    }

    /**
     * Generates a random sha1 hash.
     *  
     * @access	public
     * @return  string
     */
    public function sha1() {
        return sha1(mt_rand(0, @time()));
    }

    /**
     * Generates a random sha256 hash.
     *  
     * @access	public
     * @return  string
     */
    public function sha256() {
        return hash('sha256', mt_rand(0, @time()));
    }

    /**
     * Generates a random sha512 hash.
     *  
     * @access	public
     * @return  string
     */
    public function sha512() {
        return hash('sha512', mt_rand(0, @time()));
    }

    /**
     * Generates a random hash with the preferred algorithm.
     *  
     * @access	public
     * @param	int     $algorithm  Desired algorithm name.
     * @return  string
     */
    public function hash($algorithm) {
        return hash($algorithm, mt_rand(0, @time()));
    }

    /**
     * Generates a random base64 encoded content.
     *  
     * @access	public
     * @return  string
     */
    public function base64() {
        return base64_encode(mt_rand(0, @time()));
    }

    /**
     * Generates a random hex color code.
     *  
     * @access	public
     * @return  string
     */
    public function color() {
        return $this->format('#hhhhhh');
    }

}

// end of: generator_misc.php
// location: ./generators/generator_misc.php