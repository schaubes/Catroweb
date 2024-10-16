<?php

declare(strict_types=1);

namespace App\Api\Services\MediaLibrary;

use App\Api\Services\AuthenticationManager;
use App\Api\Services\Base\AbstractApiFacade;

class MediaLibraryApiFacade extends AbstractApiFacade
{
  public function __construct(
    AuthenticationManager $authentication_manager,
    private readonly MediaLibraryResponseManager $response_manager,
    private readonly MediaLibraryApiLoader $loader,
    private readonly MediaLibraryApiProcessor $processor,
    private readonly MediaLibraryRequestValidator $request_validator)
  {
    parent::__construct($authentication_manager);
  }

  #[\Override]
  public function getResponseManager(): MediaLibraryResponseManager
  {
    return $this->response_manager;
  }

  #[\Override]
  public function getLoader(): MediaLibraryApiLoader
  {
    return $this->loader;
  }

  #[\Override]
  public function getProcessor(): MediaLibraryApiProcessor
  {
    return $this->processor;
  }

  #[\Override]
  public function getRequestValidator(): MediaLibraryRequestValidator
  {
    return $this->request_validator;
  }
}
