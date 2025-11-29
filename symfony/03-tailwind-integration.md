# Tailwind CSS Integration with Symfony Asset Mapper

If you prefer Tailwind over Bootstrap with Asset Mapper, here's the setup.

## Installation

```bash
composer require symfonycasts/tailwind-bundle
php bin/console tailwind:init
```

## Development Workflow

### Watch for changes during development:
```bash
php bin/console tailwind:build --watch
```

### Build for production:
```bash
php bin/console tailwind:build --minify
```

## Verify Configuration

### Check `assets/styles/app.css` contains:

```css
@import "tailwindcss";
```

### Ensure `base.html.twig` includes:

```twig
<head>
    <!-- ... -->
    {% block javascripts %}
        {% block importmap %}{{ importmap('app') }}{% endblock %}
    {% endblock %}
    <!-- ... -->
</head>
```

## Test Page

```twig
{% extends 'base.html.twig' %}

{% block title %}Tailwind Test{% endblock %}

{% block body %}
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-blue-600">
            Tailwind CSS is working! 🎉
        </h1>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
            Test Button
        </button>
    </div>
{% endblock %}
```

You should see a styled blue button with hover effects.

## Resources

- [Official Bundle Documentation](https://symfony.com/bundles/TailwindBundle/current/index.html)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
