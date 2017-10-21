<div class="row">
    <div class="col">
        <dl>
            <?php foreach ($this->results->data as $key => $post) { ?>
            <dt><a href="#"><?php echo $post->title; ?></a></dt>
            <dd><?php echo $post->content; ?></dd>
            <?php } ?>
        </dl>
    </div>
</div>

<div class="row">
    <nav aria-label="Page navigation example">
        <?php echo $this->pagination; ?>
    </nav>
</div>