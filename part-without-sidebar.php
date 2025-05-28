<section class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="readout">
                    <button class="btn">
                        Lees voor <i class="fas fa-play"></i>
                    </button>

                    <ul class='shortcut-buttons' >
                        <li><button data-action='pause'><i class="fas fa-pause"></i></button></li>
                        <li><button data-action='stop'><i class="fas fa-stop"></i></button></li>
                        <li><button data-action='resume'><i class="fas fa-play"></i></button></li>
                    </ul>
                </div>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</section>