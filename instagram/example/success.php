<?php

/**
 * Instagram PHP API
 * 
 * @link https://github.com/cosenary/Instagram-PHP-API
 * @author Christian Metz
 * @since 01.10.2013
 */

require_once 'instagram.class.php';

// initialize class
$instagram = new Instagram(array(
  'apiKey'      => 'YOUR_APP_KEY',
  'apiSecret'   => 'YOUR_APP_SECRET',
  'apiCallback' => 'YOUR_APP_CALLBACK' // must point to success.php
));

// receive OAuth code parameter
$code = $_GET['code'];

// check whether the user has granted access
if (isset($code)) {

  // receive OAuth token object
  $data = $instagram->getOAuthToken($code);
  $username = $username = $data->user->username;
  
  // store user access token
  $instagram->setAccessToken($data);

  // now you have access to all authenticated user methods
  $media = $instagram->getUserMedia();

} else {

  // check whether an error occurred
  if (isset($_GET['error'])) {
    echo 'An error occurred: ' . $_GET['error_description'];
  }

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - photo stream</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
  </head>
  <body>
    <div class="container">
      <header class="clearfix">
        <img src="assets/instagram.png" alt="Instagram logo">
        <h1>Instagram photos <span>taken by <? echo $data->user->username ?></span></h1>
      </header>
      <div class="main">
        <ul class="grid">
        <?php
          // display all user likes
          foreach ($media->data as $pic) {
            echo "<li>
                    <img class=\"image\" src=\"{$pic->images->low_resolution->url}\"/>
                      <div class=\"content\">
                      <div class=\"avatar\" style=\"background-image: url({$pic->user->profile_picture})\"></div>
                      <p>{$pic->user->username}</p>
                      <div class=\"comment\">{$pic->caption->text}</div>
                    </div>
                  </li>";
          }
        ?>
        </ul>
        <!-- GitHub project -->
        <footer>
          <p>created by <a href="https://github.com/cosenary/Instagram-PHP-API">cosenary's Instagram class</a>, available on GitHub</p>
          <iframe width="85px" scrolling="0" height="20px" scrolling="0" frameborder="0" allowtransparency="true" src="http://ghbtns.com/github-btn.html?user=cosenary&repo=Instagram-PHP-API&type=star&count=true"></iframe>
          <iframe width="95px" scrolling="0" height="20px" frameborder="0" allowtransparency="true" src="http://ghbtns.com/github-btn.html?user=cosenary&repo=Instagram-PHP-API&type=fork&count=true"></iframe>
        </footer>
      </div>
    </div>
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $('li').hover(
          function() {
            var $image = $(this).find('.image');
            var height = $image.height();
            $image.stop().animate({ marginTop: -(height - 82) }, 1000);
          }, function() {
            var $image = $(this).find('.image');
            var height = $image.height();
            $image.stop().animate({ marginTop: '0px' }, 1000);
          }
        );
      });
    </script>
  </body>
</html>