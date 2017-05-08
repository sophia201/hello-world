<?php 
	get_header();
?>
<?php if(has_post_thumbnail()): $div_class="img-div"; else:  $div_class="content-div"; endif;?>
 <div class="container inner-content">
 	<div class="post-detail-page">    
 		<div class="row">
              
                <div class="col-md-12 col-sm-12 content-div">
                	 <?php
					while (have_posts()):
   					 the_post();
				?>
		             
                    <div class="single-content">  <?php  the_content(); ?>  </div>
                    <div class="single-news-extra">
                    <div class="date"><b><?php _e('Posted on: ');?></b><?php the_date('F d Y'); ?> </div>  
					<div class="exta-link">
						<?php 
						$postcats = get_the_terms( get_the_ID(), 'news_category'); 
						$posttags = get_the_terms( get_the_ID(), 'news_tag'); ?>
						<?php if(!empty($posttags)){ _e('<b>Tags: </b>'); foreach($posttags as $tags){
							?><a href="<?php echo get_term_link( $tags )?>"><?php echo $tags->name?></a>  <?php
						} } ?>
							
						</div>                      
                    </div> 
                    <div class="single-pager">
                        <ul class="pager">  
                            <li class="previous"> <?php  previous_post_link('%link', 'Previous'); ?> </li>
                            <li class="next"> <?php  next_post_link('%link', 'Next'); ?>  </li>
                        </ul>
                    </div>
				
                    <?php
					endwhile;
				?>
			</div><!--end col-md-7 col-sm-7 -->
	  	</div> <!--end row -->

	<div class="row"> 
		<div class="col-md-12 col-sm-12"> 
			<div class="action-buttons global-btn">
				<a class="go-back" href="<?php echo esc_url( get_permalink(get_field('news_page','option')) );?>"><?php _e("Back to News and Blogs");?></a>
				<div class="clearfix"></div>
				<a class="homepage-back" href="<?php echo esc_url( home_url() );?>"><i class="fa fa-home"></i><?php _e("Homepage");?></a>
			</div>
		</div>
	</div>
   
  
   
    </div>

</div><!-- #container -->
<?php 	$terms = get_the_terms( get_the_ID(), 'news_tag' );
		if( $terms ){
		    foreach ($terms as $term) {
			   $slugs[] = $term->slug;
		    }
		}
						?>
					<?php 
								$related_args = array(
										  'post_type'      => array('news','product','post'),
										  'posts_per_page' => 6,
										  'post_status'    => 'publish',
										  'post__not_in'   => array( get_the_ID() ),										 											 'tax_query' => array(
											   'relation' =>'OR',
				                                      array(
				                                      'taxonomy' => 'news_tag',
				                                      'field' => 'slug',
				                                      'terms' => $slugs,
				                                      ),
											    array(
				                                      'taxonomy' => 'post_tag',
				                                      'field' => 'slug',
				                                      'terms' => $slugs,
				                                      ),
											    array(
				                                      'taxonomy' => 'product_tag',
				                                      'field' => 'slug',
				                                      'terms' => $slugs,
				                                      ),
				                                  ),
										);
						
							$loop	= new WP_Query($related_args); 
   
?>
<?php if($loop->have_posts()) {?>
	<!-- featured slider-->
<div class="news-article">
	<div class="container">
		<div class="title">
			<h2>
				IF YOU LIKED THIS ARTICLE you <br><abbr>ma</abbr>y be interested in these...
			</h2>
		</div>
	</div>

	<div class="owl-carousel owl-theme">
	   <?php    while($loop->have_posts()) : $loop->the_post();
				$post_type = get_post_type();
				$post_format = get_post_format();
			if($post_type == 'product'){		
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
			?>
			<div class="item" style="width:300px">
				<div class="article-box">
					<div class="img">
						<img src="<?php  echo $image[0]; ?>" alt="">
					</div>
					<div class="article-title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></div>					
					<div class="article-btn">
						<a href="<?php echo get_permalink();?>"><?php _e('View product');?></a>
						
						<a href="#" class="pull-right short-icon"><i class="fa fa-download"></i></a>
						<a href="#" class="pull-right short-icon"><i class="fa fa-plus-circle"></i></a>
					</div>
				</div>
			</div>

			<?php

			}elseif($post_type == 'news')
			{
			?>
			 <div class="item" style="width:580px">
					<div class="article-box">
						<div class="img">
							<?php the_post_thumbnail('news-featured-new'); ?>
						</div>
						<div class="article-title"><?php echo get_the_title();?> </div>
						<div class="article-text"><?php echo substr(get_the_excerpt(),0,200);?> </div>
						<div class="article-btn">
							<a href="<?php echo get_permalink();?>"><?php _e('Read more');?></a>
						</div>
					</div>
			 </div>
			<?php

			}
			else{
				if($post_format == 'video'){
				 $youtube_id = get_the_content();
				?>
				  <div class="item" style="width:580px">
						<div class="article-box">
							<div class="img">
								<iframe src="<?php echo getVideoURLFromURL( $youtube_id);?>" allowfullscreen="" width="560" height="345" frameborder="0"></iframe>
							</div>
							<div class="article-title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></div>
							<div class="article-btn">
								<a href="<?php echo get_permalink();?>"><?php _e('Read more');?></a>
							</div>
						</div>
					</div>

				<?php
				}
				elseif($post_format == 'quote')
				{
					?>
					  <div class="item" style="width:300px">
							<div class="testimonial-box">
								<div class="quote-icon"><img src="<?php echo get_template_directory_uri();?>/assets/images/quote-1.png" alt=""></div>
								<div class="testimonial-text"><?php echo get_the_content();?> </div>
								<div class="quote-icon"><img src="<?php echo get_template_directory_uri();?>/assets/images/quote-2.png" alt=""></div>
							</div>
						</div>
					<?php
				}
				else
				{
					?>
				<div class="item" style="width:300px">
					<div class="article-box">
						<div class="img">
							<?php the_post_thumbnail('news-featured-new'); ?>
						</div>
						<div class="article-title"><a href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a></div>
						<div class="article-text"><?php echo get_the_excerpt();?></div>
						<div class="article-btn">
							<a href="<?php echo get_permalink();?>"><?php _e('View more posts');?></a>
						</div>
					</div>
				</div>
					<?php	
				}

			}

			endwhile;
	?>

	</div>	
	
</div>
<?php  }?>
      <!-- end: featured slider-->  

<div class="subscribe_box">
	<div class="container">		
	<?php echo do_shortcode('[bms_weekly_email block_title="Subscribe to our weekly email update" button_label="Subscribe"]');?>			
</div>
</div>

<script src="<?php echo get_template_directory_uri();?>/assets/js/owl.carousel.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/owl.carousel.css">

<script>
jQuery('.owl-carousel').owlCarousel({
	margin:20,
	loop:false,
	autoWidth:true,
	items:6,
	nav: true,
	pagination : false
})
</script>

<?php
get_footer();
?> 
