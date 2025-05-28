<?php
$partner_query = new WP_Query(['post_type' => 'partners', 'posts_per_page' => -1]);
?>
</main>
<footer>

  <div class="shortcut-buttons">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
          <h2>Onze begeleiding is kosteloos</h2>

          <div class="buttons">
            <a href="tel: +31622062590" class="btn alternative">(06) 22 06 25 90</a>
            <a href="https://wa.me/+31622062590" class="btn alternative whatsapp">WhatsApp hulplijn <i
                class="fab fa-whatsapp"></i></a>
            <a href="<?= site_url('contact'); ?>" class="btn">Begeleiding aanvragen</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="shortcut-buttons reverse">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
          <h2>Samenwerkingspartners</h2>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row"> </div>
      <div class="col-12 thicc">
        <?php if ($partner_query->have_posts()): ?>
          <div class="logo-slider owl-theme owl-carousel">
            <?php while ($partner_query->have_posts()):
              $partner_query->the_post(); ?>
              <div class="slide">
                <?php if ($image = get_the_post_thumbnail_url(get_the_ID(), 'full')): ?>
                  <?php if (is_svg($image)): ?>
                    <?= get_svg($image); ?>
                  <?php else: ?>
                    <img src="<?= get_webp($image); ?>" alt="<?php the_title(); ?>" loading="lazy">
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>


  </div>
  </div>
  </div>


  <!-- old "textbackdrop" -->
  <?php /* if ($partner_query->have_posts()): ?>
<div class="logos">
   <h2 class="text-backdrop">
       SAMENWERKINGS <br />
       PARTNERS
   </h2>
   <div class="container">
       <div class="logo-slider owl-theme owl-carousel">
           <?php while ($partner_query->have_posts()):
$partner_query->the_post(); ?>
           <div class="slide">
               <?php if ($image = get_the_post_thumbnail_url(get_the_ID(), 'full')): ?>
               <?php if (is_svg($image)): ?>
               <?= get_svg($image); ?>
               <?php else: ?>
               <img src="<?= get_webp($image); ?>" alt="<?php the_title(); ?>" loading="lazy">
               <?php endif; ?>
               <?php endif; ?>
           </div>
           <?php endwhile; ?>
       </div>
   </div>
</div>
<?php endif; */ ?>

  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-2 offset-lg-1">
          <h3></h3>
          <?php wp_nav_menu(['theme_location' => 'footer-1']); ?>
        </div>
        <div class="col-12 col-lg-2">
          <h3></h3>
          <?php wp_nav_menu(['theme_location' => 'footer-2']); ?>
        </div>
        <div class="col-12 col-lg-2">
          <h3></h3>
          <?php wp_nav_menu(['theme_location' => 'footer-3']); ?>
        </div>
        <div class="col-12 col-lg-4">
          <h3></h3>
          <p>
            Conradstraat 8 <br />
            2221 SH Katwijk
          </p>
          <p>
            Email: <a href="mailto:info@gripopdeknipkatwijk.nl">info@gripopdeknipkatwijk.nl</a> <br />
            telefoonnummer: <a href="tel: +31622062590">06 22 06 25 90</a>
          </p>
          <div class="social-container">
            <span>Blijf op de hoogte:</span>
            <a href="https://www.facebook.com/people/Grip-op-de-Knip-Katwijk/61573836698906/" target="_blank"><i
                class="fab fa-facebook"></i></a>
          </div>
        </div>

      </div>
    </div>
  </div>


  <div class="bottom-footer">
    <div class="container">
      <div class="row">
        <!-- <div class="col-12 col-lg-4">
              <p class='start-footer-line'>Heeft u een compliment, klacht of suggestie?</p>
            </div> -->
        <div class="col-12 col-lg-6">
          <p class='center-footer-line'>Grip op de knip Katwijk |
            <?= date('Y'); ?>
          </p>
        </div>
        <div class="col-12 col-lg-6">
          <p class='end-footer-line'><span>Website door</span> <a href="https://dunepebbler.nl/" target="_blank">
              <?= get_svg('images/dp.svg'); ?>
            </a></p>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="<?= get_stylesheet_directory_uri(); ?>/assets/owlcarousel/owl.carousel.min.js" type="text/javascript">
</script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/in-view.js" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/masonry.js" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/numeral.js" type="text/javascript"></script>
<script
  src="<?= get_stylesheet_directory_uri(); ?>/js/main.js?v=<?= filemtime(get_template_directory() . "/js/main.js"); ?>"
  type="module"></script>
<?php wp_footer(); ?>
</body>

</html>