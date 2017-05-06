<?php
namespace Epoque\Chameleon;


/**
 * JS
 * 
 * Handles adding script tags based upon REQUEST_URI.
 *
 * @author jason favrod <jason@lakonacomputers.com>
 */

class JS extends Common implements RouterInterface
{
    static $BOOTSTRAP = '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
    static $jQuery    = '<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>';
    static $jQueryUI  = '<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>';
    
    private static $routes = [];


    /**
     * trio
     *
     * Prints the script tags for jQuery, jQuery-UI, and
     * Bootstrap JavaScript.
     */

    public static function trio()
    {
        $html  = '';

        $html .= "<!-- jQuery -->\n";
        $html .= self::$jQuery . "\n";
        $html .= "<!-- jQuery-UI -->\n";
        $html .= self::$jQueryUI . "\n";
        $html .= "<!-- Bootstrap JS -->\n";
        $html .= self::$BOOTSTRAP . "\n";

        print $html;
    }


    public static function tags($src)
    {
        $html = '';

        if (is_string($src)) {
            
            if ($src === 'trio') {
                self::trio();
            }
            else {
                if (is_file(APP_ROOT.JS_DIR . $src)) {
                    $html .= '<script src="' . JS_DIR . $src . '"></script>'."\n";
                }
                else if (is_file($src)) {
                    $html .= '<script src="' . $src . '"></script>'."\n";
                }
                else {
                    self::logWarning('The source (' . $src . ') for JS is not valid.');
                }
            }
        }
        else if (is_array($src)) {
            foreach ($src as $source) {
                if ($source === 'trio') {
                    self::trio();
                }
                else {
                    if (is_file(APP_ROOT.JS_DIR . $source)) {
                        $html .= '<script src="' . JS_DIR . $source . '"></script>'."\n";
                    }
                    else if (is_file($source) || file_get_contents('http:'.$source, False, NULL, 20)) {
                        $html .= '<script src="' . $source . '"></script>'."\n";
                    }
                    else {
                        self::logWarning('The source item (' . $source . ') for JS is not valid.');
                    }
                }
            }
        }

        print $html;
    }

    
    public static function addRoute($route=[]) {
        if (is_array($route) && count($route) === 1)
        {
            $req = trim(key($route), '/');
            $res = current($route);
            
            if (is_string($req) && is_string($res)) {
               self::$routes[$req] = $res;
            }
            else {
                self::logError(__METHOD__ . ": invalid route ([$req => $res])");
            }
        }
        else {
            self::logError(__METHOD__ . ': route argument not array, is empty, or is too large.');
        }
    }

        
    public static function fetchRoute() {
        if (array_key_exists(self::URI(), self::$routes)) {
            $js = str_replace(' ', '', self::$routes[self::URI()]);
            self::tags(explode(',', $js));
        }
        else if (is_file(APP_ROOT . 'resources/js/' . self::URI() . '.js')) {
            self::tags([self::URI() . '.js']);
        }
	else if (self::wildcardMatch()) {
	   // wildcardMatch prints the script tags.
	   return;
       }
    }


    private static function wildcardMatch()
    {
        foreach (self::$routes as $req => $res) {
            if (preg_match('`\*$`', $req)) {
                $req = rtrim($req, '*');
                $req = rtrim($req, '/');

                if (preg_match("`^$req"."($|(/*[\w|=|;|&]*)+)`", self::URI())) {
                   self::tags(explode(',', $res));
                }   
            }   
        }   
        
        return False;
     }

}
