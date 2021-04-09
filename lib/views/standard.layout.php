<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=1.0"><!-- shrink-to-fit=no-->
    <meta name="Description" content="EasyReeci">
    <!-- All CSS -->
    <link rel="stylesheet" href="/lib/views/css/bootstrap.css">
    <link rel="stylesheet" href="/lib/views/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/lib/views/css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title><?php echo $title ?></title>
  </head>
  <body>

    <?php
      require PARTIALS."/header.html.php";
    ?>
    
    <div class="bodycontent" style="background-color: #232d35; margin-top: -20px;">
      <div id='content'>
        <?php
          if(!empty($note)){
            echo "<p class='note'>{$note}</p>";
          }
          if(!empty($flash)){
            echo "<p class='flash'>{$flash}</p>";
          }
          if(!empty($error)){
            echo "<p class='flash'>{$error}</p>";	
          }
          require $content;
        ?>
      </div> <!-- end content -->
    </div> <!-- end main -->
    <?php
    require PARTIALS."/navscript.html.php";
    ?>
  </body>
</html>