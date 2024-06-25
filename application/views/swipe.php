<!DOCTYPE html>
<html>
<head>
 <title>jQuery Mobile</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
 <script>
 $(document).ready(function () {
 $("p").on("tap", function () {
 alert("Tap event detected!");
 });

 $("p").on("taphold", function () {
 alert("Tap hold event detected!");
 });

 $("p").on("swipe", function () {
 alert("Swipe event detected!");
 });

 $("p").on("swipeleft", function () {
 alert("Swipe left event detected!");
 });

 $("p").on("swiperight", function () {
 alert("Swipe right event detected!");
 });
 });
 </script>
</head>
<body>
 <div data-role="page">
 <div data-role="header">
 <div align="center">jQuery Mobile Events</div>
 </div>
 <div data-role="content">
 <div class="gallery">
	<?php foreach ($gallery_photos as $ctr1 => $g) { ?>
	<img class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" src="<?php echo share_folder_path().$g['photo_url'];?>" >
	<?php } ?>
 </div>
 </div>
 </div>
</body>
</html>