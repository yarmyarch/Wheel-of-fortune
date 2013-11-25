=== Zopim Live Chat ===
Contributors: bencxr
Tags: widget, plugin, sidebar, page, admin, enhancement, livechat, chat, widget
Requires at least: 3.1
Tested up to: 3.4.2
Stable tag: 1.2.6

Zopim is an award winning chat solution that helps website owners to engage their visitors and convert customers into fans!

== Description ==

Ever wondered how to chat with visitors to your website? With <a href="http://www.zopim.com/?utm_source=wpdirectory&utm_medium=link&utm_campaign=wp%2Bplugin">Zopim</a> Live Chat, they are just a click away!

Using our <a href="http://blog.zopim.com/2010/10/28/awards-are-rolling-in/">award-winning</a> tool to respond instantly to visitors and engage them proactively. Live chat can’t be simpler with Zopim.

[youtube https://www.youtube.com/watch?v=tSRSn9hJU1c]

Zopim Live Chat shows up as a chatbar docked at the bottom of your website. Visitors chat with you simply by clicking on the Zopim Chat Widget.

**What you can do with Zopim Live Chat:**

* Know what your visitors are looking at. See which product page they are currently viewing.
* Let customers reach you directly. You can also proactively click on them to start a chat.
* Reply to chats online or offline via any browser, or your favorite IM client.

**Why Zopim Live Chat but not anyone else?**

* A real customer-centric live chat tool that is loved by 50,000 businesses around the world.
* Simple to setup and use.
* Nice interface with fully customizable chat widget.
* 24/7 technical support.
* Chat widget available in more than 40 languages*.

Just to name a few!

**Some Geeky Facts**

* Work across major browsers ( Internet Explorer 6+, Firefox, Google Chrome, Opera, Safar) and IMs (Gtalk / MSN / Yahoo! Messenger / AIM).
* Uptime averaged 99.8%.
* New HTML5 dashboard.
* iPhone application available.
* Integration seamlessly with Uservoice, Salesforce, Highrise, Batchbook, Zendesk and more.

Love to know more about the product? Please visit our <a href="https://www.zopim.com/product">website</a>.

What are you waiting for? Download Zopim Live Chat plugin now and <a href="https://www.zopim.com/?aref=MjUxMjY4:1TeORR:9SP1e-iPTuAVXROJA6UU5seC8x4&visit_id=6ffe00ec3cfc11e2b5ab22000a1db8fa&utm_source=wpdirectory&utm_medium=link&utm_campaign=wp%2Bsignup#signup">sign up here</a> for a free account!

**See languages available, lovingly translated by Zopim users (in alphabetical order)**

* Arabic | Bulgarian | Chinese | Croatian | Czech | Danish | Dutch; Flemish | Estonian | Faroese | Finnish | French | Georgian | German | Greek | Hebrew | Hungarian | Icelandic | Indonesian | Italian | Japanese | Korean | Kurdish | Latvian | Lithuanian | Macedonian | Malay | Norwegian Bokmal | Persian | Polish | Portuguese | Romanian | Russian | Serbian | Slovak | Slovenian | Spanish; Castilian | Swedish | Thai | Turkish | Ukranian | Urdu | Vietnamese

== Changelog ==

= 1.2.6 =
* Addresses XSS vulnerabilities concerns by removing ZeroClipboard

= 1.2.5 =
* Enhancement to Theme Editor - now autoloads blog's url automatically

= 1.2.4 =
* Adds an optional widget settings box
* Widget settings saved from old wordpress plugin will be migrated to the optional settings box
* Visitor info uses new wp api and now enabled by default
* Required Wordpress version bumped to 3.1

= 1.2.3 =
* Replaces old customize widget page with new theme editor
* Remove customizewidget.php

= 1.2.2 =
* adds User Capability levels, allowing non-admins to use the plugin admin interface
* Admins can use add the following code
	$role = get_role( 'editor' ); $role->add_cap( 'access_zopim' );
to their themes, or use the Members plugin (http://wordpress.org/extend/plugins/members/)
to give roles the 'access_zopim' capability.

= 1.2.1 =
* Uses wordpress http api for better linkup support with multiple transports
* Reduce name collisions in functions
* Adds compatibility to premiumpress theme

= 1.2.0 =
* Signup process is now linked to zopim.com as per Wordpress guidelines.

= 1.1.3 =
* Update Zopim embed script
* Add option to override dashboard settings for chat bubble text

= 1.1.2 =
* Maintenance update: Compatibility update for Wordpress 3.3.1

= 1.1.1 =
* Maintenance update: Fix invalid plugin header (zopim.php) for new installation

= 1.1.0 =
* Maintenance update: Greeting messages are now saved properly.
* Add more language options in customization page.
* Using new Zopim async embed script: improve page's load time and do not block page's rendering anymore

= 1.0.7 =
* Maintenance update: Remove phased out "middle left", "middle right" positions
* Add options to let user decides hiding of chat bubble, no longer force show/hide
* Enable option for not using plugins' greeting messages

= 1.0.6 =
* Maintenance update: Class' redeclaration conflict fix.

= 1.0.5 =
* Maintenance update: fix minor bug on widget customization page - online msg input

= 1.0.4 =
* Robustness update: Make sure widget won't appear more than once.

= 1.0.3 =
* Maintenance update: New line bugfixes.

= 1.0.2 =
* Maintenance update: More curl robustness enhancements.

= 1.0.1 =
* Maintenance update: More robust connectivity, CURL errors caught
* Note: PHP Curl is required (and has always been).

= 1.0 =
* Stability update: Official Plugin Launched

= 0.6.1 =
* Update: Launched with improved signup process and minor cosmetic fixes.

= 0.6.0 =
* UI fix: Improved account management page.

= 0.5.0 =

* Feature: Push surveys and questions to the visitor.
* Bugfix: In-plugin dashboard will be hidden in full screen mode.

= 0.4.0 =

* Feature: Provide customer service through your favourite IM client (MSN, GTalk, Yahoo, AIM)
* Feature: You can access the dashboard in full screen!

= 0.3.0 =

* Feature: Connect to Zopim servers using 256-bit industry standard SSL for increased security!
* Feature: You can experiment with customizing the widget even without an account.
* Feature: Change the automatic messages displayed on the widget when it first loads, and depending on your online status.
* Feature: Customize the language of the widget.
* Bugfix: Positioning customization now works properly.

= 0.2.0 =

* Feature: Live Visitor Analytics (page your users are on, webpaths, length of stay, repeat visits and much more!)
* Feature: Create an account directly in the plugin.
* Feature: Rank Visitors by priority of importance.

= 0.1.0 =

* Feature: Add the Zopim live chat widget to your site!
* Feature: Customize look and feel of the widget, including themes and color!
* Feature: Use wordpress user information to populate visitor data in the plugin.

== Screenshots ==

1. Chat window on your website - active chat
2. Chat widget on your website - minimized
3. Account Configuration
4. Styling and customiation
5. Another nice screenshot on a 'virtual' monitor

== Frequently Asked Questions ==

= Do I have to install any software on my server to get this working? =

Not at all! Zopim is a hosted livechat service. Simply configure the plugin and you're done!

= Which web browsers work best with this plugin =

Though designed to work on most browsers, Zopim works best in the following environment: IE 6 or later (PC), Firefox 2 or later (Mac, PC, or Linux), Safari 2 or later (Mac), Google Chrome (PC, Mac).

= I managed to install the plugin but cannot link up to Zopim. Why? =
The plugin tries to link up with zopim by connecting using a few approaches including PHP Curl. If the outgoing connections are blocked (eg. by a firewall), please request your server administrator.

Alternatively, you can also manually include the script in the footer file ("wp-content/themes/default/footer.php" in your wordpress installation).

= Is it free to use? =

The plugin comes with a free plan specially tailored for Wordpress users. Power users can purchase upgrade options anytime.

= How can I chat with more visitors at the same time? =

You can easily do so by upgrade to a better plan. To find out more about the plans and features we offer, please visit https://www.zopim.com/pricing

= Its just not working for me! HELP! =

Dont worry!! We are happy to assist! Just come on down to our site at http://www.zopim.com or leave an email for us at support@zopim.com and we will help you with installation.

== Usage ==

After enabling the plug in, head on to the widget customization page to change settings and integrate its look and feel to match your site. When done, enable it by visiting the account configuration page and completing the instant signup process.

== Installation ==

*Server Requirements:* PHP4 or PHP5.

*Wordpress versions:* Wordpress 2.7 and up.

Step-by-step Guide:

* Install plugin from WordPress directory and activate it.
* Under Zopim Chat section, click on Account Setup to link up your Zopim account.
* Customize the chat widget to your preference.
* Navigate to IM Chat Bots to setup chat bots.
* Finally, make full use of our intuitive Dashboard to manage your chat widget.
