<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\Collection\Collection;
use Cake\ORM\Entity;
use Cake\Utility\Text;

class Article extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'slug' => false,
    ];

    protected function _getTagString()
    {
        if (isset($this->_properties['tag_string'])) {;
            return $this->_properties['tag_string'];
        }

        if (empty($this->tags)) {
            return '';
        }
        $tags = new Collection($this->tags);

        $str = $tags->reduce(function ($string, $tag) {
            return $string . $tag->title . ', ';
        }, '');

        return trim($str, ', ');
    }

    protected function _getShortBody()
    {
        return Text::truncate($this->body,100,['html' => true]);
    }
}
