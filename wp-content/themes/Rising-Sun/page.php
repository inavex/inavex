<?php get_header(); ?>
<div class="contentLayout">
  <div class="content">
   <?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
     <div class="Post">
       <div class="Post-tl"></div>
        <div class="Post-tr"><div></div></div>
        <div class="Post-bl"><div></div></div>
        <div class="Post-br"><div></div></div>
        <div class="Post-tc"><div></div></div>
        <div class="Post-bc"><div></div></div>
        <div class="Post-cl"><div></div></div>
        <div class="Post-cr"><div></div></div>
        <div class="Post-cc"></div>
        <div class="Post-body">
          <div class="Post-inner article">
            <h2 class="PostHeaderIcon-wrapper">
              <img src="<?php bloginfo('template_url'); ?>/images/PostHeaderIcon.png" width="26" height="28" alt="PostHeaderIcon" />
              <span class="PostHeader">
                 <?php the_title(); ?>
              </span>
            </h2>
            <div class="PostContent">
              <?php the_content();?>
             
            </div>
          </div>
        </div>
     </div>
   <?php endwhile; endif; ?>
  </div>
  <div class="sidebar1">
    <?php include (TEMPLATEPATH . '/sidebar1.php'); ?>
  </div>
</div>
<div class="cleared"></div>
<?php get_footer(); ?>
