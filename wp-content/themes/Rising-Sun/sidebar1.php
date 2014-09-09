<div class="sidebar1">      
  <?php if (!art_sidebar(1)): ?>

        <div class="Block">
            <div class="Block-tl"></div>
            <div class="Block-tr">
                <div></div>
            </div>
            <div class="Block-bl">
                <div></div>
            </div>
            <div class="Block-br">
                <div></div>
            </div>
            <div class="Block-tc">
                <div></div>
            </div>
            <div class="Block-bc">
                <div></div>
            </div>
            <div class="Block-cl">
                <div></div>
            </div>
            <div class="Block-cr">
                <div></div>
            </div>
            <div class="Block-cc"></div>
            <div class="Block-body">
                <div class="BlockContent">
                    <a href="<?php /*bloginfo('url'); */?>/online-order/" class="order-send">On-line заявка</a>
                </div>
            </div>
        </div>

   <div class="Block">
    <div class="Block-tl"></div>
    <div class="Block-tr"><div></div></div>
    <div class="Block-bl"><div></div></div>
    <div class="Block-br"><div></div></div>
    <div class="Block-tc"><div></div></div>
    <div class="Block-bc"><div></div></div>
    <div class="Block-cl"><div></div></div>
    <div class="Block-cr"><div></div></div>
    <div class="Block-cc"></div>
    <div class="Block-body">
      <div class="BlockHeader">
        <div class="header-tag-icon">
          <div class="BlockHeader-text">
            <?php _e('Ссылки:', 'kubrick'); ?>
          </div>
        </div>
        <div class="l"></div>
        <div class="r"><div></div></div>
      </div>
      <div class="BlockContent">
        <div class="BlockContent-body">
            <?php wp_nav_menu( array( 'theme_location' => 'sidebar','link_before'  => '<span><span>', 'link_after'  => '</span></span>', 'menu_class' => 'links'  ) ); ?>
        </div>
      </div>
    </div>
   </div>

   <div class="Block">
    <div class="Block-tl"></div>
    <div class="Block-tr"><div></div></div>
    <div class="Block-bl"><div></div></div>
    <div class="Block-br"><div></div></div>
    <div class="Block-tc"><div></div></div>
    <div class="Block-bc"><div></div></div>
    <div class="Block-cl"><div></div></div>
    <div class="Block-cr"><div></div></div>
    <div class="Block-cc"></div>
    <div class="Block-body">
      <div class="BlockHeader">
        <div class="header-tag-icon">
          <div class="BlockHeader-text">
            <?php _e('Мета:', 'kubrick'); ?>
          </div>
        </div>
        <div class="l"></div>
        <div class="r"><div></div></div>
      </div>
      <div class="BlockContent">
        <div class="BlockContent-body">
          <ul>
	    <?php wp_register(); ?>
	    <li><?php wp_loginout(); ?></li>

            <?php wp_meta(); ?>
	  </ul>
        </div>
      </div>
    </div>
   </div>
  <?php endif ?>
</div>
