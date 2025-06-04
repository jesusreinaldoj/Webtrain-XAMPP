<!DOCTYPE html>

<head>

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?> </title>
<?php wp_head();?>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
</head>
<body <?php body_class(); ?>>
    <header class="container header">
        <div class="row">
            <div class="col-sm-7">
                <h1>
                    <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
            </div>
            <div class="col-sm-4 col-sm-offset-1">
                <span>Por:Jesus Reinaldo y Alvaro Fernandez</span>

            </div>
        </div>
    </header>
    <div class="container-fluid content-wrapper">
        <div class="container">
            
       