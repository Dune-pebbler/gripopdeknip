<section class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                <div class="sidebar">
                    <?php if( $titels = get_titels_by_content() ): ?>
                    <div class="sidebar-item">
                        <h3>Ga naar</h3>
                        <ul>   
                            <?php foreach($titels as $titel): ?>
                                <li><?= $titel; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-7  offset-lg-1">
                <div class="readout">
                    <button class="btn">
                        Lees voor <i class="fas fa-play"></i>
                    </button>

                    <ul class='shortcut-buttons' >
                        <li><button data-action='pause'><i class="fas fa-pause"></i></button></li>
                        <li><button data-action='resume'><i class="fas fa-play"></i></button></li>
                        <li><button data-action='stop'><i class="fas fa-stop"></i></button></li>
                    </ul>
                </div>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</section>