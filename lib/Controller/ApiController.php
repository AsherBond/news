<?php
/**
 * Nextcloud - News
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author    Alessandro Cosentino <cosenal@gmail.com>
 * @author    Bernhard Posselt <dev@bernhard-posselt.com>
 * @author    David Guillot <david@guillot.me>
 * @author    Paul Tirk <paultirk@paultirk.com>
 * @copyright 2012 Alessandro Cosentino
 * @copyright 2012-2014 Bernhard Posselt
 * @copyright 2018 David Guillot
 * @copyright 2020 Paul Tirk
 */

namespace OCA\News\Controller;

use OCA\News\AppInfo\Application;
use OCA\News\Controller\Exceptions\NotLoggedInException;
use \OCP\IUser;
use \OCP\IRequest;
use \OCP\IUserSession;
use \OCP\AppFramework\ApiController as BaseApiController;
use OCP\AppFramework\Http\Attribute\CORS;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\PublicPage;

/**
 * Class ApiController
 *
 * @package OCA\News\Controller
 */
class ApiController extends BaseApiController
{
    /**
     * ApiController constructor.
     *
     * Stores the user session to be able to leverage the user in further methods
     *
     * @param IRequest          $request        The request
     * @param IUserSession|null $userSession    The user session
     */
    public function __construct(IRequest $request, private ?IUserSession $userSession)
    {
        parent::__construct(Application::NAME, $request);
    }

    /**
     * @return IUser|null
     */
    protected function getUser(): ?IUser
    {
        if ($this->userSession === null) {
            throw new NotLoggedInException();
        }

        return $this->userSession->getUser();
    }

    /**
     * @return string
     */
    protected function getUserId()
    {
        return $this->getUser()->getUID();
    }

    /**
     * Indication of the API levels
     *
     * @return array<string, string[]>
     */
    #[CORS]
    #[NoCSRFRequired]
    #[PublicPage]
    public function index(): array
    {
        return [
            'apiLevels' => ['v1-2', 'v1-3', 'v2']
        ];
    }
}
