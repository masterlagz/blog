$(document).ready(function(e) {
    $("li.dashboard").hide();
    tinymce.init({
        selector:'textarea#post_content',
        height: 350,
        theme: 'modern',
    });
});