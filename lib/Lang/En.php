<?php
namespace ybourque\Wikparser\lib\Lang;

use ArrayAccess;

abstract class AbstractLang implements ArrayAccess
{
    public function offsetExists($key)
    {
        return property_exists($this, $key);
    }

    public function offsetGet($key)
    {
        return $this->$key;
    }

    public function offsetSet($key, $val)
    {
        $this->$key = $val;
    }

    public function offsetUnset($key)
    {
        $this->$key = null;
    }
}

class En extends AbstractLang
{
    protected $langCode = "en";
    protected $langSeparator = "----";
    protected $defHeader = "";
    protected $defTag = "# ";
    protected $synHeader = "====Synonyms====";
    protected $hyperHeader = "====Hypernyms====";
    protected $genderPattern = "";
    protected $posMatchType = "array";
    protected $posPattern = "";
    protected $posArray = array(
        '===Noun===',
        '===Verb===',
        '===Adjective===',
        '===Adverb===',
        '===Preposition===',
        '===Particle===',
        '===Pronouns===',
        '===Interjection===',
        '===Conjunction===',
        '===Article==='
    );
    protected $posExtraString = "=";
    protected $langHeader = '==\s*English\s*==';
}
