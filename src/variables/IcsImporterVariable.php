<?php
/**
 * ICS importer plugin for Craft CMS 3.x
 *
 * Imports ICS calendar feeds that can be used in your templates.
 *
 * @link      https://includable.com/
 * @copyright Copyright (c) 2018 Includable
 */

namespace includable\icsimporter\variables;

use DateTime;
use DateTimeZone;

use includable\icsimporter\lib\ICal;

/**
 * ICS importer Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.icsImporter }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Includable
 * @package   IcsImporter
 * @since     1.0.0
 */
class IcsImporterVariable
{

    // Public Methods
    // =========================================================================

    private function processFieldValue($str)
    {
        $str = str_replace('\n', "\n", $str);
        $str = str_replace('\,', ",", $str);

        return $str;
    }

    public function feed($params)
    {
        if(empty($params) || !isset($params['url'])) {
            throw new \Exception('Feed parameters should at least contain a URL.');
        }

        $filename = '/tmp/ical-x-' . sha1($params['url']) . '.phps';
        $cache = (int)(isset($params['cache']) ? $params['cache'] : 0);
        if($cache && @filemtime($filename) > time() - $cache) {
            $items = unserialize(file_get_contents($filename));
        } else {
            $ical = new ICal($params['url']);
            $items = $ical->cal['VEVENT'];
            if($cache) {
                file_put_contents($filename, serialize($items));
            }
        }

        $result = [];
        $tz = new DateTimeZone('UTC');
        foreach($items as $item) {
            $start = $item['DTSTART'];
            if(strlen($start) == 8) {
                $start .= 'T000000Z';
            }

            $end = $item['DTEND'];
            if(strlen($end) == 8) {
                $end .= 'T000000Z';
            }

            $url = !empty($item['URL']) ? $item['URL'] : '';
            $description = !empty($item['DESCRIPTION']) ? $item['DESCRIPTION'] : '';
            $location = !empty($item['LOCATION']) ? $item['LOCATION'] : '';
            $summary = !empty($item['SUMMARY']) ? $item['SUMMARY'] : '';
            $uid = !empty($item['UID']) ? strtolower($item['UID']) : uuid();

            $item_orig = [];
            foreach($item as $item_key => $item_value) {
                $item_orig[strtolower($item_key)] = $item_value;
            }

            $result[] = [
                'id' => $uid,
                'start' => new DateTime($start, $tz),
                'end' => new DateTime($end, $tz),
                'title' => $this->processFieldValue($summary),
                'url' => $this->processFieldValue($url),
                'description' => $this->processFieldValue($description),
                'location' => $this->processFieldValue($location),
                'event' => $item_orig
            ];
        }

        return $result;
    }
}
