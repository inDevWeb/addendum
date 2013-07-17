<?php

namespace Addendum\Parser;

class AnnotationsMatcher
{
    public function matches($string, &$annotations)
    {
        $annotations = array();
        $annotationMatcher = new AnnotationMatcher();
        
        while(true)
        {
            if(preg_match('~(?<leadingSpace>\s)?(?=@)~', $string, $matches, PREG_OFFSET_CAPTURE))
            {
                $offset = $matches[0][1];
                
                if(isset($matches['leadingSpace']))
                {
                    $offset += 1;
                }
                
                $string = substr($string, $offset);
            }
            else
            {
                // no more annotations
                break;
            }
            
            if(($length = $annotationMatcher->matches($string, $data)) !== false)
            {
                $string = substr($string, $length);
                
                list($name, $params) = $data;
                $annotations[$name][] = $params;
            }
            else
            {
                // Move on !
                $string = substr($string, 1);
            }
        }
    }
}