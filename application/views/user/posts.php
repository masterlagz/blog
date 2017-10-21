<div class="row posts ml-auto">
    <a href="<?php echo Config::BASE_URL; ?>/posts/add/" class="btn btn-sm btn-primary ml-auto" role="button">Add New</a>
</div>

<div class="row">
	<?php if ($this->success_message) { ?>
	<div class="col">
		<div class="alert alert-success" role="alert"><?php echo $this->success_message; ?></div>
	</div>
	<?php } ?>

    <table id="posts" class="table" width="100%">
        <thead>
            <tr>
                <th width="5%">&nbsp;</th>
                <th width="20%">Title</th>
                <th width="60%">Content</th>
                <th width="10%">Status</th>
                <th width="5%">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($this->results->data as $key => $post) { ?>
            <tr>
                <th scope="row"><input type="checkbox" name="post[]" value="<?php echo $post->id; ?>"></th>
                <td><?php echo $post->title; ?></td>
                <td><?php echo substr($post->content, 0, 50); ?></td>
                <td><?php echo ($post->status == 1 ? "Draft" : "Published"); ?></td>
                <td>
					<a href="<?php echo Config::BASE_URL; ?>/posts/edit?id=<?php echo $post->id; ?>" id="<?php echo $post->id; ?>" class="btn btn-sm btn-danger edit">&nbsp;</a>
					<a href="<?php echo Config::BASE_URL; ?>/posts/delete?id=<?php echo $post->id; ?>" id="<?php echo $post->id; ?>" class="btn btn-sm btn-danger delete">&nbsp;</a>
				</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div class="row">
    <nav aria-label="Page navigation example">
        <?php echo $this->pagination; ?>
    </nav>
</div>