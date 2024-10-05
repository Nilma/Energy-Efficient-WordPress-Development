<?php
/* Template Name: About Page */

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
?>

<div class="about-page-wrapper">
    <h1><?php the_title(); ?></h1>

    <?php
    $content = get_the_content();
    $paragraphs = explode("\n", $content);

    foreach ($paragraphs as $paragraph) {
        if (trim($paragraph)) {
            echo '<div class="about-section">' . $paragraph . '</div>';
        }
    }
    ?>

</div>

<?php
endwhile; endif;

get_footer();
?>
