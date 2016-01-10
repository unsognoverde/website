<?php

/**
 * Define available Demo Content Packs
 *
 * The 'path' argument inside each Demo Content Pack indicates a folder inside the /inc/dcontent
 * folder of the theme, ALWAYS. All demo content packs should go inside that folder.
 */

function qi_available_demo_packs() {

	$dcontent_packs = array(

		'main' => array(
			'slug' 		=> 'main',
			'path'		=> 'main/',
			'name' 		=> esc_html__('Main Demo', 'quadro'),
			'desc' 		=> esc_html__('This is the full demo of Modules Theme. You\'ll get several blog and portfolio possibilities, homepages, about pages, a shop page and more.', 'quadro'),
			'tags'		=> esc_html__('multipurpose, versatile, corporate, shop, portfolio, blog', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules/',
			// Demo Content File Name
			'file' 		=> 'modmain.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'contact-form-7'=>'Contact Form 7',
								'jetpack'=>'Jetpack',
								'siteorigin-panels'=>'Page Builder',
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'responsive-lightbox'=>'Responsive Lightbox',
								'woocommerce'=>'WooCommerce',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'agency' => array(
			'slug' 		=> 'agency',
			'path'		=> 'agency/',
			'name' 		=> esc_html__('Agency', 'quadro'),
			'desc' 		=> esc_html__('Agency can serve from a small studio to a big agency. Use it to show your services and to feature your work. Add your copy, mix it up, and give your company its deserved website. Pages included: Home, About, Creative Process, Portfolio, Contact.', 'quadro'),
			'tags'		=> esc_html__('studio, portfolio, services, creative, business, corporate', 'quadro'),
			'thumbs' 	=> array( 'main.jpg'),
			'url'		=> 'http://demos.quadroideas.com/modules-agency/',
			// Demo Content File Name
			'file' 		=> 'modagency.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'siteorigin-panels'=>'Page Builder',
								'responsive-lightbox'=>'Responsive Lightbox',
								'quadro-portfolio'=>'Quadro Portfolio Type',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'corporate' => array(
			'slug' 		=> 'corporate',
			'path'		=> 'corporate/',
			'name' 		=> esc_html__('Corporate', 'quadro'),
			'desc' 		=> esc_html__('Build a corporate business site. Pages included: Home, Services, Works, News, Contact.', 'quadro'),
			'tags'		=> esc_html__('business, corporate, services, agency', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-corporate/',
			// Demo Content File Name
			'file' 		=> 'modcorporate.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'contact-form-7'=>'Contact Form 7',
								'quadro-portfolio'=>'Quadro Portfolio Type',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'shop' => array(
			'slug' 		=> 'shop',
			'path'		=> 'shop/',
			'name' 		=> esc_html__('Shop', 'quadro'),
			'desc' 		=> esc_html__('The perfect look and layout for a modern online store. With a neat slider on the homepage to feature products/news/offers, and pages prepared to show the big categories of your shop each one with its own style. It also includes a simple CSS snippet to twist the services look (layout 3) especially for this demo. Pages included: Home, Shop Category Pages, FAQs.', 'quadro'),
			'tags'		=> esc_html__('shop, e-commerce, store, retailer', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-shop/',
			// Demo Content File Name
			'file' 		=> 'modshop.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'siteorigin-panels'=>'Page Builder',
								'woocommerce'=>'WooCommerce',
								'woocommerce-colors'=>'WooCommerce Colors',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'portfolio' => array(
			'slug' 		=> 'portfolio',
			'path'		=> 'portfolio/',
			'name' 		=> esc_html__('Portfolio', 'quadro'),
			'desc' 		=> esc_html__('A minimal portfolio for a cool studio or a freelancer. It features your works in a clean and modern way, with a lot of white and fine typography. Pages included: Portfolio (as homepage), About, Team, Contact.', 'quadro'),
			'tags'		=> esc_html__('studio, agency, portfolio, creative, hipster, freelancer', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-portfolio/',
			// Demo Content File Name
			'file' 		=> 'modportfolio.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'jetpack'=>'Jetpack',
								'siteorigin-panels'=>'Page Builder',
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'PORTFOLIO',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'colors' => array(
			'slug' 		=> 'colors',
			'path'		=> 'colors/',
			'name' 		=> esc_html__('Colors', 'quadro'),
			'desc' 		=> esc_html__('Module\'s most colorful demo. Use it to get a visual impact on your visitors. Colors is good for a product site, a small agency or business. Pages included: Home, About, About 2, Blog, Contact.', 'quadro'),
			'tags'		=> esc_html__('colorful, product, sales, modern', 'quadro'),
			'thumbs' 	=> array( 'main.jpg'),
			'url'		=> 'http://demos.quadroideas.com/modules-colors/',
			// Demo Content File Name
			'file' 		=> 'modcolors.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'contact-form-7'=>'Contact Form 7',
								'siteorigin-panels'=>'Page Builder',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'photography' => array(
			'slug' 		=> 'photography',
			'path'		=> 'photography/',
			'name' 		=> esc_html__('Photography Black', 'quadro'),
			'desc' 		=> esc_html__('A neat look for a photographer or a studio website. Features the important: your work. Pages included: Home, About, About 2, Works, Contact.', 'quadro'),
			'tags'		=> esc_html__('creative, portfolio, studio, black, photography', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-photography/',
			// Demo Content File Name
			'file' 		=> 'modphotography.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'photography-w' => array(
			'slug' 		=> 'photography-w',
			'path'		=> 'photography-w/',
			'name' 		=> esc_html__('Photography White', 'quadro'),
			'desc' 		=> esc_html__('A clean look for a photographer or a studio website. Features the important: your work. Pages included: Home, About, About 2, Works, Contact.', 'quadro'),
			'tags'		=> esc_html__('creative, portfolio, studio, white, photography', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-photography-w/',
			// Demo Content File Name
			'file' 		=> 'modphotographywhite.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'quadro-portfolio'=>'Quadro Portfolio Type',
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'app' => array(
			'slug' 		=> 'app',
			'path'		=> 'app/',
			'name' 		=> esc_html__('App', 'quadro'),
			'desc' 		=> esc_html__('Just finished working on a new app? Launch it together with a neat website. This demo suits all kind of digital products, try it. Pages included: Home, Help, Stories (blog).', 'quadro'),
			'tags'		=> esc_html__('app, mobile, smartphone, product', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-app/',
			// Demo Content File Name
			'file' 		=> 'modapp.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'gourmet' => array(
			'slug' 		=> 'gourmet',
			'path'		=> 'gourmet/',
			'name' 		=> esc_html__('Gourmet', 'quadro'),
			'desc' 		=> esc_html__('A great pre-made layout for a small school or studies center: from a kitchen school to a dance center place. It can also serve a personal website for a chef, a dancer, an artist, etc. Pages included: Home, History, Projects, Blog, Contact us.', 'quadro'),
			'tags'		=> esc_html__('elegant, school, classes, news', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-gourmet/',
			// Demo Content File Name
			'file' 		=> 'modgourmet.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'contact-form-7'=>'Contact Form 7',
								'quadro-portfolio'=>'Quadro Portfolio Type',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'blog' => array(
			'slug' 		=> 'blog',
			'path'		=> 'blog/',
			'name' 		=> esc_html__('Personal Blog', 'quadro'),
			'desc' 		=> esc_html__('A Medium-like blog. Clean. Personal. Beautiful. Pages included: Home 1, Home 2, Home 3, About me.', 'quadro'),
			'tags'		=> esc_html__('personal, stories, medium, blog', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-blog/',
			// Demo Content File Name
			'file' 		=> 'modblog.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'pop' => array(
			'slug' 		=> 'pop',
			'path'		=> 'pop/',
			'name' 		=> esc_html__('Pop', 'quadro'),
			'desc' 		=> esc_html__('A pop style site for a portal or a shop. Pages included: Home, Shop, Blog, About.', 'quadro'),
			'tags'		=> esc_html__('shop, modern, portal, cool', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-pop/',
			// Demo Content File Name
			'file' 		=> 'modpop.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'woocommerce'=>'WooCommerce',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

		'restaurant' => array(
			'slug' 		=> 'restaurant',
			'path'		=> 'restaurant/',
			'name' 		=> esc_html__('Restaurant', 'quadro'),
			'desc' 		=> esc_html__('A trendy restaurant website with room for promos, a menu and beautiful food pics. Pages included: Home, Menu, About, News, Contact.', 'quadro'),
			'tags'		=> esc_html__('food, bar, resto, deli', 'quadro'),
			'thumbs' 	=> array( 'main.jpg' ),
			'url'		=> 'http://demos.quadroideas.com/modules-restaurant/',
			// Demo Content File Name
			'file' 		=> 'modrestaurant.demo.xml.gz',
			// Demo Content Settings File (.TXT)
			'settings' 	=> 'options_export.txt',
			// Demo Content Widgets
			'widgets' 	=> 'widget_data.json',
			// Demo Content Plugins
			'plugins' 	=> 	array(
								'responsive-lightbox'=>'Responsive Lightbox',
							),
			// Settings >> Reading : Front Page Displays ( 'page' || 'posts' )
			'reading' 	=> 'page',
			// Settings >> Reading : Front Page
			'front' 	=> 'Home',
			// Settings >> Reading : Posts Page
			'posts' 	=> '',
		),

	);

	return $dcontent_packs;

}

?>