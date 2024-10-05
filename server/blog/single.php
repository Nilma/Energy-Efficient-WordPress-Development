<?php get_header(); ?>

<div class="container single-post-container">
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="post-header">
                <h2><?php the_title(); ?></h2>
                <div class="post-meta">
                    <span>Published by <?php the_author(); ?></span>
                    <span>on <?php the_date(); ?></span>
                </div>
            </header>

            <?php 
            if ( has_post_thumbnail() ) { // if the post has a featured image
                the_post_thumbnail('large', ['class' => 'post-featured-image']);
            } 
            ?>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <footer class="post-footer">
    <p>Posted in: <?php the_category(', '); ?></p>
    
    <div class="post-navigation">
    <div class="nav-previous"><?php previous_post_link( '%link', 'Previous Post' ); ?></div>
    <div class="nav-next"><?php next_post_link( '%link', 'Next Post' ); ?></div>
</div>

</footer>


        </article>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
