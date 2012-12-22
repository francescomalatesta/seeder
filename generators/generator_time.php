<?php

/**
 *
 * Time related data generator.
 * 
 * @package	Seeder
 * @author	Francesco Malatesta
 * @link	http://hellofrancesco.com
 */
class Generator_Time extends Generator_Base {

    /**
     * Creates the DateTime object used by other methods.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function baseDT($start = '', $end = '') {
        if ($start == '')
            $start = '- 50 years';
        if ($end == '')
            $end = 'now';

        $start = strtotime($start);
        $end = strtotime($end);

        return new DateTime('@' . mt_rand($start, $end));
    }

    /**
     * Returns a random timestamp in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function timestamp($start = '', $end = '') {
        return $this->baseDT($start, $end)->format('U');
    }

    /**
     * Returns a random time in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @param	string     $format  Time format. Default is "H:i:s"
     * @return  string
     */
    public function time($start = '', $end = '', $format = 'H:i:s') {
        return $this->baseDT($start, $end)->format($format);
    }

    /**
     * Returns a random date in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @param	string     $format  Date format. Default is "Y-m-d"
     * @return  string
     */
    public function date($start = '', $end = '', $format = 'Y-m-d') {
        return $this->baseDT($start, $end)->format($format);
    }

    /**
     * Returns a random iso8601 time in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function iso8601($start = '', $end = '') {
        return $this->baseDT($start, $end)->format(DateTime::ISO8601);
    }

    /**
     * Returns a random atom time in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function atom($start = '', $end = '') {
        return $this->baseDT($start, $end)->format(DateTime::ATOM);
    }

    /**
     * Returns a random rss time in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function rss($start = '', $end = '') {
        return $this->baseDT($start, $end)->format(DateTime::RSS);
    }

    /**
     * Returns a random w3c time in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function w3c($start = '', $end = '') {
        return $this->baseDT($start, $end)->format(DateTime::W3C);
    }

    /**
     * Returns a random rfc1036 time in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function rfc1036($start = '', $end = '') {
        return $this->baseDT($start, $end)->format(DateTime::RFC1036);
    }

    /**
     * Returns a random rfc2822 time in the specified interval.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function rfc2822($start = '', $end = '') {
        return $this->baseDT($start, $end)->format(DateTime::RFC2822);
    }

    /**
     * Returns a random year.
     *  
     * @access	public
     * @param	string     $start   Interval start, default is "- 50 years"
     * @param	string     $end     Interval end, default is "now"
     * @return  string
     */
    public function year($start = '', $end = '') {
        return $this->baseDT($start, $end)->format('Y');
    }

    /**
     * Returns a random month.
     *  
     * @access	public
     * @return  string
     */
    public function month() {
        return $this->baseDT()->format('m');
    }

    /**
     * Returns a random day.
     *  
     * @access	public
     * @return  string
     */
    public function day() {
        return $this->baseDT()->format('d');
    }

    /**
     * Returns a random hour.
     *  
     * @access	public
     * @return  string
     */
    public function hour() {
        return $this->baseDT()->format('H');
    }

    /**
     * Returns a random minute.
     *  
     * @access	public
     * @return  string
     */
    public function minute() {
        return $this->baseDT('', '')->format('m');
    }

    /**
     * Returns a random second.
     *  
     * @access	public
     * @return  string
     */
    public function second() {
        return $this->baseDT('', '')->format('s');
    }

    /**
     * Returns a random timezone.
     * 
     * You can also specify the area:
     * 
     * Example:
     *      timeZone('America');
     *  
     * @access	public
     * @param	string     $where   Specifies the desired area.
     * @return  string
     */
    public function timeZone($where = '') {
        $timezones = array(
            'Africa' => 1, 'America' => 2, 'Antarctica' => 4, 'Arctic' => 8,
            'Asia' => 16, 'Atlantic' => 32, 'Australia' => 64, 'Europe' => 128,
            'Indian' => 256, 'Pacific' => 512, 'UTC' => 1024, 'All' => 2047,
            'AllWithBc' => 4095, 'PerCountry' => 4096);

        if (isset($timezones[$where]))
            $where = $timezones[$where];
        else
            $where = $timezones['All'];

        return $this->choose(DateTimeZone::listIdentifiers($where));
    }

}

// end of: generator_time.php
// location: ./generators/generator_time.php