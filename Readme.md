# WordPress Starter-Plugin featuring VueJS and REST API

This starter plugin demonstrates the usage of [VueJS](https://vuejs.org/) apps in the frontend of a WordPress website and the communication with the WordPress backend via a customized [WP REST API](http://v2.wp-api.org/) endpoint.


## Features

This plugin is also meant as a starting point for the development of own WordPress+VueJS plugins. Therefore, it features:

* A basic WordPress plugin including:
	* A frontend class, which renders the VueJS app,
	* A backend class, which provides a simple settings page,
	* A REST class, which creates a single REST endpoint.
* A VueJS app:
	* Shows a message string, which can be defined on the plugin's settings page.
	* The message string is loaded via a request to a customized WP REST API endpoint.
* [Webpack](https://webpack.js.org/) as a module bundler and task runner, including ready-to-use configurations for
	* Babel, BrowserSync, ESLint and code minimization.


## Installation

*Prerequisites:* Node.js must be installed – visit the [Node.js website](https://nodejs.org) for installation instructions or use NVM (recommended).

1. Clone this repo to your local WordPress plugin folder.
2. Run `npm install` inside the new folder to install all dependencies.
3. Run `npm run dev` to bundle the VueJS app to `public/frontend.js` \
   or run `npm run prod` to bundle to `public/frontend.min.js`.
4. Active the plugin ("Plugin Vue Starter") in the adminstration area.
5. Create a new page. Add a shortcode `[vue-app]` anywhere in the page content.

Visit the page. The shortcode is now replaced by the VueJS app. The displayed message text can be set in the plugin's settings page in the admin area (*Settings/Plugin-Vue Starter*).


## File structure

The folder `includes` contains three PHP classes: one for the frontend, one for the admin page and one for the REST endpoint. The classes are loaded by the main plugin file `plugin-vue-starter.php`.

The VueJS app files are located in `src`. The app is very simple. The only additional module is *Axios*, which is used for the API calls.

The final bundles are saved in the `public/` folder.


## Development

This starter plugin is ready for development:

1. Configure the browser synchronization in the Webpack configuration file `webpack.config.js` to use the URL of your frontend webpage (see option `proxy` in the call of the `BrowserSyncPlugin`).

2. Run `npm run watch` to start browser synchronization: Any change of the plugin files will trigger a) a new bundling of the app and b) the reload of the frontend page in the browser.

You can easily extend the plugin in various ways:

* Extend the basic VueJS app,
* Add additional VueJS apps (in `src/`) and connect them to new shortcodes (in `includes/code-frontend.php`).
* Extend the settings page and/or include VueJS apps also in the admin area.
* Extend the REST API.


## Production

The plugin can easily deployed to your production server:

1. Make sure that the *minimized* bundle file (`frontend.min.js`) is loaded in function `render_vue_app()` in file `class-frontend.php`.
2.  Copy only necessary files to the server:
	* folder `includes/` with all files,
	* folder `public/` with the file `frontend.min.js`,
	* and the file `plugin-vue-starter.php` in plugin main folder.



