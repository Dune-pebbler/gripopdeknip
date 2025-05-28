<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= wp_title(); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= get_stylesheet_directory_uri(); ?>/stylesheets/bootstrap/bootstrap.css" rel="stylesheet"> 
    <!-- this will be manageable. -->
    <link href="<?= get_stylesheet_directory_uri(); ?>/assets/fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="<?= get_stylesheet_directory_uri(); ?>/assets/owlcarousel/owl.carousel.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?= get_stylesheet_directory_uri(); ?>/stylesheets/style.css?v=<?= filemtime(get_template_directory() . "/stylesheets/style.css"); ?>" rel="stylesheet">
    <link rel="preconnect" href="https://use.typekit.net">
    <link rel="stylesheet" href="https://use.typekit.net/dzp8ptr.css">


    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <header>
      <div class="top-header">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-9 offset-lg-3">
                <div class="top-header-content">
                  <div class="partner-logo">
                    <a href="https://schuldhulpmaatje.nl/" target="_blank">
                      <?= get_svg("images/schuldhulpmaatje-logo.svg"); ?>
                    </a>
                  </div>
                  <div class="buttons">
                    <?php wp_nav_menu([ 'theme_location' => 'top-header-1' ]); ?>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="header">
        <div class="container">
          <div class="row">
            <div class="col-5 col-md-4 col-lg-3">
              <a href="<?= site_url(); ?>" class="logo">
                <?= get_svg('images/logo.svg'); ?>
              </a>
            </div>

            <div class="col-7 offset-md-1 col-lg-7 offset-lg-0">
            <button class="hamburger hamburger--slider" type="button">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
            </button>
              <?= wp_nav_menu(['theme_location' => 'primary']); ?>
            </div>
          </div>
        </div>
      </div>  
    </header>
    <main>
    <div class="backdrop halfway">
      <?= get_svg('images/backdrop-5.svg'); ?>
    </div>
    <div class="backdrop endpage">
      <?= get_svg('images/backdrop-5-horizontal.svg'); ?>
    </div>