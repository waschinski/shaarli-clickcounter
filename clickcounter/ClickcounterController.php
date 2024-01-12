<?php

declare(strict_types=1);

namespace Shaarli\Plugin\Clickcounter;

use Shaarli\Front\Controller\Admin\ShaarliAdminController;
use Slim\Http\Request;
use Slim\Http\Response;
use Shaarli\Helper\FileUtils;

class ClickcounterController extends ShaarliAdminController
{
    /**
     * GET /plugin/clickcounter/:id
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        if (!array_key_exists('id', $args) || !$this->container->bookmarkService->exists((int) $args['id'])) {
            $this->saveErrorMessage('Invalid ID provided.');
            return $this->redirectFromReferer($request, $response, ['clickcounter']);
        }

        $clickData = FileUtils::readFlatDB($this->container->conf->get('resource.data_dir') . '/clickcounter.php', []);
        if (!array_key_exists($args['id'], $clickData)) {
            $clickData[$args['id']] = 1;
        }
        else {
            $clickData[$args['id']]++;
        }
        FileUtils::writeFlatDB($this->container->conf->get('resource.data_dir') . '/clickcounter.php', $clickData);

        $bookmark = $this->container->bookmarkService->get((int) $args['id']);
        return $response->withRedirect($bookmark->getUrl());
    }
}
