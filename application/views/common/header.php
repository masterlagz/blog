<!DOCTYPE html>
<html>
<head>
<title>OnePage - Blog</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-signin-client_id" content="621428430077-b0mijuue56iv6n4m3m7nj1coof9tm40p.apps.googleusercontent.com">
<!-- CSS -->
<link rel="stylesheet" href="<?php echo Config::BASE_URL; ?>/public/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo Config::BASE_URL; ?>/public/css/styles.css">
<!-- JS -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script type="application/javascript" src="<?php echo Config::BASE_URL; ?>/public/js/jquery-3.2.1.min"></script>
<script type="application/javascript" src="<?php echo Config::BASE_URL; ?>/public/js/tinymce/tinymce.min.js"></script>
<script type="application/javascript" src="<?php echo Config::BASE_URL; ?>/public/js/common.js"></script>
<script type="application/javascript">
function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    var userData = {
        email : profile.getEmail(),
        token : googleUser.getAuthResponse().id_token
    }

    if ( profile.getId() ) {
        $("li.dashboard").show();
        $("li.signin").hide();
        $("a.navbar-brand").html("<a href='<?php echo Config::BASE_URL; ?>'><img src='" + profile.getImageUrl() + "' style='width:35px;'></a>");
    }

    $.ajax({
        type: 'POST',
        url: "<?php echo Config::BASE_URL; ?>/login/validate",
        data: userData,
        dataType: 'json',
        success : function(data) {
            console.log( data );
        }
    });
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        $.ajax({
            type: 'POST',
            url: "<?php echo Config::BASE_URL; ?>/login/signout",
            data: "true",
            dataType: 'json',
            success : function(data) {
                console.log( data );
            }
        });

        document.location.href = "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo Config::BASE_URL; ?>";
    });
}
</script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a class="nav-link" href="<?php echo Config::BASE_URL; ?>">Home <span class="sr-only">(current)</span></a></li>
            <li class="nav-item dashboard">
                <div class="dropdown show">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dashboard</a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo Config::BASE_URL; ?>/posts">Posts</a>
                        <a class="dropdown-item" href="#" onclick="signOut();">Sign Out</a>
                    </div>
                </div>
            </li>
            <li class="nav-item signin"><a class="g-signin2 mt-2 mt-md-0" data-onsuccess="onSignIn"></a></li>
        </ul>
    </div>
</nav>

<?php if ($this->hide !== true) { ?>
<div class="jumbotron">
    <div class="container">
        <h1 class="display-4">Single Page APP!</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
    </div>
</div>
<?php } ?>

<div class="container">
