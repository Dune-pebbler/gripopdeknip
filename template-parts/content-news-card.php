<div class="news-card">
    <a class="news-card__link" href="<?= get_permalink(); ?>">
        <?php if (has_post_thumbnail()) { ?>
        <div class="news-card__image">
            <?php the_post_thumbnail('full'); ?>
        </div>
        <?php } ?>
        <div class="news-card__content">
            <h3 class="news-card__content__title">
                <?= get_the_title(); ?>
            </h3>

            <!-- Add the date and time here -->
            <p class="news-card__content__date">
                <?php echo get_the_date('d-m-y'); ?>
                <!-- Shows the date -->
            </p>

            <p class="news-card__content__excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
            </p>
        </div>
    </a>
</div>