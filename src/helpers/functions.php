<?php

if (!function_exists('kebab_case')) {

    /**
     * Convert a string to kebab case.
     *
     * @param  string  $value
     * @return string
     */
    function kebab_case($value) {
         return snake($value,'-');
    }

}

if (!function_exists('camel_case')) {

    /**
     * Convert a value to camel case.
     *
     * @param  string  $value
     * @return string
     */
    function camel_case($value) {
         $value = ucwords(str_replace(['-', '_'], ' ', $value));
         $value=str_replace(' ', '', $value);
         return lcfirst($value);
    }

}

function snake($value, $delimiter = '_') {
    

    if (!ctype_lower($value)) {
        $value = preg_replace('/\s+/u', '', ucwords($value));

        $value =mb_strtolower((preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value)), 'UTF-8');
    }

    return  $value;
}
