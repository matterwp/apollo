# Apollo - Modern WordPress Plugin Boilerplate

![GitHub Release](https://img.shields.io/github/v-release/matterwp/apollo?include_prereleases) ![GitHub License](https://img.shields.io/github/license/matterwp/apollo) [![Codacy Badge](https://app.codacy.com/project/badge/Grade/fbcef8300f734965ab59b7ac93a28f8f)](https://app.codacy.com/gh/matterwp/apollo/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade) ![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg) ![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/matterwp/apollo) ![GitHub repo size](https://img.shields.io/github/repo-size/matterwp/apollo)

Apollo is like a cheat code for speeding up your WordPress plugin projects. It's designed with OOP principles in mind, so your plugins will be easy to manage and expand. And it's packed with modern tools like Webpack, Tailwind, and BrowserSync to make your life even easier.

The whole point of Apollo is to be super flexible. Whether you're a PHP pro or you prefer working with JS frameworks like Vue or React, Apollo can handle it all.

But remember, it's not a one-size-fits-all solution where you can just copy and paste stuff. Think of Apollo as your starting point, giving you the boost you need to create top-notch WordPress plugins with less hassle.

## 🚀 Features

- Modern PHP development with PSR-4 autoloading
- Tailwind CSS integration
- Modern build tools with Laravel Mix and Webpack
- Organized MVC-like structure
- Built-in development tools and configurations
- Browser sync for development
- SASS/SCSS support
- PostCSS processing

## 📁 Project Structure

```
apollo/
├── .dev/                   # Development configurations
├── assets/                 # Compiled assets
├── languages/             # Translation files
├── src/                   # Source code
│   ├── Admin/            # Admin-related functionality
│   ├── Core/             # Core plugin functionality
│   └── Frontend/         # Frontend-related functionality
├── templates/             # Template files
├── apollo.php            # Main plugin file
├── composer.json         # PHP dependencies
└── package.json          # Node.js dependencies
```

## 🛠 Prerequisites

- PHP 7.4 or higher
- WordPress 5.0 or higher
- Node.js 14 or higher
- Composer

## 📥 Installation

1. Clone this repository to your WordPress plugins directory:

```bash
git clone https://github.com/yourusername/apollo.git
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
npm install
# or
yarn install
```

## 🔧 Development

### Available Scripts

- `npm run dev` or `yarn dev`: Start development with watch mode
- `npm run build` or `yarn build`: Build assets for development
- `npm run build:production` or `yarn build:production`: Build assets for production

### Development Features

- **Hot Reloading**: Browser-sync integration for live reloading
- **SASS Processing**: Write styles using SASS/SCSS
- **Tailwind CSS**: Utility-first CSS framework integration
- **PostCSS Processing**: Advanced CSS processing with features like nesting
- **Asset Optimization**: Production builds are automatically optimized

## 🏗 Architecture

The plugin follows a modular architecture with clear separation of concerns:

- **Admin**: Contains admin-specific functionality
- **Core**: Houses the core plugin logic and initialization
- **Frontend**: Manages frontend-related features

## 🔌 Plugin Structure

- **Initialization**: The plugin uses the `Apollo\Core\Init` class for bootstrapping
- **Activation/Deactivation**: Handled by dedicated classes in the Core namespace
- **Internationalization**: Support for translations via WordPress i18n

## 🛡 Security

- Direct file access is prevented
- WordPress security best practices are followed
- Proper sanitization and escaping methods are implemented

## 🔄 Build Process

The build process is handled by Laravel Mix and includes:

- SASS/SCSS compilation
- PostCSS processing
- Tailwind CSS processing
- JavaScript bundling and optimization
- Asset versioning
- Production optimization

## 📦 Dependencies

### PHP Dependencies

Managed through Composer with PSR-4 autoloading.

### Frontend Dependencies

- Tailwind CSS
- PostCSS
- Laravel Mix
- Various development tools (see package.json)

## 📘 Getting Started Guide

### Creating Your First Plugin

After installing Apollo, here's how to start building your plugin:

### 1. Basic Plugin Setup

First, update your plugin information in `apollo.php`:

```php
/**
 * Plugin Name:       Your Plugin Name
 * Plugin URI:        https://yoursite.com
 * Description:       Your plugin description
 * Version:           1.0.0
 * Author:            Your Name
 * Author URI:        https://yoursite.com
 * License:           GPL-2.0+
 * Text Domain:       your-plugin
 */

// Define plugin constants
define('APOLLO_NAME', 'your-plugin');
define('APOLLO_VERSION', '1.0.0');
define('APOLLO_FILE', __FILE__);
define('APOLLO_PLUGIN_DIR', trailingslashit(dirname(APOLLO_FILE)));
define('APOLLO_PLUGIN_URL', trailingslashit(plugin_dir_url(APOLLO_FILE)));
define('APOLLO_PLUGIN_BASE', plugin_basename(APOLLO_FILE));
```

### 2. Frontend Initialization

Create your frontend initialization in `src/Frontend/Init.php`:

```php
namespace Apollo\Frontend;

class Init {
    private $plugin_name;
    private $version;
    private static $_instance = null;

    public function __construct() {
        $this->setPluginDetails();
        $this->loadStylesAndScripts();
    }

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
    }

    private function setPluginDetails() {
        $this->version = defined('APOLLO_VERSION') ? APOLLO_VERSION : '1.0.0';
        $this->plugin_name = defined('APOLLO_NAME') ? APOLLO_NAME : 'apollo';
    }

    private function loadStylesAndScripts() {
        add_action('wp_enqueue_scripts', array($this, 'styles'));
        add_action('wp_enqueue_scripts', array($this, 'scripts'));
    }

    public function styles() {
        wp_enqueue_style(
            $this->plugin_name,
            APOLLO_PLUGIN_URL . 'dist/css/public.css',
            array(),
            $this->version,
            'all'
        );
    }

    public function scripts() {
        wp_enqueue_script(
            $this->plugin_name,
            APOLLO_PLUGIN_URL . 'dist/js/public.js',
            array(),
            $this->version,
            true
        );
    }
}
```

### 3. Admin Initialization

Create your admin initialization in `src/Admin/Init.php`:

```php
namespace Apollo\Admin;

use Apollo\Core\Helpers;

class Init {
    private $plugin_name;
    private $version;
    private static $_instance = null;

    public function __construct() {
        $this->initializePlugin();
        $this->setupAdminActions();
    }

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
    }

    private function initializePlugin() {
        $this->version = defined('APOLLO_VERSION') ? APOLLO_VERSION : '1.0.0';
        $this->plugin_name = defined('APOLLO_NAME') ? APOLLO_NAME : 'apollo';
    }

    private function setupAdminActions() {
        add_action('admin_menu', [$this, 'addPluginAdminMenu']);
        add_filter('plugin_action_links_' . APOLLO_PLUGIN_BASE, [$this, 'addActionLinks']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueStyles']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    public function enqueueStyles() {
        if (!$this->isPluginAdmin()) {
            return;
        }
        wp_enqueue_style(
            $this->plugin_name,
            APOLLO_PLUGIN_URL . 'dist/css/admin.css',
            [],
            $this->version,
            'all'
        );
    }

    public function enqueueScripts() {
        if (!$this->isPluginAdmin()) {
            return;
        }
        wp_enqueue_script(
            $this->plugin_name,
            APOLLO_PLUGIN_URL . 'dist/js/admin.js',
            [],
            $this->version,
            true
        );
    }

    public function isPluginAdmin() {
        return str_contains(get_current_screen()->base, 'apollo');
    }

    public function addPluginAdminMenu() {
        $this->addMenuPage('Apollo Welcome', 'apollo', 'displayPluginSetupPage');
    }

    public function addMenuPage($title, $slug, $template, $type = 'page', $sub = 'apollo', $priority = '99') {
        $menuFunction = $this->getMenuFunction($type);
        $menuFunction($title, $title, 'manage_options', $slug, [$this, $template], $priority);
    }

    private function getMenuFunction($type) {
        $menuFunctions = [
            'page' => 'add_options_page',
            'sub' => 'add_submenu_page',
            'menu' => 'add_menu_page'
        ];
        return $menuFunctions[$type] ?? 'add_menu_page';
    }

    public function displayPluginSetupPage() {
        Helpers::get_template('settings', 'admin');
    }
}
```

### 4. Using Tailwind CSS

Create your styles in `src/Frontend/Static/scss/public.s.scss` for Frontend styles and `src/Admin/Static/scss/admin.s.scss` for Admin styles:

```scss
@tailwind base;
@tailwind components;
@tailwind utilities;

// Your custom styles here
@layer components {
	.apollo-button {
		@apply px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors;
	}
}
```

### 5. Creating Templates

Create your admin template in `templates/admin/settings.php`:

```php
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="apollo-admin-card">
        <form method="post" action="options.php">
            <?php
                settings_fields('apollo_settings');
                do_settings_sections('apollo_settings');
                submit_button();
            ?>
        </form>
    </div>
</div>
```

### 6. Development Workflow

Start the development server with hot reloading:

```bash
# Install dependencies
composer install
yarn install

# Start development mode
yarn dev

# Build for production
yarn build:production
```

Remember to:

- Follow the singleton pattern used in Init classes
- Use proper namespacing as shown in the examples
- Leverage the built-in template system with `Helpers::get_template()`
- Keep scripts and styles in the appropriate `assets` directory
- Use the provided constants for plugin paths and URLs

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## 📄 License

This project is licensed under the GPL-2.0+ License - see the LICENSE file for details.

---

Brought to you by [MatterWP](https://matterwp.com).
