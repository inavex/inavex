<?php get_header(); ?>
 <div class="contentLayout">
   <div class="content">
     <?php if (have_posts()) : ?>
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
              <div class="PostContent">
                <h2><?php _e('Search Results', 'kubrick'); ?></h2>
                    <?php
            		$prev_link = get_previous_posts_link(__('Newer Entries &raquo;', 'kubrick'));
	        	$next_link = get_next_posts_link(__('&laquo; Older Entries', 'kubrick'));
		    ?>

		    <?php if ($prev_link || $next_link): ?>
		      <div class="navigation">
		        <div class="alignleft"><?php echo $next_link; ?></div>
		        <div class="alignright"><?php echo $prev_link; ?></div>
		      </div>
		    <?php endif; ?>
              </div>
	      <div class="cleared"></div>
	   </div>
	 </div>
       </div>
       <?php while (have_posts()) : the_post(); ?>
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
                   <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'kubrick'), the_title_attribute('echo=0')); ?>">
         	    <?php the_title(); ?>
		   </a>
                 </span>
	      </h2>

	      <div class="PostContent">
	        <?php if (is_search()) the_excerpt(); else the_content(__('Read the rest of this entry &raquo;', 'kubrick')); ?>
	      </div>
	      <div class="cleared"></div>
	    </div>
	  </div>
	 </div>
			
       <?php endwhile; ?>
       <?php if ($prev_link || $next_link): ?>
		
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
	       <div class="PostContent">
                  <div class="navigation">
		     <div class="alignleft"><?php echo $next_link; ?></div>
		     <div class="alignright"><?php echo $prev_link; ?></div>
		  </div>
	       </div>
	       <div class="cleared"></div>
	   </div>
	 </div>
       </div>
       <?php endif; ?>
       <?php else : ?>
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
	 <div class="PostContent">
            <h2><?php _e('Search Results', 'kubrick'); ?></h2>
	    <h2 class="center"><?php _e('No posts found. Try a different search?', 'kubrick'); ?></h2>
		
	 </div>
	 <div class="cleared"></div>
       </div>
   </div>
  </div>
  <?php endif; ?>
</div>
<div class="sidebar1">
  <?php include (TEMPLATEPATH . '/sidebar1.php'); ?>
</div>
</div>
<div class="cleared"></div>
<?php get_footer(); ?>
