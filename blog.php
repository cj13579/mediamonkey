<?php 
session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	$_SESSION['tryme'] = 1;
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Media Monkey</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Header -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Media Monkey</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="moviemonkey.php">Movies</a></li>
            <li><a href="tvmonkey.php">TV</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          
          <!-- Search -->
          <!-- <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form> -->
          <!-- End Search -->
          
        </div>
      </div>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="container">
      	<!-- <div class="row"><div class="col-md-12"><h1>The MediaMonkey Blog</h1></div></div> -->
      	<div class="row">
      	<p>
      	<p>
      	</div>
      	<div class="row">
      	<!-- <div class="col-md-12" id="whatever">
      	<h3>Post Title!<small> April 18, 2014 by Chris</small></h3>
      	Dont remove the below <p>
      	<p>
      	</div> -->
      	<div class="col-md-12" id="moviesubs">
      	<h3>Subscriptions and Profile updates!<small> August 03, 2014 by Chris</small></h3>
      	<p>Well, I have suggested that Movie and TV show subscriptions has been coming for a while, and it is only half here, but Movie subscriptions are live! Also, I have put some new functionality on the profile page so if you login to <a href="http://www.cjblake.net/downloads">MediaMonkey</a> then you will be able to see all the awesome stuff you can see about yourself and how you use MediaMonkey.</p>
      	<p>With regard to the Movie subscriptions, what this means is that if you add your email address and signup for movie updates then Media Monkey will email you every time there is a new movie added to the system. The database is checked at midnight everyday and if more than one film is added then it will tell you about all of them.</p>
      	<p>Don't worry, I am working on the TV subscriptions as these are the most popular (more on this to come very shortly) but this is slightly more complicated and there is too much sunshine at the moment to spend it in front of my computer!</p>
      	<p>
      	</div>
      	<div class="col-md-12" id="monkey04">
      	<h3>MediaMonkey 0.4 has landed!<small> April 18, 2014 by Chris</small></h3>
<p>Well as you will be able to see, the changes in this version of MediaMonkey are pretty significant. Not only does MediaMonkey finally now have a logo (name suggestions please), but the whole look and feel of the website different. In addition, a lot of the back-end stuff has been changed to make the site run a lot better which I hope you will appreciate. Here are the major changes:</p>

<ul>
<li><b>Libraries</b> - They actually work! The Library options for TV and Movies will now be faster than browsing the folders unlike before.</li>
<li><b>Profiles</b> - As more functionality is added this is where you will go to opt-in to it (see below). In time to use some of the new stuff you will need to add personal information like an email address. At the moment you can send me feedback from this page.</li>
</ul>

<p>There are still some things that I am working on migrating over to the latest version (search, for example) but the core functionality is still there that most people are using. I am also working on an exciting new feature which I hope will make people's lives easier:</p>

<ul>
<li><b>Subscriptions</b> - I am really excited about this and have been wanting to do it for a while now. Soon you will be able to subscribe to TV Shows. Once you have subscribed to a show MediaMonkey will send you an email when a new episode of that show has been added to the library. You will also be able to subscribe to movies which will email you when a new film has been added.</li>
</ul>

<p>Finally, there is a new link www.cjblake.net/downloads. The old one will still work but, please update your bookmarks and use this one in the future. The old one will still work, but I will look to turn it off pretty soon.</p>

<p>I hope you like it. Please drop me an email if you have any questions or feedback. I'm always looking to make it better.</p>
<p></p>
<!-- <dl>
  <dt>Authentication</dt>
  <dd>...</dd>
  <dt>Media browsing</dt>
  <dd>...</dd>
</dl> -->
		</div>
      	<div class="row"><div class="col-md-12"></div></div>
      	<div class="row" id="monkey03"><div class="col-md-12"><h3>MediaMonkey 0.3 is done!<small> October 09, 2013 by Chris</small></h3>
<p>The changes in this version are all feature additons which I hope you will find useful.</p>
<dl>
  <dt>Updated homepage</dt>
  <dd>In addition to the MediaMonkey blog the latest 5 TV episodes and Films in library are now disaplyed on the home page. The stats from 0.2 showed that the majority of people were down loading latest episodes of things. As such, to speed up access to this content I thought it best to stick it on page one.</dd>
  <dt>film/tv Requests</dt>
  <dd>Another content update, you can now request TV Shows, individual TV episodes or Movies directly from within the app. When you request a show a link is provided so that you can track its status.</dd>
  <dt>bug/feature requests</dt>
  <dd>Similar to the above but this is for requesting more features for MediaMonkey as I am keen to get some ideas for additions. You can also use this feature to report stuff that doesn't work.</dd>
</dl>
</div>
<div class="col-md-3"></div>
</div>


      	<div class="row"><div class="col-md-12"></div></div>
      	<div class="row" id="monkey02"><div class="col-md-12"><h3>MediaMonkey 0.2 is here!<small> March 22, 2013 by Chris</small></h3>
<p>Version 0.2 of MediaMonkey is up. A raft of changes in this version that should make everything lovely but most of the changes are around performance and statistics collection in the back end which aren't, unless you are a geek, particularly interesting. However, there are a couple on the functionality front that I'll go over:</p>
<dl>
  <dt>look and feel</dt>
  <dd>The main change that you will notice is with the "tv","tv2" and "films" links. They were the only sections didn't have the same look and feel as the rest of the site. This has now been sorted so the site should look and feel consistent throughout.</dd>
  <dt>speedy gonzalez</dt>
  <dd>The other thing about the "tv","tv2" and "films" sections was that not only did they look rubbish but their performance was awful. This should now be significantly better than it was. It may still take up to 5/10 seconds if you are hitting the "tv2" or "films" links as the drive needs to spin up. I'm Green inside.</dd>
  <dt>the choice is yours</dt>
  <dd>The final change is that I have added (where the files are compatible) stream options to all TV shows and Films. If the file type is compatible for viewing straight in the browser then you will get two options:
  <ul>
  	<li>Inline Streaming - This opens up the video in the same window.</li>
  	<li>New Window Streaming - As it says on the tin, this opens the video in a new window.</li>
  </ul>
  </dd>
</dl>
</div>
</div>
      	<div class="row"><div class="col-md-12"></div><div class="col-md-3"></div></div>
      	<div class="row" id="monkey"><div class="col-md-12"><h3>MediaMonkey arrives!<small> February 5, 2013 by Chris</small></h3>
<p>Welcome to Media Monkey. I hope you find it an improvement on the previous interface to my movies and TV. At the moment only the Movies section is fully working with the new look and while there is a "library" view available for TV you can't download anything through it yet. Don't fear though, you can us the "tv" and "tv2" links as of old to get all available TV episodes.</p>
			
			<p>I don't know whether or not any of you do but for quite a few of the TV episodes and a few of the movies you can stream them straight from your browser (Chrome works the best). The files need to be MP4. If you want to do that with any of the films then you will need to use the "films" menu which will take you to the familiar boring site. The library mode will force you to download the file.</p>
			
			<p>Although I have tested downloading a few movies there is a chance that some stuff doesn't work. So, please let me know if anything is broken and I'll do my best to get it sorted for you ASAP.</p>
			<p> Ta, Chris.</p>
	</div></div>

    </div>
    
    <!-- End Body -->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/docs.min.js"></script>
  </body>
</html>

