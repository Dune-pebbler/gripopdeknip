<?php
/* Template Name: News Page */
get_header();
?>

<div class="container">
    <div class="row news_row">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $news_posts = new WP_Query(
            array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'paged' => $paged,

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
        <div class="paginate_links">
            <?php echo paginate_links(
                array(
                    'total' => $news_posts->max_num_pages,
                    'current' => $paged,
                    'mid_size' => 2,
                    'prev_text' => __('« Previous', 'textdomain'),
                    'next_text' => __('Next »', 'textdomain'),
                )
            ); ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>