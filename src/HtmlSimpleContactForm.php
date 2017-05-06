<?php
namespace Epoque\Chameleon;


class HtmlSimpleContactForm
{
    public $id      = '';
    public $class   = '';
    public $legend  = '';
    public $script  = '';
    
    public $nameField   = '';
    public $contactInfo = '';
    public $message     = '';


    public function __construct($spec)
    {
        if (array_key_exists('id', $spec)) {
            $this->id = $spec['id'];
        }

        if (array_key_exists('class', $spec)) {
            $this->class = $spec['class'];
        }
        if (array_key_exists('legend', $spec)) {
            $this->legend = $spec['legend'];
        }
        if (array_key_exists('script', $spec)) {
            $this->script = $spec['script'];
        }
    }


    public function __toString()
    {
        $html = "<div id=\"$this->id\" class=\"HtmlSimpleContactForm\">\n";
        $html .= "<form>\n";
        $html .= "<fieldset>\n";
        
        if ($this->legend) {
            $html .= "<legend id=\"$this->id-legend\">$this->legend</legend>";
        }

        $html .= "<div id=\"$this->id-error\"></div>\n";
        
        $html .= "\t<input type=\"text\" id=\"$this->id-nameField\"";
        $html .= " placeholder=\"name\"><br>\n";
        $html .= "\t<input type=\"text\" id=\"$this->id-contactInfo\"";
        $html .= " placeholder=\"email/phone\"><br>\n";
        $html .= "\t<textarea id=\"$this->id-message\" placeholder=\"your message...\">";
        $html .= "</textarea><br>\n";
        $html .= '<input id="'.$this->id."-submit\" type=\"button\" value=\"Send\">";
        $html .= "</fieldset>\n";
        $html .= "</form>\n";
        
        if ($this->script) {
            $html .= "<script src=\"$this->script\"></script>\n";
        }
        
        return $html . "</div>\n";
    }
}
