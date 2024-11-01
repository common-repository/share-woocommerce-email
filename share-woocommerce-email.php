<?php

/**

 * Plugin Name: Share Woocommerce to Email

 * Plugin URI: https://troplr.com/

 * Description: Allow users to share/email woocommerce producrs via wp_mail. 

 * Version: 1.0.1

 * Author: Troplr

 * Author URI: https://troplr.com

 * Requires at least: 4.5

 * Tested up to: 4.7

 *

 * Text Domain: troplr

 *

 */



require_once('titan-framework/titan-framework-embedder.php');


/*function swe_resources() {
    wp_enqueue_style('bootstrap', plugin_dir_url( __FILE__ ) .'script/bootstrap.min.css');
    wp_enqueue_style('style');
    wp_enqueue_script( 'bootstrap-js', 'script/bootstrap.min.js', array('jquery'), '4.0.0', true );
}
add_action('wp_enqueue_scripts', 'swe_resources');*/




function swe_resources() {   
    wp_enqueue_script( 'swe-bootstrapjs', plugin_dir_url( __FILE__ ) . 'script/bootstrap.min.js',array('jquery'), '4.0.0', false );
    wp_register_style('swe-bootstrapcss', plugin_dir_url( __FILE__ ).'script/bootstrap.min.css');
	wp_enqueue_style('swe-bootstrapcss');
}

add_action('wp_enqueue_scripts', 'swe_resources');







add_action( 'tf_create_options', 'swe_ppstemail' );

function swe_ppstemail() {

// Initialize Titan & options here

 $titan = TitanFramework::getInstance( 'pst-email' );



 $panel = $titan->createAdminPanel( array(

'name' => 'Share Woocommerce Email',

) );



$generalTab = $panel->createTab( array(

'name' => 'Settings',

) );



$optionset = $panel->createTab( array(

'name' => 'Styles',

) );



$optionset->createOption(  array(

'name' => 'Select Button Size',

'id' => 'my_layout_swe',

'type' => 'radio-image',

'options' => array(

'large' => plugin_dir_url( __FILE__ ) . '/images/button1.png',

'small' => plugin_dir_url( __FILE__ ) . '/images/small.png',

'xtras' => plugin_dir_url( __FILE__ ) . '/images/xtras.png',

'blk' => plugin_dir_url( __FILE__ ) . '/images/block.png',

),

'default' => 'small',

) );



$optionset->createOption( array(

'name' => 'Button Alignment',

'id' => 'btn_algn_swe',

'options' => array(

'1' => 'Right',

'2' => 'Left',

'3' => 'Center',

),

'type' => 'radio',

'default' => '2',

) );



$optionset->createOption(  array(

'name' => 'Button Text',

'id' => 'btn_text_swe',

'type' => 'text',

'default' => 'Email this product',

) );



$optionset->createOption( array(

'name' => 'Button Background Color',

'id' => 'btn_background_color_swe',

'type' => 'color',

'desc' => 'Pick a color',

'default' => '#555555',

) );



$optionset->createOption( array(

'name' => 'Button Border Color',

'id' => 'btn_border_color_swe',

'type' => 'color',

'desc' => 'Pick a color',

'default' => '#555555',

) );



$optionset->createOption( array(

'name' => 'Email Content Styles',

'id' => 'contstyles_swe',

'type' => 'font',

'desc' => 'Select a style',

'show_font_family' => false,

'color' => '#333333',

'font-size' => '13px',

'line-height' => '5px',

'font-weight' => 'normal',

'show_letter_spacing' => false,

'show_font_variant' => false,

'show_text_shadow' => false,

'show_font_style' => false,
'show_text_transform' => false,

) );



$optionset->createOption( array(

'name' => 'Email Top Header Styles',

'id' => 'headstyles_swe',

'type' => 'font',

'desc' => 'Select a style',

'show_font_family' => false,

'color' => '#333333',

'font-size' => '13px',

'line-height' => '5px',

'font-weight' => 'normal',

'show_letter_spacing' => false,

'show_font_variant' => false,

'show_text_shadow' => false,

'show_font_style' => false,

'show_text_transform' => false,

'default' => array(

'color' => '#888888',

'font-weight' => '700',

)

) );



$optionset->createOption( array(

'name' => 'Email Footer Styles',

'id' => 'footerstyles_swe',

'type' => 'font',

'desc' => 'Select a style',

'show_font_family' => false,

'color' => '#333333',

'font-size' => '13px',

'line-height' => '5px',

'font-weight' => 'normal',

'show_letter_spacing' => false,

'show_font_variant' => false,

'show_text_shadow' => false,

'show_font_style' => false,

'show_text_transform' => false,

'default' => array(

'color' => '#888888',

'font-weight' => '700',

)

) );



$generalTab->createOption( array(

'name' => 'Content Type',

'id' => 'content_type_swe',

'options' => array(

'1' => 'Full Content',

'2' => 'Excerpt/Summary',

),

'type' => 'radio',

'desc' => 'Select',

'default' => '2',

) );

/*

$generalTab->createOption( array(

'name' => 'Check Post-Types',

'id' => 'swe_posttypes',

'type' => 'multicheck-post-types',

'desc' => 'Check a post-type you want to be shared.',

) );

*/





// Create options in My General Tab

$generalTab->createOption(  array(

'name' => 'Your email id',

'id' => 'myemail_id_swe',

'type' => 'text',

'desc' => 'Make sure the email is from your same domain to avoid being marked as spam.'

) );



$generalTab->createOption( array(

'name' => 'Email Top Header Area',

'id' => 'email_headermsg_swe',

'type' => 'editor',

'desc' => 'You can insert texts, signature, shortcodes and promo banner here',

'default' => 'Your friend shared a post'

) );



$generalTab->createOption( array(

'name' => 'Email Footer Area',

'id' => 'email_footermsg_swe',

'type' => 'editor',

'desc' => 'You can insert texts, signature, shortcodes and promo banner here',

'default' => 'Post shared via example.com'

) );



$generalTab->createOption( array(

'name' => 'Email success message',

'id' => 'email_success_swe',

'type' => 'text',

'desc' => 'Success Message',

'default' => 'Thankyou for sharing the article'

) );



$generalTab->createOption( array(

'name' => 'Show Logo',

'id' => 'logo_enable_swe',

'type' => 'enable',

'default' => false,

'desc' => 'Enable to show logo, If disabled will show blog name',

) );



$generalTab->createOption( array(

'type' => 'save'

) );



$optionset->createOption( array(

'type' => 'save'

) );



$generalTab->createOption( array(
'name' => '',
'id' => 'swepay',
'type' => 'note',
'desc' => 'Thankyou for using <b>Share Woocommerce To Email</b>.<br>You may want to support my development: <a target="_blank" href="https://paypal.me/sandeeptete">Paypal me a tip</a>'
) );

$generalTab->createOption(  array(
'name' => '',
'id' => 'swe_message_grid',
'type' => 'note',
'desc' => 'You may find other plugins from us to be useful below.<br><div class="autowide">
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/categories-gallery/">Bootstrap Categories Gallery</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/custom-scroll-bar-designer/">Custom Scrollbar Designer</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/custom-text-selection-colors/">Custom Text Selection Colors</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/disable-image-right-click/">Disable Image Right Click</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/easy-gallery-slideshow/">Easy Gallery Slideshow</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/exit-popup-show/">Exit Popup Show</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/popup-modal-for-youtube/">Popup Modal For Youtube</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/woo-availability-date/">Product Limited Time Availability Date for woocommerce</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/email-my-posts/">Share Posts To Email</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/custom-scroll-bar-designer/">Share Woocommerce to Email</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/share-woocommerce-email/">Custom Scrollbar Designer</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/total-sales-for-woocommerce/">Total Sales For Woocommerce</a></b></p>
  </div>
</div>'
) );
}

function swe_customcss()
{
  $swecss = '<style>.autowide {
  margin: 0 auto;
  width: 98%;
}
.autowide img {
  float: left;
  margin: 0 .75rem 0 0;
}
.autowide .module {
  xbackground-color: lightgrey;
  border-radius: .25rem;
  margin-bottom: 1rem;
  color: #0f8cbb;
}
.autowide .module p {
  padding: 4px 0px;
}

/* 2 columns: 600px */
@media only screen and (min-width: 600px) {
  .autowide .module {
    float: left;
    margin-right: 2.564102564102564%;
    width: 48.717948717948715%;
  }
  .autowide .module:nth-child(2n+0) {
    margin-right: 0;
  }
}

/* 3 columns: 768px */
@media only screen and (min-width: 768px) {
  .autowide .module {
    width: 31.623931623931625%;
  }
  .autowide .module:nth-child(2n+0) {
    margin-right: 2.564102564102564%;
  }
  .autowide .module:nth-child(3n+0) {
    margin-right: 0;
  }
}

/* 4 columns: 992px and up */
@media only screen and (min-width: 992px) {
  .autowide .module {
    width: 23.076923076923077%;
  }
  .autowide .module:nth-child(3n+0) {
    margin-right: 2.564102564102564%;
  }
  .autowide .module:nth-child(4n+0) {
    margin-right: 0;
  }
}</style>';
echo $swecss;

}
add_action('admin_head','swe_customcss');



function swe_template(){

	$titan = TitanFramework::getInstance( 'pst-email' );

	$logo_enable_swe = $titan->getOption( 'logo_enable_swe' );

	$email_footermsg_swe = $titan->getOption( 'email_footermsg_swe' );

	$footerstyles_swe = $titan->getOption( 'footerstyles_swe' );

	$email_headermsg_swe = $titan->getOption( 'email_headermsg_swe' );

	$headstyles_swe = $titan->getOption( 'headstyles_swe' );

	$contstyles_swe = $titan->getOption( 'contstyles_swe' );

	$content_type_swe = $titan->getOption( 'content_type_swe' );

	$permalink = get_permalink($post->ID);

	$bloginfo = get_bloginfo( $show, $filter );

	$aftercontent = $email_footermsg_swe;
	global $product;

	$query = $product->id;
	
    $product_description = get_post($query['product_id'])->post_content;
    

	//$product_description = $query['product_id']->post->post_content;
	global $post;

	if ( ! $post->post_excerpt ) {
	return;
	}
	$shdec = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
    //echo $shdec;

    function swe_attr(){
  
    global $product;
    $attributes = $product->get_attributes();
  
    if ( ! $attributes ) {
        return;
    }
  
    $out = '<div style="width:300px;float:left"><ul style="list-style:none;float:left" class="custom-attributes">';
  
    foreach ( $attributes as $attribute ) {
  
  
        // skip variations
        if ( $attribute['is_variation'] ) {
        continue;
        }
  
        if ( $attribute['is_taxonomy'] ) {
  
            $terms = wp_get_post_terms( $product->get_id(), $attribute['name'], 'all' );
            // get the taxonomy
            $tax = $terms[0]->taxonomy;
            // get the tax object
            $tax_object = get_taxonomy($tax);
            // get tax label
            if ( isset ( $tax_object->labels->singular_name ) ) {
                $tax_label = $tax_object->labels->singular_name;
            } elseif ( isset( $tax_object->label ) ) {
                $tax_label = $tax_object->label;
                // Trim label prefix since WC 3.0
                if ( 0 === strpos( $tax_label, 'Product ' ) ) {
                   $tax_label = substr( $tax_label, 8 );
                }                
            }
  
            foreach ( $terms as $term ) {
  
                $out .= '<li class="' . esc_attr( $attribute['name'] ) . ' ' . esc_attr( $term->slug ) . '">';
                $out .= '<span class="attribute-label">' . $tax_label . ': </span> ';
                $out .= '<span class="attribute-value">' . $term->name . '</span></li>';

  
            }
  
        } else {
  
            $out .= '<li class="' . sanitize_title($attribute['name']) . ' ' . sanitize_title($attribute['value']) . '">';
            $out .= '<span>' . $attribute['name'] . ': <br></span> ';
            $out .= '<span class="attribute-value">' . $attribute['value'] . '</span></li>';
        }
    }
  
    $out .= '</ul></div>';
   return $out;
    
	}

	$swe_add = apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a style="background:#ccc;padding:20px; text-decoration: none;" rel="nofollow" href="'.$_SERVER['SERVER_NAME'].'%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">Buy Now</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $class ) ? $class : 'button' ),
		esc_html( $product->add_to_cart_text() )
	),
$product );

	$amt = $product->get_price_html();
	$title = get_the_title( $post_id );
	if ( has_post_thumbnail() ) {
			$proimg  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
			$proimg .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
			$proimg .= '</a></div>';
		}
	$proimg = $proimg;

	$contents = '<div id="pros" style="width:700px;height:auto;margin-bottom:20px;" >
	<hr style="height:1px;border:none;color:#333;background-color:#ddd;" />
	<div id="titless" style="width:800px;text-align:center;font-size:20px"><h2>'.$title.'</h2></div>
	<div id="immg" style="width:400px;float:left">'.$proimg.'</div>

	<div id="shortdec" style="float:right;width:300px">'.$shdec.'
	<div id="stockk" style="float:left;width:300px;font-size:20px">'."Price:".'<br><br>'.$amt.'</div>
	<div style="width:300px;float:right;margin-top:10px">
	<div id="attri" style="float:left;width:500px;font-size:14px">'.swe_attr().'</div>
	</div>
	</div>
	<div style="width:300px;float:right;margin-top:30px">
	<div style="width:200px;">'.$swe_add.'</div>
	</div>
	
	<div style="width:700px;float:left;margin-bottom:20px;">'.$product_description.'</div>



	</div>';

	$excerpt = get_the_excerpt();

	$excerpt = substr($excerpt, 0, 300);

	$readmore = plugin_dir_url( __FILE__ ) . '/images/readmore.png';

	$custom_logo_id = get_theme_mod( 'custom_logo' );

	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

	//echo $image[0];

	$imgg = $image[0];

	if ($logo_enable_swe == enable){

	$imggs = '<div style="width:800px"><img style="text-align:center;" src="'.$imgg.'"/></div>';

        	//echo '<img src="'.$imgg.'"/>';

        }

        else{

        	$imggs = '<h2>'.$bloginfo.'</h2>';
        }
        if($content_type_swe == 1){
        	$cont = '<div id="contents" style="color:'.$contstyles_swe['color'].';line-height:'.$contstyles_swe['line-height'].';width:100%;font-size:'.$contstyles_swe['font-size'].';font-weight:'.$contstyles_swe['font-weight'].';text-decoration: none;">'.$contents.'</div>';

        }

        elseif ($content_type_swe == 2) {

        	$cont = '<div id="contents" style="color:'.$contstyles_swe['color'].';width:100%;font-size:'.$contstyles_swe['font-size'].';text-decoration: none;">'.$excerpt."...".'<br>

        	<span><a href="'.$permalink.'"><img style="width:120px" src="'.$readmore.'"/></a></span>

        	</div>';

        }





    $emptemp = '<div class="tempp" style="width:500px; height: auto;">

    		<div id="heads" style="color:'.$headstyles_swe['color'].';line-height:'.$headstyles_swe['line-height'].';width:800px;font-size:'.$headstyles_swe['font-size'].';font-weight:'.$headstyles_swe['font-weight'].';text-decoration: none;" align="center">

        	'.$email_headermsg_swe.'</div>

        	<div id="logoo" style="width: 500px;" align="center"><h3>

        	'.$imggs.'</h3></div>'.

	        		$cont.

	        		'<hr style="height:1px;border:none;color:#333;background-color:#ddd;width:500px;" />

	        		<div id="footers" style="color:'.$footerstyles_swe['color'].';line-height:'.$footerstyles_swe['line-height'].';width:500px;font-size:'.$footerstyles_swe['font-size'].';font-weight:'.$footerstyles_swe['font-weight'].';text-decoration: none;"">'.$aftercontent.'</div>

        	</div>

        	

        </div> ';

        return $emptemp;

}



add_action('wp_head','swe_pstemailpost',10);

function swe_pstemailpost()

{

$titan = TitanFramework::getInstance( 'pst-email' );

$myemail_id_swe = $titan->getOption( 'myemail_id_swe' );

 // do conditional stuff here

}

/*function swe_logos_enable(){

$titan = TitanFramework::getInstance( 'pst-email' );

$logo_enable_swe = $titan->getOption( 'logo_enable_swe' );

$custom_logo_id = get_theme_mod( 'custom_logo' );

$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

echo $image[0];

$imgg = $image[0];

if ($logo_enable_swe == enable){

	$imggs = '<img style="text-align:center" src="'.$imgg.'"/>';

        	//echo '<img src="'.$imgg.'"/>';

        }

        return $imggs;

}*/



add_action('wp_head','swe_conff',10);

function swe_conff(){

	?>

	

 <style>

            #progress { 

                display: none;

                color: green; 

            }

        </style>   



<?php

}





add_action('wp_head','swe_btn_bg_color',10);

function swe_btn_bg_color(){

	$titan = TitanFramework::getInstance( 'pst-email' );

	$btn_background_color_swe = $titan->getOption( 'btn_background_color_swe' );

	$btn_border_color_swe = $titan->getOption( 'btn_border_color_swe' );

?>

<style type="text/css">

	.btn-primary{

		background: <?php echo $btn_background_color_swe;?>!important;

		border-color:<?php echo $btn_border_color_swe;?>!important;

	}

	.modal-dialog {

    width: 600px;

    margin: 100px auto!important;

}

</style>

<?php

}


add_filter('wp_mail_from', 'swe_ppt_email_from');

	 

	function swe_ppt_email_from() {

	$titan = TitanFramework::getInstance( 'pst-email' );

	$myemail_id_swe = $titan->getOption( 'myemail_id_swe' );



	return $myemail_id_swe;

}


add_filter('woocommerce_single_product_summary', 'swe_wpptemail_before_after',40);

function swe_wpptemail_before_after() {

		$titan = TitanFramework::getInstance( 'pst-email' );

		$my_layout_swe = $titan->getOption('my_layout_swe');

		$btn_text_swe = $titan->getOption('btn_text_swe');

		$btn_algn_swe = $titan->getOption('btn_algn_swe');

		//$swe_posttypes = $titan->getOption('swe_posttypes');



if ($my_layout_swe == large) {

	if ( is_singular('product')){

    

    $aftercontent = '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">'

  		.$btn_text_swe.

		'</button>';

    $content .= '<p>'.$aftercontent.'</p>';

    }

    echo $content;

}



elseif ($my_layout_swe == small) {

	if ( is_singular('product') ) {

    

    $aftercontent = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">'

  		.$btn_text_swe.

		'</button>';

    $content .= '<p>'.$aftercontent.'</p>';

    }

    echo $content;

}



elseif ($my_layout_swe == xtras) {

	if ( is_singular('product') ) {

    

    $aftercontent = '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">'

  		.$btn_text_swe.

		'</button>';

    $content .= '<p>'.$aftercontent.'</p>';

    }

    echo $content;

}

elseif ($my_layout_swe == blk) {

	if ( is_singular('product') ) {

    

    $aftercontent = '<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">'

  		.$btn_text_swe.

		'</button>';

    $content .= '<p>'.$aftercontent.'</p>';

    }

    echo $content;

}

}

add_action('wp_head','swe_btnn_algn',10);

function swe_btnn_algn(){

	$titan = TitanFramework::getInstance( 'pst-email' );

	$btn_algn_swe = $titan->getOption('btn_algn_swe');

	if ($btn_algn_swe == 1) 

	{

		?>

	<style type="text/css">

		.btn-primary{

			float: right!important;

		}

	</style>

		<?php

	}

	elseif ($btn_algn_swe == 2) 

	{

		?><style type="text/css">

		.btn-primary{

			float: left!important;

		}

	</style><?php

	}

	elseif ($btn_algn_swe == 3) 

	{

		?>

		<style type="text/css">

		.btn-primary{

			margin-left: 50%!important;

		}

	</style>

	<?php

	}



}



add_filter('wp_mail_from_name', 'swe_ppt_email_from_name');

	 

	function swe_ppt_email_from_name() {

		$sender_name = strip_tags(trim($_POST["yname"]));

		$sender_name = str_replace(array("\r","\n"),array(" "," "),$sender_name);

	return $sender_name;

}



add_action('wp_footer','swe_pptemailja',10);

function swe_pptemailja()

{

	$titan = TitanFramework::getInstance( 'pst-email' );

	$email_success_swe = $titan->getOption( 'email_success_swe' );

	?>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel"><?php $title = get_the_title( $post_id );echo "Sending: ".$title;?></h4>

      </div>

      <div class="modal-body">

        <!-- Contact Form starts here-->

       

    	





<form class="form-horizontal" id="contactform" name="contact" role="form" method="post" action="#">



	<div class="form-group" id="name-group">

		<label for="name" class="col-sm-2 control-label">Your Name</label>

		<div class="col-sm-10">

			<input type="text" class="form-control" id="name" name="yname" placeholder="First & Last Name" value="">

							<span class="alert name-alert"></span>



		</div>

	</div>

	<div class="form-group" id="email-group">

		<label for="email" class="col-sm-2 control-label">Send To Email</label>

		<div class="col-sm-10">

					<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">

					<span class="alert email-alert"></span>

		</div>

	</div>

	

	<div class="form-group">

		<div class="col-sm-10 col-sm-offset-2">

		



			<input id="submit" name="submit" type="submit" value="Send" class="btn btn-success" onclick="document.getElementById('progress').style.display = 'block' ;"> 

<!-- 						<button type="submit" class="btn btn-lg btn-primary">Send</button>

 -->

		</div>

	</div>

	

</form>

<div id="progress"><?php echo $email_success_swe;?></div>

<script type="text/javascript">

	// Function Validation Form

function valForm() {



	var formMessages = $('#form-messages');



	if ($('#name').val() == '') {

		$('#name-group').addClass('has-error');

		$('#name-alert').addClass('text-danger').html('Your name is empty');



	} else {

		$('#name-group').removeClass('has-error');

		$('#name-alert').removeClass('text-danger').html('');

	}



	if ($('#email').val() === '') {

		$('#email-group').addClass('has-error');

		$('#email-alert').addClass('text-danger').html('Your email is empty');

	} else {

		$('#email-group').removeClass('has-error');

		$('#email-alert').removeClass('text-danger').html('');

	}



}

// End Function



$(function() {



	// Contact Form

    var form = $('#contactform');

    var formMessages = $('#form-messages');



	$(form).submit(function(event) {



	    event.preventDefault();

	    formMessages.html('');



	    if(valForm()){

	    	var formData = $(form).serialize();



			$.ajax({

			    type: 'POST',

			    url: $(form).attr('action'),

			    data: formData

			}).done(function(response) {



			    $(formMessages).removeClass('text-warning');

			    $(formMessages).addClass('text-success');



			    $(formMessages).text('Your message has been sent.');



			    // Clear the form.

			    $('#name').val('');

			    $('#email').val('');



			}).fail(function(data) {



			    $(formMessages).removeClass('success');

			    $(formMessages).addClass('error');



			    if (data.responseText !== '') {

			        $(formMessages).text(data.responseText);

			    } else {

			        $(formMessages).text('Oops! An error occured and your message could not be sent.');

			    }

			});

	    }



	    

	});

	// End Contact Form

});

</script>



	<!--Contact form ends here-->

	</div>

      

    </div>

  </div>

</div>



<?php

/*function swe_msg_footer($content){

	$titan = TitanFramework::getInstance( 'pst-email' );

	$email_footermsg_swe = $titan->getOption( 'email_footermsg_swe' );

	if ( is_singular('product') ) {

    $aftercontent = $email_footermsg_swe;

    $content .= '<p>'.$aftercontent.'</p>';

    }

    echo $content;

}*/





    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    	function swe_ppt_mail_format() {

    return 'text/html';

}

add_filter( 'wp_mail_content_type_swe','swe_ppt_mail_format' );

        // Get the form fields and remove whitespace.

        $to = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

        

        //$query = get_post(get_the_ID()); 

		remove_filter('the_content', 'swe_wpptemail_before_after');

		//add_filter('the_content', 'swe_msg_footer');

		//$message = logos_enable().'<br>'.apply_filters('the_content', $query->post_content).'<br>';

        $message = swe_template();

        $title = get_the_title( $post_id );

		$subject = $title;

        // Build the email headers.

	    $headers = 'MIME-Version: 1.0' . "\r\n";

		$headers = array('Content-Type: text/html; charset=UTF-8');

		//$headers .= 'From: '. $name .' <"'. $email .'">' . "\r\n";

        // Build the email content.

                // Send the email.

        if (wp_mail($to, $subject, $message, $headers)) {

        	remove_filter('wp_mail_from', 'swe_ppt_email_from');

remove_filter('wp_mail_from_name', 'swe_ppt_email_from_name');

remove_filter('the_content', 'swe_msg_footer');

            // Set a 200 (okay) response code.

            http_response_code(200);

        } else {

            // Set a 500 (internal server error) response code.

            http_response_code(500);

        }

	}

}

?>