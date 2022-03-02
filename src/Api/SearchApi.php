<?php

namespace App\Api;

use App\Api\Services\Base\AbstractApiController;
use App\Api\Services\Search\SearchApiFacade;
use OpenAPI\Server\Api\SearchApiInterface;

final class SearchApi extends AbstractApiController implements SearchApiInterface
{
  private SearchApiFacade $facade;

  public function __construct(SearchApiFacade $facade)
  {
    $this->facade = $facade;
  }

  /**
   * {@inheritDoc}
   */
  public function searchGet(string $query, ?string $type = 'all', ?int $limit = 20, ?int $offset = 0, &$responseCode = null, array &$responseHeaders = null)
  {
    $type = $type ?? 'all';
    $limit = $this->getDefaultLimitOnNull($limit);
    $offset = $this->getDefaultOffsetOnNull($offset);

    if ('' === $query || ctype_space($query)) {
      return [];
    }

    switch ($type) {
          case 'projects':
              $projects = $this->facade->getProgramManager()->search($query, $limit, $offset);
              $projects_total = $this->facade->getProgramManager()->searchCount($query);

              $result = $this->facade->getResponseManager()->getProjectsSearchResponse($projects, $projects_total);
              break;
          case 'users':
              $users = $this->facade->getUserManager()->search($query, $limit, $offset);
              $users_total = $this->facade->getUserManager()->searchCount($query);
              $result = $this->facade->getResponseManager()->getUsersSearchResponse($users, $users_total);
              break;
          case 'all':
          default:
              $projects = $this->facade->getProgramManager()->search($query, $limit, $offset);
              $projects_total = $this->facade->getProgramManager()->searchCount($query);
              $projects_response = $this->facade->getResponseManager()->getProjectsSearchResponse($projects, $projects_total);

              $users = $this->facade->getUserManager()->search($query, $limit, $offset);
              $users_total = $this->facade->getUserManager()->searchCount($query);
              $users_response = $this->facade->getResponseManager()->getUsersSearchResponse($users, $users_total);

              $result = $this->facade->getResponseManager()->getSearchResponse($projects_response, $users_response);
              break;
      }

    $responseHeaders['X-Response-Hash'] = md5(json_encode($result));

    return $result;
  }
}
