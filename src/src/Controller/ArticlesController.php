<?php
// src/Controller/ArticlesController.php

namespace App\Controller;

class ArticlesController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['tags']);
    }

    private $author_actions = ['manage','add','edit'];
    private $editor_actions = ['review','preview','publish'];

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');

        if (in_array($action,$this->author_actions) && !$this->is_author()) {
            return false;
        }
        elseif (in_array($action,$this->editor_actions) && !$this->is_editor()) {
            return false;
        }
        return true;
    }

    // -----

    private function find($where = [])
    {
        return $this->Articles->find('all', ['contain' => ['Tags']])->where($where)->all();
    }

    private function by_slug($slug)
    {
        return $this->Articles->findBySlug($slug)->contain(['Tags'])->firstOrFail();
    }

    // -----

    public function index()
    {
        $articles = $this->find(['status' => 'published']);

        $this->set(compact('articles'));
    }

    public function manage()
    {
        $drafts = $this->find([
            'user_id' => $this->Auth->user('id'),
            'status' => 'draft'
        ]);
        $this->set('articles',$drafts);
    }

    public function review()
    {
        $submitted = $this->find([
            'status' => 'review'
        ]);
        $this->set('articles',$submitted);
    }

    public function view($slug = null)
    {
        $article = $this->by_slug($slug);
        $this->set(compact('article'));
    }

    public function preview($slug = null)
    {
        $this->view($slug);

        $this->set("is_preview",true);
        $this->render('view');
    }

    public function tags($tag)
    {
        $tags = $this->request->getParam('pass');

        $articles = $this->Articles->find('tagged', [ 'tags' => [$tag] ])
            ->contain(['Tags']);

        $this->set([ 'articles' => $articles, 'tag' => $tag ]);
    }

    // -----

    public function approve()
    {
        $id = intval($this->request->getData()['id']);

        $article = $this->Articles->get($id);
        $article->status = 'published';
        $this->Articles->save($article);

        $this->Flash->success(__('Article approved'));
        return $this->redirect(['action' => 'view',$article->slug]);
    }

    // ------

    private $article_status = 'review';
    private $article;
    private $options = [];

    public function saveDraft()
    {
        $this->is_ajax = true;
        $data = $this->request->getData();
        if (!$data['id']) {
            $this->article_status = 'draft';
            $this->add();
        } else {
            $article = $this->Articles->get($data['id']);
            $this->edit($article->slug);
        }
        echo json_encode(['article_id' => $this->article->id]);
        die;
    }

    // -------

    public function add()
    {
        $this->article = $this->Articles->newEntity();
        $this->article_form(['user_id' => $this->Auth->user('id')]);
    }

    public function edit($slug)
    {
        $data = [];
        $this->article = $this->by_slug($slug);
        $this->options = ['accessibleFields' => ['user_id' => false]];
        $this->article_form($data);
    }

    private function article_form($data = [])
    {
        if (!$this->request->is('ajax')) {
            $data['status'] = 'review';
        }

        if ($this->request->is(['post','put'])) {
            $response = $this->post_article($data);
            if ($response) {
                return;
            }
        }

        $tags = $this->Articles->Tags->find('list');

        $this->set(['tags' => $tags, 'article' => $this->article]);
    }

    private function post_article($data)
    {
        $saved = $this->patch($data);

        if ($this->request->is('ajax')) {
            return true;
        }

        if ($saved) {
            $saved_message = 'Your article has been saved.';
            if (!$this->request->is('ajax')) {
                $saved_message = 'Your article has been sent for review.';
            }
            $this->Flash->success(__($saved_message));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to add your article.'));
    }

    private function patch($data)
    {
        $data = array_merge($this->request->getData(),$data);
        $this->article = $this->Articles->patchEntity($this->article, $data, $this->options);
        $saved = $this->Articles->save($this->article);
        return $saved;
    }
}
