=== Snack Ads.txt ===
Contributors: bouk
Donate link: 
Tags: ads.txt, advertising
Requires at least: 5.3
Tested up to: 6.6.1
Requires PHP: 7.0
Stable tag: 3.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Handles automatic creation and updates of ads.txt file for publishers who advertise with Snack Media.
 
== Description ==
 
ads.txt is an IAB-approved text file that aims to prevent unauthorized inventory sales. 

This plugin is a solution for the remote creation and management of ads.txt files for websites in the Snack Media advertising network.

Snack Media are a Google-certified partner, based in the UK, who specialise in optimising and monetising websites, working with a network of over 400 websites. We offer an advanced advertising set-up - header and exchange bidding across programmatic, video, native rich media etc.

We have specialised teams across ad-operations, tech, editorial and sales to help publishers grow their digital revenues and provide IAB approved solutions for GDPR & CCPA.

We also offer a range of additional products, tools and services to help publishers drive traffic, maximise engagement and optimise user experience.

To find out more, head to [Snack Media](https://www.snack-media.com/publishers/?utm_source=wp-plugin-repository) or contact [jamesm@snack-media.com](mailto:jamesm@snack-media.com)

== Installation ==
 
1. Upload the contents of this .zip file into '/wp-content/plugins/snack-ads-txt' on your WordPress installation, or via the 'Plugins->Add New' option in the Wordpress dashboard.
1. Activate the plugin via the 'Plugins' option in the WordPress dashboard.
1. Once activated new re-occuring cron task is scheduled, which automatically updates ads.txt file. In case updates are failing, you may need to manually specify HEADER_BIDDING_SITE_ID in wp-config.php. In case you are unsure about this step, please contact support@snack-media.com.
 
== Frequently Asked Questions ==
 
== Screenshots ==

== Changelog ==

= 3.2.0 - 5th September 2024 =
* Make sure old schedule is removed first

= 3.1.1 - 2nd September 2024 =
* Updating frequency of ads.txt updates checks

= 3.1.0 - 17th June 2024 =
* Introducing new variable HEADER_BIDDING_ADSTXT_VERSION allowing to switch between legacy and new API endpoint for fetching ads.txt entries

= 3.0.7 - 1st June 2022 =
* Correctly register new REST route

= 3.0.6 - 26th May 2022 =
* Updating tested up to version

= 3.0.5 - 26th January 2022 =
* Updating tested up to version

= 3.0.4 - 19th August 2021 =
* Updating tested up to version

= 3.0.3 - 28th December 2020 =
* Updating tested up to version

= 3.0.2 - 4th August 2020 =
* Updating tested up to version

= 3.0.0 - 3rd March 2020 =
* Adding endpoint allowing to force ads.txt update immediatelly

= 2.0.0 =
* First stable release of the plugin