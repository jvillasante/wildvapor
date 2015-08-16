<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>
  <?php
    $_title = $this->tr('title');
    if (isset($page_title)) { $_title .= ' - ' . $page_title; }
    echo $_title;
  ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="<?php echo $this->path('css/tipsy.css'); ?>" type="text/css" rel="stylesheet" media="screen"><!--tooltip-->
  <link href="<?php echo $this->path('css/jcarousel.css'); ?>" type="text/css" rel="stylesheet" media="screen" /> <!-- list_work -->
  <link href="<?php echo $this->path('css/zebra_pagination.css'); ?>" type="text/css" rel="stylesheet" media="screen" /> <!-- General style -->
  <link href="<?php echo $this->path('css/style.css'); ?>" type="text/css" rel="stylesheet" media="screen" /> <!-- General style -->
  <link href="<?php echo $this->path('css/mystyles.css'); ?>" type="text/css" rel="stylesheet" media="screen" /> <!-- General style -->
</head>
<body>
  <div id="page_wrap">
    <?php include BASE_URI . DS . 'views' . DS . 'includes' . DS . 'header.php'; ?>
    <div id="container">
      <?php include BASE_URI . DS . 'views' . DS . 'includes' . DS . 'nav.php'; ?>
      <div class="content-wrap">
        <?php include BASE_URI . DS . 'views' . DS . 'includes' . DS . 'intro.php'; ?>
        <div class="container-2">
          <?php require $this->getTemplatesDirectory() . '/' . $childView; ?>
        </div><!--end:container-2-->
      </div><!--end:content-wrap-->
      <?php include BASE_URI . DS . 'views' . DS . 'includes' . DS . 'footer.php'; ?>
    </div><!--end:container-->
  </div><!--end:page_wrap-->

<script type="text/javascript" src="<?php echo $this->path('js/jquery-1.8.2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo $this->path('js/css3-mediaqueries.js'); ?>"></script><!--mediaqueries-->
<script type="text/javascript" src="<?php echo $this->path('js/modernizr-1.7.min.js'); ?>"></script><!--modernizr-->
<script type="text/javascript" src="<?php echo $this->path('js/jquery.tipsy.js'); ?>"></script><!--tooltip-->
<script type="text/javascript" src="<?php echo $this->path('js/jquery.easing.1.3.js'); ?>"></script> <!--camera slider-->
<script type="text/javascript" src="<?php echo $this->path('js/jquery-hover-effect.js'); ?>"></script><!--Image Hover Effect-->
<script type="text/javascript" src="<?php echo $this->path('js/jquery.hoverIntent.minified.js'); ?>"></script><!--menu-->
<script type="text/javascript" src="<?php echo $this->path('js/jquery.dcmegamenu.1.3.3.js'); ?>"></script><!--menu-->
<script type="text/javascript" src="<?php echo $this->path('js/jquery.quovolver.js'); ?>"></script><!--blockquote-->
<script type="text/javascript" src="<?php echo $this->path('js/custom.js'); ?>"></script><!--custom-->

<?php if (isset($js)) { echo $js; } ?>
</body>
</html>

