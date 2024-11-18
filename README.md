# Apollo - Modern WordPress Plugin Boilerplate

![GitHub Release](https://img.shields.io/github/v/release/wparray/apollo?include_prereleases) ![GitHub License](https://img.shields.io/github/license/wparray/apollo) [![Codacy Badge](https://app.codacy.com/project/badge/Grade/fbcef8300f734965ab59b7ac93a28f8f)](https://app.codacy.com/gh/wparray/apollo/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade) ![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg) ![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/wparray/apollo) ![GitHub repo size](https://img.shields.io/github/repo-size/wparray/apollo)

Apollo is like a cheat code for speeding up your WordPress plugin projects. It's designed with OOP principles in mind, so your plugins will be easy to manage and expand. And it's packed with modern tools like Webpack, Tailwind, and BrowserSync to make your life even easier.

The whole point of Apollo is to be super flexible. Whether you're a PHP pro or you prefer working with JS frameworks like Vue or React, Apollo can handle it all.

But remember, it's not a one-size-fits-all solution where you can just copy and paste stuff. Think of Apollo as your starting point, giving you the boost you need to create top-notch WordPress plugins with less hassle.

## Features

- 🚀 Modern development workflow with Webpack
- 🎨 Built-in Tailwind CSS support
- 🔄 Live reload with BrowserSync
- 📦 Asset bundling and optimization
- 🏗️ OOP architecture
- ⚛️ Support for modern JS frameworks (Vue, React)
- 🛠️ Customizable build configuration

## Getting Started

### Prerequisites

- Node.js (v14 or higher)
- Composer
- Yarn
- Local WordPress installation

### 1. Install Dependencies

```bash
composer install
yarn install
```

### 2. Start Development Environment

```bash
yarn dev
```

## Development Configuration

### Build System (.dev folder)

The `.dev` folder contains all build-related configurations:

#### webpack.mix.js
- Laravel Mix configuration for asset compilation
- Handles SCSS, JavaScript, and static assets
- Configures BrowserSync for live reload
- Manages PostCSS plugins and Tailwind CSS integration

#### postcss.config.js
- PostCSS plugin configuration
- Handles CSS transformations and optimizations
- Includes plugins for:
  - CSS imports
  - Nesting support
  - Vendor prefixing
  - Media query optimization
  - Selector combination

#### tailwind.config.js
- Tailwind CSS configuration
- Defines content paths for purging
- Customizes theme settings
- Controls core plugins

#### export.sh
- Utility script for creating distributable plugin packages
- Automatically excludes development files
- Creates optimized ZIP archives for deployment

### BrowserSync Configuration

Default BrowserSync settings in `webpack.mix.js`:

```javascript
mix.browserSync({
    proxy: "http://localhost:8888",
    open: "external",
    port: 3000,
    files: ["*.php", "src/**/**/*"],
    reloadDelay: 1000
});
```

Customize these settings based on your local development environment.

## Project Structure

```
apollo/
├── .dev/               # Build configurations
├── assets/            # Compiled assets
├── src/               # Source files
│   ├── Admin/         # Admin-specific code
│   │   ├── Controllers/   # Admin controllers
│   │   └── Static/        # Admin assets (JS, CSS, images)
│   ├── Core/         # Core functionality
│   │   └── Controllers/   # Core controllers & helpers
│   └── Frontend/     # Frontend-specific code
│       └── Static/        # Frontend assets
├── templates/         # Template files
└── vendor/           # Composer dependencies
```

### Admin Directory (`src/Admin/`)
The Admin directory contains all administration-related code and assets:

- **Controllers/**: Contains admin-specific controller classes
  - `Init.php`: Main admin initialization class that handles:
    - Admin menu creation
    - Asset enqueuing
    - Plugin settings page
    - Action links

- **Static/**: Contains admin-specific assets
  - Images, icons, and fonts
  - JavaScript files
  - SCSS/CSS files

### Core Directory (`src/Core/`)
The Core directory contains the fundamental plugin functionality:

- **Controllers/**: Contains core helper classes and utilities
  - `Helpers.php`: Provides utility functions for:
    - Template loading
    - Icon handling
    - Common helper functions

### Frontend Directory (`src/Frontend/`)
The Frontend directory manages all public-facing functionality:

- **Static/**: Contains frontend assets
  - Images, icons, and fonts
  - Public JavaScript files
  - Public SCSS/CSS files

### Templates Directory (`templates/`)
Contains modular template files for both admin and frontend views:

- **admin/**: Admin-specific templates
  - `settings.php`: Plugin settings page template

The template system allows for clean separation of logic and presentation, making the code more maintainable and easier to update.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

---

Brought to you by [MatterWP](https://matterwp.com).
