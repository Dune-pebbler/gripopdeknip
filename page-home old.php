<?php
/*
 * Template name: Page home
 */
get_header();
?>
<?php if (have_rows('slides')): ?>
  <section class="slider owl-theme owl-carousel">
    <?php while (have_rows('slides')):
      the_row();
      $image = get_sub_field('afbeelding'); ?>
      <div class="slide">
        <?php if ($image): ?>
          <img src="<?= get_webp($image['url']); ?>" alt="<?php the_title(); ?>" <?= get_row_index() > 1 ? 'loading="lazy"' : ''; ?>>
        <?php endif; ?>

        <?php if ($caption = get_sub_field('tekst')): ?>
          <div class="caption">
            <div class="container">
              <div class="row">
                <div class="col-12 col-lg-6 col-xl-3">
                  <?= $caption; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <!-- 570x338 -->
        <?php if ($ondertekst = get_sub_field("ondertekst")): ?>
          <div class="sticky-bottom-caption-container">
            <div class="container">
              <div class="sticky-bottom-caption">
                <?= $ondertekst; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>


        <div class="overlay-5">
          <?= get_svg('images/slider-overlay.svg'); ?>

        </div>
      </div>
    <?php endwhile; ?>
  </section>
<?php endif; ?>

<section class="introduction">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-6">
        <div class="text-container">
          <?php if ($pretitel = get_field("pre-titel")): ?>
            <div class='small-text'>
              <?= wpautop($pretitel); ?>
            </div>
          <?php endif; ?>
          <h2>
            <?php the_title(); ?>
          </h2>

          <div class="description">
            <?php the_content(); ?>
          </div>

          <!-- 
                      

                    <p class="context">Wij zijn op werkdagen bereikbaar van 8:30 – 17:00 uur.</p>

                    <div class="buttons">
                      <a href="#!" class="btn">Begeleiding aanvragen</a>
                      <span>Aanmelden is kostenloos</span>
                    </div> -->
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="image">
          <?php if ($image = get_field('introductie_afbeelding')): ?>
            <img src="<?= get_webp($image['url']); ?>" alt="" loading="lazy" />
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="recent-news">
  <div class="container">
    <div class="row news_row" style="margin-top: 0px;">
      <?php
      $news_posts = new WP_Query(
        array(
          'post_type' => 'post',
          'posts_per_page' => 2,
        )
      );
      if ($news_posts->have_posts()):
        while ($news_posts->have_posts()):
          $news_posts->the_post(); ?>
          <div class="col-md-6 mb-4 col-sm-12">
            <?php get_template_part('template-parts/content-news-card'); ?>
          </div>
        <?php endwhile;
        wp_reset_postdata();
      else: ?>
        <p>
          <?php _e('No news posts found'); ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php if (have_rows('keuze_blokken')): ?>
  <section class="choice-block">
    <div class="container">
      <div class="grouped">
        <?php while (have_rows('keuze_blokken')):
          the_row(); ?>
          <div class="item <?= get_row_index() === 1 ? 'red' : ''; ?>">
            <?php the_sub_field('keuze_blok'); ?>

            <?php if ($button = get_sub_field('button')): ?>
              <a href="<?= $button['url']; ?>" class='btn' target='<?= $button['target']; ?>'><?= $button['title']; ?></a>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if (have_rows('tellers')): ?>
  <section class="counters">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
          <div class="row">

            <?php while (have_rows('tellers')):
              the_row(); ?>
              <div class="col-12 col-sm-6 col-lg-6">
                <div class="puzzle-piece">
                  <?= get_svg('images/puzzle-piece.svg'); ?>
                </div>

                <div class="text-block">
                  <?php if ($image = get_sub_field('afbeelding')): ?>
                    <div class="image">
                      <?php if (is_svg($image['url'])): ?>
                        <?= get_svg('images/person-1.svg'); ?>
                      <?php else: ?>
                        <img src="<?= get_webp($image['url']); ?>" alt="" loading="lazy" />
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>

                  <div class="text-container">
                    <h3><span class='count'>
                        <?php the_sub_field('teller'); ?>
                      </span>+</h3>
                    <p>
                      <?php the_sub_field('titel'); ?>
                    </p>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
<?php get_footer(); ?>