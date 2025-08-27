<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="combo" data-navbar-horizontal-shape="default">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>ATLISWARE | 4.0</title>

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo getURLDir(); ?>images/favicon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo getURLDir(); ?>images/favicon.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo getURLDir(); ?>images/favicon.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo getURLDir(); ?>images/favicon.png">
  <link rel="manifest" href="<?php echo getURLDir(); ?>assets/img/favicons/manifest.json">
  <meta name="msapplication-TileImage" content="<?php echo getURLDir(); ?>assets/img/favicons/mstile-150x150.png">
  <meta name="theme-color" content="#ffffff">

  <script src="<?php echo getURLDir(); ?>vendors/popper/popper.min.js"></script>
  <script src="<?php echo getURLDir(); ?>vendors/bootstrap/bootstrap.min.js"></script>
  <script src="<?php echo getURLDir(); ?>vendors/fontawesome/all.min.js"></script>

  <!-- Vendor CSS (Phoenix, FontAwesome, etc) -->
  <link href="<?php echo getURLDir(); ?>vendors/glightbox/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo getURLDir(); ?>vendors/dropzone/dropzone.css" rel="stylesheet">
  <link href="<?php echo getURLDir(); ?>vendors/choices/choices.min.css" rel="stylesheet">
  <link href="<?php echo getURLDir(); ?>vendors/simplebar/simplebar.min.css" rel="stylesheet">
  <link href="<?php echo getURLDir(); ?>vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
  <link href="<?php echo getURLDir(); ?>vendors/prism/prism-okaidia.css" rel="stylesheet">
  <link href="<?php echo getURLDir(); ?>vendors/dhtmlx-gantt/dhtmlxgantt.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  <!-- Phoenix Theme CSS (core then user; user.css last for overrides) -->
  <link href="<?php echo getURLDir(); ?>assets/css/theme.css" rel="stylesheet" id="style-default">
  <link href="<?php echo getURLDir(); ?>assets/css/user.css" rel="stylesheet" id="user-style-default">
  <!-- RTL support: -->
  <link href="<?php echo getURLDir(); ?>assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
  <link href="<?php echo getURLDir(); ?>assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Iceberg&display=swap" rel="stylesheet">

  <meta name="msapplication-TileColor" content="#00948E" />

  <!-- RTL/Theme Switch Logic (Phoenix standard) -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (window.config && window.config.config && window.config.config.phoenixIsRTL) {
        document.getElementById('style-default').setAttribute('disabled', true);
        document.getElementById('user-style-default').setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        document.getElementById('style-rtl').setAttribute('disabled', true);
        document.getElementById('user-style-rtl').setAttribute('disabled', true);
      }
    });
  </script>
</head>
<body>
