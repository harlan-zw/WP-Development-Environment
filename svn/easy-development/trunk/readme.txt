=== Development Environment ===
Contributors: loonpwn
Tags: development, easy, environment, dev, env, whoops
Tested up to: 4.8.2
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 4.6

As a developer I want my development environment to be as accessible and easy to work with as possible so that I can improve my code quality and efficiency.

== Description ==

This is one step in setting up an ideal WordPress Development Environment. Make your development life easier and more efficient with these simple components.

Components
---------
- **Disallow Indexing** Turn off the public blog option. This will modify the robots.txt generation to block all search engines
- **Flush Rewrites** No more weird redirection problems when working on custom post types or taxonomies.
- **No Password Logins** Just stick the user in you want to login as, write anything in the password field, and it will login! Only works when connecting from local host
- **Whoops Error Handling** The error screen from laravel, now in your WordPress setup
- **Template Hints** See which templates are loading for the page you are on


The outcome is to exchange security for ease of use, for that reason it's important that you take the security measures needed
to ensure that someone can't take advantage of the site with this plugin enabled.

If you're running on a staging environment ensure you have setup a [htpasswd](http://www.htaccesstools.com/htpasswd-generator/)


#### **Filters**

*Set Environment*

`development-environment/is-development`

Dynamically set how the plugin detects if the environment is development based on your own criteria.

*Stop a component from loading*

`development-environment/require-component-$component`

Disable require of a component if you don't want to use it. Possible values are:

`disallow-indexing`, `flush-rewrites`, `no-password-logins`, `whoops-error-handling`



== Installation ==

To use the plugin, it must be able to detect the environment is development or staging, this can be done via the following:

**wp-config.php**
Add `define('WP_ENV', 'development')`

 **vhost**
Add `SetEnv WP_ENV "development"`

Or additionally via the available hooks.


== Changelog ==

See changelog on (github)[https://github.com/loonpwn/wp-development-environment/releases]
