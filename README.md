# shaarli-clickcounter
A [Shaarli](https://github.com/shaarli/Shaarli) plugin that will count how often your links have been clicked.

The count for each link will be displayed in the `link_plugin` section (usually between the permalink and link URL) depending on the template in use and how it has implemented the `link_plugin` section. So it should basically work with all templates (tested with [Stack](https://github.com/RolandTi/shaarli-stack)).

A demo can be found on https://metaref.link.

## Installation
1. Place the folder (`clickcounter`) in the `plugins/` folder of your Shaarli installation.
1. Enable the plugin in the Plugin Administration page.

## Backup
The clickcounter data resides in the `data` folder of your Shaari installation in a file called `clickcounter.php` so your data should be contained in your regular Shaari backup.

See [Backup & Restore](https://shaarli.readthedocs.io/en/master/Backup-and-restore.html) in the Shaari documentation for details.

## Reset
If you would like to reset the click counters simply delete the `clickcounter.php` file from the `data` folder of your Shaari installation.
