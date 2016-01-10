<?php
/**
 * Returns theme specific Frequently Asked Questions for the
 * Getting Started page.
 */

$theme = wp_get_theme();
?>

<ul id="theme-faqs-list" class="theme-faqs-list">
	<li><a href="#faqs-register" class="scroll-to-link"><?php esc_html_e('How do I register the theme?', 'quadro'); ?></a></li>
	<li><a href="#faqs-support" class="scroll-to-link"><?php esc_html_e('Where do I get support for ', 'quadro'); echo $theme . '?';  ?></a></li>
	<li><a href="#faqs-demo" class="scroll-to-link"><?php esc_html_e('How can I make the site look like the demo?', 'quadro') ?></a></li>
	<li><a href="#faqs-plugins" class="scroll-to-link"><?php esc_html_e('Should I install all the recommended plugins?', 'quadro') ?></a></li>
	<li><a href="#faqs-update" class="scroll-to-link"><?php esc_html_e('How do I get theme updates?', 'quadro') ?></a></li>
	<li><a href="#faqs-import" class="scroll-to-link"><?php esc_html_e('I installed a demo pack but not every element got installed.', 'quadro') ?></a></li>
</ul>

<div class="theme-faqs-content">

	<div class="theme-faq">
		<h3 id="faqs-register"><?php esc_html_e('How do I register the theme and activate the license?', 'quadro'); ?></h3>
		<p><?php echo esc_html__('To register the theme navigate to', 'quadro') . ' <a href="http://quadroideas.com/account/" target="_blank">http://quadroideas.com/account/</a>, ' . esc_html__('enter your preferred details for the account and click on "Register a purchased theme". You will need to select the theme from a list and enter your purchase key, and that\'s about it. Once you do that you should see the theme appear on the "Your Registered Items" section. The only thing left to do is to enter your QuadroIdeas credentials on the General tab of the', 'quadro') . ' <a href="' . admin_url( 'themes.php?page=quadro-settings') . '">Theme Options</a> ' . esc_html__('page. You can click the "Check Now" button after you saved the options to make sure the license has been properly enabled for the theme.', 'quadro'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-support"><?php esc_html_e('Where do I get support for ', 'quadro'); echo $theme . '?';  ?></h3>
		<p><?php echo esc_html__('Found yourself in front of a tricky step you don\'t know how to solve? Jump over to our dedicated support forum at', 'quadro') . ' <a href="http://quadroideas.com/support/" target="_blank">http://quadroideas.com/support/</a> ' . esc_html__('where our support team will gladly assist you. Access is for licensed users only, so don\'t forget to register your theme first. Oh! And try to be as descriptive as you can when writing your question. Extra kudos for providing a link URL to your site. :)', 'quadro'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-demo"><?php esc_html_e('How can I make the site look like the demo?', 'quadro') ?></h3>
		<p><?php echo esc_html__('To make your site look just like the demo, navigate to', 'quadro') . ' <a href="' . admin_url( 'themes.php?page=quadro-settings') . '">Theme Options</a>, ' . esc_html__('look for the "Open Demo Content Importer" button and follow the instructions. Be aware that this will import content to your site, as well as replace most of the theme options you might already set up.', 'quadro'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-plugins"><?php esc_html_e('Should I install all the recommended plugins?', 'quadro') ?></h3>
		<p><?php esc_html_e('The only required plugin to work with this theme is the Quadro Portfolio plugin included in the theme package (and you can skip it\'s installation if you won\'t be using the Portfolio section). All the other plugins that you will find as "Recommended" are no more than that. They will improve or expand the functionality of the theme but you are free to install them as you whish.', 'quadro'); ?></p>
	</div>
	
	<div class="theme-faq">
		<h3 id="faqs-update"><?php esc_html_e('How do I get theme updates?', 'quadro') ?></h3>
		<p><?php esc_html_e('Once you register the theme and activate the license, you will get update notices at your WordPress Updates dashboard as you would do for any other theme or plugin. Just click the Update option when it is presented to you and theme will automatically update to the latest available version.', 'quadro'); ?></p>
	</div>

	<div class="theme-faq">
		<h3 id="faqs-import"><?php esc_html_e('I installed a demo pack but not every element got installed.', 'quadro') ?></h3>
		<p><?php esc_html_e('Before you install a demo pack, please make sure that the relevant plugins (those that are in use on the demo pack you are about to install) are installed. If you install a demo pack that uses WooCommerce, for example, and you install it without the plugin being activated, the products won\'t get imported.', 'quadro'); ?></p>
		<p><?php esc_html_e('Also, if you made already some demo pack imports, you may have some elements already in your database that won\'t get imported twice. Before attempting the import again, please make sure you have deleted those, and emptied your trash.', 'quadro'); ?></p>
	</div>
	
</div>