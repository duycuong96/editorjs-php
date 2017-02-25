<?php

namespace CodexEditor\Tools;

use CodexEditor\Factory;
use \CodexEditor\Tools\Base;
use \CodexEditor\Interfaces\HTMLPurifyable;
use \HTMLPurifier;

class Header extends Base implements HTMLPurifyable
{
    protected $template = 'header';

    public function initialize()
    {
        $this->sanitize();
        return $this->validate();
    }

    /**
     * Header shoudn't contain tags. Only string
     */
    public function sanitize()
    {
        $sanitizer = clone $this->sanitizer;

        $purifier = new HTMLPurifier($sanitizer);
        $this->data['data']['text'] = $purifier->purify($this->data['data']['text']);
    }

    public function validate()
    {
        if (is_array($this->data) && in_array($this->data['type'], Factory::getAllowedBlockTypes()['Header'])
             && is_array($this->data['data']) && isset($this->data['data']['format']) && $this->data['data']['format'] === 'html'
            && isset($this->data['data']['text']) && !empty($this->data['data']['text'])) {

            return true;
        }

        return null;
    }

    public function getTemplate()
    {
        return $this->template;
    }
}