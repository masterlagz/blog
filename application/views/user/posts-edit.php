<form method="POST" action="<?php echo Config::BASE_URL; ?>/posts/update" id="post_edit" name="post_edit">
    <div class="row posts ml-auto">
        <button type="submit" name="post_draft" value="1" class="btn btn-sm btn-secondary ml-auto">Draft</button>
        <button type="submit" name="post_publish" value="2" class="btn btn-sm btn-primary">Publish</button>
        <a href="<?php echo Config::BASE_URL; ?>/posts/" class="btn btn-sm btn-danger">Cancel</a>
        <input type="hidden" name="post_id" value="<?php echo $this->results["id"]; ?>">
        <input type="hidden" name="post_action" value="edit">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <p><input type="text" name="post_title" id="post_title" value="<?php echo $this->results["title"]; ?>" style="width:100%;"></p>
                <p><textarea id="post_content" name="post_content" rows="10" cols="8"><?php echo $this->results["content"] ?></textarea></p>
            </div>
            <div class="col-6"><?php echo $this->results["content"] ?></div>
        </div>
    </div>
</form>