<article class="article">

    <h3 class="article-title">
        <?php if (isset($is_index)): ?>
            <a href="/articles/view/<?= $article->slug ?>">
        <?php endif; ?>
            <?= h($article->title) ?>
        <?php if (isset($is_index)): ?>
            </a>
        <?php endif; ?>
    </h3>

    <p class="article-date">
        <?= $article->created->format(DATE_RFC850) ?>
    </p>
    <p class="article-body"><?= h($article->body) ?></p>

    <?php if ($article->tags): ?>
        <p><b class="tag-title">Tags:</b>
            <span class="tags">
            <?php foreach ($article->tags as $tag) : ?>
                <?= $this->Html->link($tag['title'],['action' => 'tagged', $tag['title']]) ?>
            <?php endforeach; ?>
            </span>
        </p>
    <?php endif; ?>

</article>
