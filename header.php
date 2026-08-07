<?php   ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php
    require_once 'inc/config/db.php';
    redirect();?>
    <title><?php  echo  $titlepage; ?> | نرم افزار بهمن</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo BASE_URL; ?>/inc/assets/images/favicon.ico" type="image/x-icon">
    <?php
    $vam = VAM;
    ?>
    <script type="text/javascript">
        var vam = "<?php echo $vam ?>";
        var home_url = "<?php echo BASE_URL; ?>";
    </script>
    <!-- Bootstrap Core Css -->
    <link href="<?php echo BASE_URL; ?>/inc/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/inc/plugins/bootstrap/fonts/material-icons.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/inc/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

    <!-- Bootstrap RTL Css -->
    <link href="<?php echo BASE_URL; ?>/inc/plugins/bootstrap-rtl/css/bootstrap-rtl.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/inc/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <!-- Waves Effect Css -->
    <link href="<?php echo BASE_URL; ?>/inc/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo BASE_URL; ?>/inc/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="<?php echo BASE_URL; ?>/inc/assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="<?php echo BASE_URL; ?>/inc/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/inc/assets/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/inc/assets/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- Dropzone Css -->
    <link href="<?php echo BASE_URL; ?>/inc/plugins/dropzone/dropzone.css" rel="stylesheet">
    <!-- Custorm RTL Css -->
    <link href="<?php echo BASE_URL; ?>/inc/assets/css/style-rtl.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/inc/assets/css/style-ios.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo BASE_URL; ?>/inc/assets/css/themes/all-themes.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/inc/custom.css" rel="stylesheet">
</head>

<body class="theme-<?php echo COLOR; ?>">
<?php include('sidebar.php'); ?>