<?php get_header(); ?>

<h1 class="all-blogs">All Blogs</h1>
<div id="main-content" class="posts-grid">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('grid-item'); ?>>
            <?php if(has_post_thumbnail()): ?>
                <div class="post-image">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                </div>
            <?php endif; ?>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div>
        </article>
    <?php endwhile; else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.', 'textdomain' ); ?></p>
    <?php endif; ?>
</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
