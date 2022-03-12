<?php

namespace App\Project\EventSubscriber;

use App\Project\Event\ProjectDownloadEvent;
use App\Project\ProgramManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProjectDownloadEventSubscriber implements EventSubscriberInterface
{
  protected ProgramManager $program_manager;

  public function __construct(ProgramManager $program_manager)
  {
    $this->program_manager = $program_manager;
  }

  public function onProjectDownload(ProjectDownloadEvent $event): void
  {
    $this->program_manager->increaseDownloads($event->getProject(), $event->getUser());
  }

  public static function getSubscribedEvents(): array
  {
    return [
      ProjectDownloadEvent::class => 'onProjectDownload',
    ];
  }
}
