<?php
/**
 * ICS importer plugin for Craft CMS 3.x
 *
 * Imports ICS calendar feeds that can be used in your templates.
 *
 * @link https://flexible.agency/
 * @copyright Copyright (c) 2020 Flxible Agency
 */

namespace includable\icsimporter;

use includable\icsimporter\variables\IcsImporterVariable;

use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * ICS importer plugin.
 *
 * @author    Includable
 * @package   IcsImporter
 * @since     1.0.0
 */
class IcsImporter extends Plugin
{

    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * IcsImporter::$plugin
     *
     * @var IcsImporter
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * IcsImporter::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('icsImporter', IcsImporterVariable::class);
            }
        );
    }

}
