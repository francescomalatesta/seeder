<?php

/**
 * 
 * Text related data generator. Uses "Lorem Ipsum..." words as base.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Text extends Generator_Base {

    /**
     * Generates a random sequence of sentences.
     *  
     * @access	public
     * @param	int     $number     Number of sentences
     * @return  string
     */
    public function sentences($number = 0) {
        if ($number == 0)
            $number = mt_rand(5, 10);

        $sentences = array();
        for ($c = 0; $c < $number; $c++)
            $sentences[] = $this->sentence;

        return implode(' ', $sentences);
    }

    /**
     * Generates a random sentence.
     *  
     * @access	public
     * @param	int     $words      Number of words inside the sentence
     * @return  string
     */
    public function sentence($words = 0) {
        if ($words == 0)
            $words = $this->int(10, 20);

        $sentence = $this->words($words);
        $sentence[0] = strtoupper($sentence[0]);
        return $sentence . '.';
    }

    /**
     * Generates a random group of words.
     *  
     * @access	public
     * @param	int     $number      Number of words
     * @return  string
     */
    public function words($number = 0) {
        if ($number == 0)
            $number = mt_rand(5, 20);

        $results = '';
        for ($c = 0; $c < $number; $c++)
            $results .= $this->word . ' ';

        return substr($results, 0, strlen($results) - 1);
    }

}

// end of: generator_text.php
// location: ./generators/generator_text.php