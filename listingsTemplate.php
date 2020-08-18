<?php
/* Template Name: ListingsTemplate */

wp_enqueue_style('listings', get_stylesheet_directory_uri() . '/calsdtemplates/css/listings.css');

get_header();

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<form class="searchcontainer" action="" method="get">
				<!-- Search Keywords:
				<input class="input-field searchbox" type="text" name="search">

				Location:
				<input id="locationbox" class="input-field" type="text" name="location">

				<input id="submit" name="submit" type="submit" value="Search"> -->

				<div id="keywordcontainer">
					<div>Search Keywords:</div>
					<input class="input-field searchbox" type="text" name="search">
				</div>

				<div id="locationcontainer">
					<div>Location:</div>
					<input id="locationbox" class="input-field" type="text" name="location">
				</div>

				<div id="categorycontainer">
					<div>Category:</div>
					<div id="categorysubcontainer">
						<input type="checkbox" name="category[]" value="fruits">
						<label for="fruit">Fruits</label>

						<input type="checkbox" name="category[]" value="vegetables">
						<label for="vegetable">Vegetables</label>

						<input type="checkbox" name="category[]" value="meats">
						<label for="meat">Meats</label>

						<input type="checkbox" name="category[]" value="dairy">
						<label for="dairy">Dairy</label>

						<input type="checkbox" name="category[]" value="grains-beans-nuts">
						<label for="nuts">Nuts, Beans, Grains</label>
					</div>
				</div>

				<input id="submit" name="submit" type="submit" value="Search">
			</form>

			<?php

			if (isset($_GET['submit'])) :

				$args = array(
					'posts_per_page' => 100,
					'post_type' => 'listing',
					'post_status' => 'publish',
					's' => $_GET['search']
				);

				if(isset($_GET['category'])) :
					$categories = "";
					$catArray = $_GET['category'];
					foreach ($catArray as $catItem){ 
						$categories = $categories . $catItem . ",";
					}
					$args['category_name'] = $categories;
					// $args['category_name'] = $_GET['category'];
				endif;

				// $categories = "";
				// if($_GET['fruit']) :
				// 	$categories = $categories . "fruits,";
				// endif;
				// if($_GET['veg']) :
				// 	$categories = $categories . "vegetables,";
				// endif;
				// if($_GET['meat']) :
				// 	$categories = $categories . "meats,";
				// endif;
				// if($_GET['dairy']) :
				// 	$categories = $categories . "dairy,";
				// endif;
				// if($_GET['nuts']) :
				// 	$categories = $categories . "grains-beans-nuts";
				// endif;
			else :
				$args = array(
					'posts_per_page' => 100,
					'post_type' => 'listing',
					'post_status' => 'publish'
				);
			endif;

			$count = 1;
			$loop = new WP_Query($args);

			if (!($loop->have_posts())) :
				echo "<h2>No results, displaying all listings</h2>";

				$args = array(
					'posts_per_page' => 100,
					'post_type' => 'listing',
					'post_status' => 'publish'
				);
				$loop = new WP_Query($args);
			endif;

			while ($loop->have_posts()) :

				$loop->the_post();

				$address = get_post_meta(get_the_ID(), 'address', true);
				$price = get_post_meta(get_the_ID(), 'price', true);
				$quantity = get_post_meta(get_the_ID(), 'quantity', true);
				$description = get_post_meta(get_the_ID(), 'description', true);

				$modulus = $count % 3;
				if ($modulus == 1) {
					$class = 'first';
				} elseif ($modulus == 0) {
					$class = 'last';
				} else {
					$class = '';
				}
				$count = $count + 1;
			?>

				<div class="listing <?php echo $class; ?>">
					<?php if (has_post_thumbnail()) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
					<?php endif; ?>
					<h4 class="listing-title">
						<a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 6); ?></a>
					</h4>
					<div class="listing-meta">Address: <?php echo $address ?></div>
					<div class="listing-meta">Price Per Unit: <?php echo $price ?></div>
					<div class="listing-meta">Quantity: <?php echo $quantity ?></div>
					<p class="listing-description"> <?php echo $description ?></p>
				</div>


			<?php endwhile; // End of the loop.
			?>



		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
<!-- </div> -->
<?php
get_footer();
