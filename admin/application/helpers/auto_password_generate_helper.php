<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_random_password'))
{
    /**
     * Generate a random password. 
     * 
     * get_random_password() will return a random password with length 6-8 of lowercase letters only.
     *
     * @access    public
     * @param    $chars_min the minimum length of password (optional, default 6)
     * @param    $include_char add letters, means stronger password (optional, default true)
     * @param    $chars_max the maximum length of password (optional, default 8)
     * @param    $use_upper_case boolean use upper case for letters, means stronger password (optional, default true)
     * @param    $include_numbers boolean include numbers, means stronger password (optional, default true)
     * @param    $include_special_chars include special characters, means stronger password (optional, default true)
     *
     * @return    string containing a random password 
     */    
    function get_random_password($chars_min=8, $chars_max=16,$include_char=true, $use_upper_case=true, $include_numbers=true, $include_special_chars=true)
    {
        $length = rand($chars_min, $chars_max);
        $selection = '';
        if($include_char) {
            $selection .= "ZaeuEoQyDibcFdfYgRAhPGCXjkHSBlMmTInLpJqXrUsKtWvNwxVOz";
        }
        if($include_numbers) {
            $selection .= "123456789";
        }
        if($include_special_chars) {
            $selection .= "-+=@.,%&?";
        }

        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                

        return $password;
    }

}