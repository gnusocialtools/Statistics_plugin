# Statistics plugin for GNU Social

This plugin collects some statistics and prints them. These stats will be collected:

* Instance name, address, version, SSL mode.
* Is twitter plugin enabled and is twitterbridge is active.
* Local users list with full names.
* Local groups list.
* Enabled plugins

Plugin has no additional dependencies.

# Installation

Copy ``Statistics`` directory to ``$GNUSOCIAL_ROOT/plugins`` and activate it in config.php:

```php
addPlugin("Statistics");
```

To check for proper plugin installation, go to http://your_instance_address/main/statistics. If everything is ok - you will see JSON output.

# What this for?

This plugin is a **requirement** if you want to be listed on http://gstools.org/, because there is no possibility to get required data without this plugin.

On gstools.org side, there is a special script, which will fetch data, provided with this plugin. All data will be accessible thru web interface with searching abilities.
