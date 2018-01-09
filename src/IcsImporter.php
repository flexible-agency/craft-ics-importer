<?php
/**
 * ICS importer plugin for Craft CMS 3.x
 *
 * Imports ICS calendar feeds that can be used in your templates.
 *
 * @link      https://includable.com/
 * @copyright Copyright (c) 2018 Includable
 */

namespace includable\icsimporter;

use includable\icsimporter\variables\IcsImporterVariable;

use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
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
