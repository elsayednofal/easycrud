<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elsayednofal\EasyCrud\Http\Builders;

/**
 * Description of Validator
 *
 * @author sayed
 */
class JsValidatorBuilder extends Builder {

    /**
     * Mapping in an array of Laravel Validator class rules
     * and jQuery validator rules in format as
     * Laravel Rule => jQuery Rule"
     */
    private static $mappedRules = array(
        'required' => 'required: true',
        //'remote'	=>	'Not implemented'
        'min:(.*)' => 'minlength: $1',
        'max:(.*)' => 'maxlength: $1',
        'between:(.*),(.*)' => 'rangelength: [$1, $2]',
        'email' => 'email: true',
        'url' => 'url: true',
        'date' => 'date: true',
        'integer' => 'digits: true',
        'numeric' => 'number: true',
        'same:(.*)' => 'equalTo: "#$1"',
    );
    private $result = '';

    function laravelRuleToJqueryRule($field, $rule) {
        $tags[$field] = $field . ': {';

        if (!is_array($rule)) {
            $rule = explode('|', $rule);
        }

        $rolls = array();
        foreach ($rule as $r) {
            $replaced = false;
            foreach (self::$mappedRules as $laravelRule => $jQueryRule) {
                $r = preg_replace('/' . $laravelRule . '/', $jQueryRule, $r);

                if ($r == $jQueryRule) {
                    $replaced = true;
                }
            }

            if ($replaced == true) {
                $rolls[] = $r;
            }
        }
        //return implode(', ', $rolls);
        $tags[$field] .= implode(', ', $rolls);
        $tags[$field] .= '}';
        return $tags;
    }

    public function convertLaravelRulesToJqueryRules($table,$rules,$selector='form') {
        // Overrie the rules if specified
//        if (count($rules) > 0) {
//            static::$rules = $rules;
//        }
        $js="<script>\n";
        $js .= '$("' . $selector . '").validate({'."\n";
        $js .= 'rules: {'."\n";
        $tags = array();
        foreach ($rules as $field => $rule) {
            $tags[$table.'['.$field.']'] = '"'.$table.'['.$field.']"' . ': {';
            if (!is_array($rule)) {
                $rule = explode('|', $rule);
            }
            $rolls = array();
            foreach ($rule as $r) {
                $replaced = false;
                foreach (self::$mappedRules as $laravelRule => $jQueryRule) {
                    $r = preg_replace('/' . $laravelRule . '/', $jQueryRule, $r);

                    if ($r == $jQueryRule) {
                        $replaced = true;
                    }
                }

                if ($replaced == true) {
                    $rolls[] = $r;
                }
            }
            $tags[$table.'['.$field.']'] .= implode(', ', $rolls);
            $tags[$table.'['.$field.']'] .= '}'."\n";
        }
        //dd($tags);
        $js .= implode(', ', $tags);
        $js .= '}});'."\n";
        $js .= '</script>'."\n";
        return $js;
    }
    
    
    
    
}
