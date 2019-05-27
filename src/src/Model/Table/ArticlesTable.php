<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags', [
          'joinTable' => 'articles_tags',
          'dependent' => true
        ]);
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            $entity->slug = substr($sluggedTitle, 0, 180);

            $entity->groupslug = $entity->slug;

            $groupslugs = $this->findByGroupslug($entity->groupslug)->count();
            if ($groupslugs) {
                $entity->slug .= '-'.(intval($groupslugs)+1);
            }
        }

        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }
    }

    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'Articles.id', 'Articles.user_id', 'Articles.status', 'Articles.title',
            'Articles.body', 'Articles.created', 'Articles.slug', 'Articles.groupslug'
        ];

        $query = $query
            ->select($columns)
            ->distinct($columns);

        if (empty($options['tags'])) {
            $query->leftJoinWith('Tags')->where(['Tags.title IS' => null]);
        } else {
            $query->innerJoinWith('Tags')->where(['Tags.title IN' => $options['tags']]);
        }

        return $query->group(['Articles.id']);
    }

    protected function _buildTags($tagString)
    {
        $newTags = array_map('trim', explode(',', $tagString));
        $newTags = array_filter($newTags);
        $newTags = array_unique($newTags);

        $out = [];
        $query = $this->Tags->find()->where(['Tags.title IN' => $newTags]);

        foreach ($query->extract('title') as $existing) {
            $index = array_search($existing, $newTags);
            if ($index !== false) {
                unset($newTags[$index]);
            }
        }

        foreach ($query as $tag) {
            $out[] = $tag;
        }
        foreach ($newTags as $tag) {
            $out[] = $this->Tags->newEntity(['title' => $tag]);
        }
        return $out;
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('body', 'custom', [
              'rule' => ['minLength', 10],
              'message' => 'Body must be 10 characters or longer.'
            ])
            ->add('title', [
                'minLength' => [
                    'rule' => ['minLength', 5],
                    'last' => true,
                    'message' => 'Title must be longer than 5 characters.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 255],
                    'message' => 'Title must not be longer than 255 characters.'
                ]
            ]);

        return $validator;
    }
}
