<?php
/**
 * Nextcloud - HtmlWidget
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Julien Veyssier <eneiluj@posteo.net>
 * @copyright Julien Veyssier 2020
 */

namespace OCA\HtmlWidget\Controller;

use OCP\Files\IAppData;
use OCP\AppFramework\Http\DataDisplayResponse;

use OCP\IConfig;
use OCP\IServerContainer;
use OCP\IL10N;
use Psr\Log\LoggerInterface;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\RedirectResponse;

use OCP\Files\IRootFolder;
use OCP\IUserManager;
use OCP\Files\FileInfo;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\HtmlWidget\AppInfo\Application;

class ConfigController extends Controller {

	private $userId;
	private $config;
	private $dbtype;

	public function __construct($AppName,
								IRequest $request,
								IServerContainer $serverContainer,
								IConfig $config,
								IAppData $appData,
								IL10N $l,
								IRootFolder $root,
								IUserManager $userManager,
								LoggerInterface $logger,
								?string $userId) {
		parent::__construct($AppName, $request);
		$this->l = $l;
		$this->userId = $userId;
		$this->appData = $appData;
		$this->serverContainer = $serverContainer;
		$this->config = $config;
		$this->logger = $logger;
		$this->root = $root;
		$this->userManager = $userManager;
	}

	/**
	 * set admin config values
	 *
	 * @param array $values
	 * @return DataResponse
	 */
	public function setAdminConfig(array $values): DataResponse {
		foreach ($values as $key => $value) {
			$this->config->setAppValue(Application::APP_ID, $key, $value);
		}
		return new DataResponse(1);
	}

	/**
	 * @NoAdminRequired
	 */
	public function getWidgetContent(): DataResponse {
		$widgetTitle = $this->config->getAppValue(Application::APP_ID, 'widgetTitle', '');
		$contentHtml = $this->config->getAppValue(Application::APP_ID, 'contentHtml', '');
		return new DataResponse([
			'widgetTitle' => $widgetTitle,
			'contentHtml' => $contentHtml,
		]);
	}
}
