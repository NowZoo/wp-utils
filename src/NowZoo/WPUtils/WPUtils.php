<?php
namespace NowZoo\WPUtils;

class WPUtils{


    /**
     * Whether or not the request method is 'POST' -- i.e. submitting a form
     * @return bool
     */
    public static function is_submitting(){
        return (strcasecmp('POST', $_SERVER['REQUEST_METHOD'] ) == 0);
    }

    /**
     * Provides a replacement for WP's native stripslashes_deep
     * function, which, frustratingly, doesn't trim
     *
     * @param $value
     * @return array|object|string
     */
    public static function trim_stripslashes_deep($value){
        if ( is_array($value) ) {
            $value = array_map(array(get_called_class(), 'trim_stripslashes_deep'), $value);
        } elseif ( is_object($value) ) {
            $vars = get_object_vars( $value );
            foreach ($vars as $key=>$data) {
                $value->{$key} = self::trim_stripslashes_deep( $data );
            }
        } elseif ( is_string( $value ) ) {
            $value = trim(stripslashes($value));
        }
        return $value;
    }

}