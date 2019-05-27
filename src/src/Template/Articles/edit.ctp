<?php
    $this->extend('/Common/panel');
?>
<h2>Edit Article</h2>

<div id="alter-article">
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->Form->control('tag_string', ['type' => 'text','label' => 'Separate tags with commas']);
    echo '<span id="save-draft">'.$this->Form->button('Save Draft',['type' => 'button']).'</span>';
    echo $this->Form->button(__('Send Article for Review'));
    echo $this->Form->end();

    echo $this->Html->scriptBlock('var _id = '.$article->id,['block' => 'script_vars']);
?>
</div>
