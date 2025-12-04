# Preferences Module

*anomaly.module.preferences*

#### System preferences management for the Streams Platform.

The Preferences Module provides user-specific preference management with database-backed storage and a flexible interface.

## Features

- User-specific preference storage
- Field-based preference editing
- Default value handling
- Preference scoping (per-user, per-role)
- Preference caching for performance
- Validation support
- Control panel interface
- API access to preferences

## Usage

### Accessing Preferences

#### In PHP

```php
// Get user preference
$theme = preferences('theme', 'light');

// Get current user's preference
$language = auth()->user()->getPreference('language');

// Get preference with default
$timezone = preferences('timezone', 'UTC');
```

#### In Twig

```twig
{# Get preference #}
{{ preferences('theme') }}

{# Check preference #}
{% if preferences('dark_mode') %}
    <body class="dark">
{% endif %}
```

### Setting Preferences

```php
use Anomaly\PreferencesModule\Preference\Contract\PreferenceRepositoryInterface;

$preferences = app(PreferenceRepositoryInterface::class);

// Set preference for current user
$preferences->set('theme', 'dark');

// Set multiple preferences
$preferences->set([
    'theme' => 'dark',
    'language' => 'en'
]);
```

### Defining Preferences

In your addon's `preferences/preferences.php`:

```php
return [
    'theme' => [
        'type' => 'anomaly.field_type.select',
        'config' => [
            'options' => [
                'light' => 'Light',
                'dark' => 'Dark'
            ],
            'default_value' => 'light'
        ]
    ],
    'notifications' => [
        'type' => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => true
        ]
    ]
];
```

## Requirements

- Streams Platform ^1.10
- PyroCMS 3.10+

## License

The Preferences Module is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
