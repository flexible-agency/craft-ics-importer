# ICS importer plugin for Craft CMS 3.x

Imports ICS calendar feeds that can be used in your templates.


## Requirements

This plugin requires Craft CMS 3.0.0-RC1 or later.


## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require includable/craft-ics-importer

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for ICS importer.


## Using this in your template

```twig
{% set events = craft.icsImporter.feed({
    url: 'https:/.../events.ics',
    cache: 86400
}) %}

<table border="1">
    <tr>
        <th>Title</th>
        <th>Start</th>
        <th>End</th>
        <th>Description</th>
        <th>Location</th>
        <th>URL</th>
    </tr>
{% for event in events %}
    <tr>
        <td>{{ event.title }}</td>
        <td>{{ event.start | date('d-m-Y H:i') }}</td>
        <td>{{ event.end | date('d-m-Y H:i') }}</td>
        <td>{{ event.description }}</td>
        <td>{{ event.location }}</td>
        <td>{{ event.url }}</td>
    </tr>
{% endfor %}
</table>
```


--------

Brought to you by [Includable](https://includable.com/)
