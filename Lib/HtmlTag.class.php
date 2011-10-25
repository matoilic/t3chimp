<?php

class HtmlTag {
    private $attributes = array();
    private $content = '';
    private $selfClosing = false;
    private $tagName;

    public function __construct($tagName, $selfClosing = false) {
        $this->tagName = $tagName;
        $this->selfClosing = $selfClosing;
    }

    public function addContent($content) {
        if($content != null) {
            $this->content .= $content;
        }
    }

    private function attributesToString() {
        $stringAttributes = array();
        foreach($this->attributes as $name => $value) {
            $stringAttributes[] = $name . '="' .$value . '"';
        }

        return implode(' ', $stringAttributes);
    }

    public function setAttribute($name, $value) {
        if($value != null) {
            $this->attributes[$name] = $value;
        } else {
            unset($this->attributes[$name]);
        }
    }

    public function __toString() {
        $tag = '<' . $this->tagName . ' ' . $this->attributesToString();

        if($this->selfClosing) {
            $tag .= ' />';
            return $tag;
        }

        $tag .= '>' . $this->content . '</' . $this->tagName . '>';

        return $tag;
    }
}
