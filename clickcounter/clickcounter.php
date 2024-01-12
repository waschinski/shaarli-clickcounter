<?php

/**
 * Shaarli clickcounter Plugin
 *
 * @author Andreas Waschinski
 * @link 
 */

require_once __DIR__ . '/ClickcounterController.php';

use Shaarli\Config\ConfigManager;
use Shaarli\Plugin\PluginManager;
use Shaarli\Helper\FileUtils;

function clickcounter_register_routes(): array
{
    return [
        [
	    'method' => 'GET',
	    'route' => '/{id}',
	    'callable' => 'Shaarli\Plugin\Clickcounter\ClickcounterController:index',
	],
    ];
}

function hook_clickcounter_render_linklist(array $data, ConfigManager $conf): array
{
    $clickData = FileUtils::readFlatDB($conf->get('resource.data_dir') . '/clickcounter.php', []);
    foreach ($data['links'] as &$value) {
        if (strpos($value['real_url'], 'http') === 0) {
            $value['real_url'] = $data['_BASE_PATH_'] . '/plugin/clickcounter/' . $value['id'];
        }
    if (array_key_exists($value['id'], $clickData)) {
            $value['link_plugin'][] = sprintf(
                ($clickData[$value['id']] > 1 ? t('%u clicks') : t('%u click')),
                $clickData[$value['id']]
            );
        }
    }
    return $data;
}

function hook_clickcounter_render_picwall(array $data, ConfigManager $conf): array
{
    foreach ($data['linksToDisplay'] as &$value) {
        if (strpos($value['real_url'], 'http') === 0) {
            $value['real_url'] = $data['_BASE_PATH_'] . '/plugin/clickcounter/' . $value['id'];
        }
    }
    return $data;
}

function hook_clickcounter_render_daily(array $data, ConfigManager $conf): array
{
    foreach ($data['linksToDisplay'] as &$value) {
        if (strpos($value['real_url'], 'http') === 0) {
            $value['real_url'] = $data['_BASE_PATH_'] . '/plugin/clickcounter/' . $value['id'];
        }
    }
    return $data;
}

function hook_clickcounter_delete_link(array $data, ConfigManager $conf)
{
    $clickData = FileUtils::readFlatDB($conf->get('resource.data_dir') . '/clickcounter.php', []);
    if (array_key_exists($data['id'], $clickData)) {
        unset($clickData[$data['id']]);
        FileUtils::writeFlatDB($conf->get('resource.data_dir') . '/clickcounter.php', $clickData);
    }
}

function clickcounter_dummy_translation()
{
    t('%u click');
    t('%u clicks');
}
