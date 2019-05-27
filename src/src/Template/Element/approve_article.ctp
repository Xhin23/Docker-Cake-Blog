<div class="approve-article">
    <?php
    echo $this->Form->create(false,["url" => '/articles/approve']);
    echo $this->Form->hidden('id',["value" => $article->id]);
    echo $this->Form->button('Publish',["class" => "publish-article"]);
    echo $this->Form->end();
    ?>
</div>
