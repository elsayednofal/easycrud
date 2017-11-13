<?php

namespace Elsayednofal\EasyCrud\Http\Helpers;

/**
 * Description of Models
 *
 * @author sayed
 */
class Models {

    function getModels() {
        $classes=[];
        $app_classes=glob('./../app/*.php');
       
        $models_classes=glob('./../app/Models/*.php');
        $files=array_merge($app_classes,$models_classes);
        
        foreach ($files as $file) {
            $newNamespaces = $this->extract_namespace($file);
            $class_name = basename($file, '.php');
            $class=$newNamespaces.'\\'.$class_name;
            $class_object=new $class;
            if ($class_object instanceof \Illuminate\Database\Eloquent\Model) {
                $classes[] = $class;
            }
        }
        return $classes;
    }
    
    function extract_namespace($file) {
        $ns = NULL;
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'namespace') === 0) {
                    $parts = explode(' ', $line);
                    $ns = rtrim(trim($parts[1]), ';');
                    break;
                }
            }
            fclose($handle);
        }
        return $ns;
    }
    
    function getFullNamespace($file){
        $newNamespaces = $this->extract_namespace($file);
            $class_name = basename($file, '.php');
            $class=$newNamespaces.'\\'.$class_name;
            return $class;
    }

}
