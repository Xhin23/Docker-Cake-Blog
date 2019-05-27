<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Tag extends Entity
{
    protected $_accessible = [
        'title' => true,
        'created' => true,
        'modified' => true,
        'articles' => true
    ];
}
