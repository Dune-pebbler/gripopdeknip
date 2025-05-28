<?php
$page_titles = get_titels_by_content();
$has_sidebar = count($page_titles) > 1;
get_header('header-1'); ?>

<section class="banner">
    <div class="background-image">
        <?php if ($url = get_the_post_thumbnail_url(get_the_ID(), 'full')): ?>
            <img src="<?= get_webp($url); ?>" alt="<?php the_title(); ?>">
        <?php else: ?>
            <div class="placeholder"></div>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="row">
            <?php if ($has_sidebar): ?>
                <div class="col-12 col-lg-8 offset-lg-4">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                </div>
            <?php else: ?>
                <div class="col-12 col-lg-8 offset-lg-2">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (function_exists('yoast_breadcrumb')): ?>
    <section class="breadcrumbs">
        <div class="container">
            <div class="row">
                <?php if ($has_sidebar): ?>
                    <div class="col-12 col-lg-8 offset-lg-4">
                        <?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
                    </div>
                <?php else: ?>
                    <div class="col-12 col-lg-8 offset-lg-2">
                        <?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ($has_sidebar): ?>
    <?php get_template_part('part', 'with-sidebar'); ?>
<?php else: ?>
    <?php get_template_part('part', 'without-sidebar'); ?>
<?php endif; ?>

<?php global $post; ?>
<?php if ($post->post_name === 'veelgestelde-vragen'):
    $faq_query = get_faq_query(); ?>
    <section class="faq">
        <div class="container">
            <div class="row">
                <?php while ($faq_query->have_posts()): ?>
                    <?php $faq_query->the_post(); ?>
                    <div class="col-12 col-lg-8 offset-lg-2">
                        <div class="faq-category-item">
                            <h3>
                                <?php the_title(); ?>
                            </h3>
                            <?php while (have_rows('vraag_antwoord')):
                                the_row(); ?>
                                <div class="faq-item">
                                    <div class="faq-header">
                                        <h3>
                                            <?php the_sub_field('vraag'); ?> <i class="fas fa-arrow-down"></i>
                                        </h3>
                                    </div>

                                    <div class="faq-content">
                                        <?php the_sub_field('antwoord'); ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (have_rows('tabs')): ?>
    <section class="tabs-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">
                    <div class="tabs">
                        <?php while (have_rows('tabs')):
                            the_row(); ?>
                            <button class='<?= get_row_index() == 1 ? 'is-active' : ''; ?>'><?php the_sub_field('titel'); ?></button>
                        <?php endwhile; ?>
                    </div>

                    <div class="tabs-content">
                        <?php while (have_rows('tabs')):
                            the_row(); ?>
                            <div class="tab-content <?= get_row_index() == 1 ? 'is-active' : ''; ?>"
                                data-tab="<?= get_row_index(); ?>">
                                <?= do_shortcode('[gravityform id="1" title="true" description="false" ajax="false"]'); ?>

                                <!-- do_shortcode('[contact-form-7 id="33" title="Contactformulier 1"]');  -->
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (is_page(47)): ?>
    <section class="tabs-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">
                    <div class="tabs-content">
                        <div class="tab-content is-active" style="margin-top: -80px;">
                            <?= do_shortcode('[gravityform id="1" title="true" description="false" ajax="false"]'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (have_rows('tips')): ?>
    <section class="masonry-items">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-4">
                    <div class="items">
                        <?php while (have_rows('tips')):
                            the_row();
                            $button = get_sub_field('button'); ?>
                            <a href="<?= $button['url']; ?>" target="<?= $button['target']; ?>" class="item"
                                title="<?= $button['title']; ?> bezoeken">
                                <?php if ($image = get_sub_field('afbeelding')): ?>
                                    <div class="image">
                                        <img src="<?= $image['url']; ?>" alt="<?= $button['title']; ?>" loading="lazy">
                                    </div>
                                <?php endif; ?>

                                <div class="content">
                                    <?php the_sub_field('content'); ?>
                                </div>

                                <div class="buttons">
                                    <button class="btn" title="<?= $button['title']; ?> bezoeken"><?= $button['title']; ?></button>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<style>
    .page-content .content img{
        padding-left: 20px;
    }
    @media (max-width: 768px) {
        .page-content .content img {
            display: none;
        }
    }
}
</style>
<?php get_footer(); ?>