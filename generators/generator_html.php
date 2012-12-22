<?php

/**
 * 
 * HTML contents data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_HTML extends Generator_Base {

    /**
     * Generates an h1 random tag with some contents.
     *  
     * @access	public
     * @param	int     $words      Number of words inside the tag
     * @return  string
     */
    public function h1($words = 2) {
        return '<h1>' . $this->generator->Text->sentence($words) . '</h1>';
    }

    /**
     * Generates an h2 random tag with some contents.
     *  
     * @access	public
     * @param	int     $words      Number of words inside the tag
     * @return  string
     */
    public function h2($words = 6) {
        return '<h2>' . $this->generator->Text->sentence($words) . '</h2>';
    }

    /**
     * Generates an h3 random tag with some contents.
     *  
     * @access	public
     * @param	int     $words      Number of words inside the tag
     * @return  string
     */
    public function h3($words = 8) {
        return '<h3>' . $this->generator->Text->sentence($words) . '</h3>';
    }

    /**
     * Generates an h4 random tag with some contents.
     *  
     * @access	public
     * @param	int     $words      Number of words inside the tag
     * @return  string
     */
    public function h4($words = 8) {
        return '<h4>' . $this->generator->Text->sentence($words) . '</h4>';
    }

    /**
     * Generates a paragraph random tag with some contents.
     *  
     * @access	public
     * @param	int     $sentences  Number of sentences inside the tag
     * @return  string
     */
    public function p($sentences = 0) {
        return '<p>' . $this->generator->Text->sentences($sentences) . '</p>';
    }

    /**
     * Generates a li random tag with some contents.
     *  
     * @access	public
     * @param	int     $words      Number of words inside the tag
     * @return  string
     */
    public function li($words = 3) {
        return '<li>' . $this->generator->Text->sentence($words) . '</li>';
    }

    /**
     * Generates an ul random tag with some contents.
     *  
     * @access	public
     * @param	int     $count      Specifies how many elements are inside the list
     * @param	int     $words      Number of words inside each list item
     * @return  string
     */
    public function ul($count = 3, $words = 3) {
        $ul = '<ul>';

        for ($c = 0; $c < $count; $c++)
            $ul .= $this->li($words);

        $ul .= '</ul>';

        return $ul;
    }

    /**
     * Generates an img random tag using the placehold.it service.
     *  
     * @access	public
     * @param	int     $width      Specifies the image width
     * @param	int     $height     Specifies the image height
     * @return  string
     */
    public function img($width = 0, $height = 0) {
        if ($width == 0)
            $width = mt_rand(300, 500);
        if ($height == 0)
            $height = mt_rand(200, 300);

        return '<img src="http://placehold.it/' . $width . 'x' . $height . '" />';
    }

    /**
     * Generates a div random tag with some elements inside.
     *  
     * @access	public
     * @param	int     $contents   Specifies the tag sequence inside the div
     * @return  string
     */
    public function div($contents = 'h1 h2 img p p') {
        $tags = explode(' ', $contents);

        $contents = '<div>';
        foreach ($tags as $tag) {
            if (method_exists($this, $tag))
                $contents .= call_user_func(array($this, $tag));
        }

        return $contents . '</div>';
    }

}

// end of: generator_html.php
// location: ./generators/generator_html.php