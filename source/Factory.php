<?php

namespace Formativ\Dot;

use Aura\Cli\Context;
use Aura\Cli\Stdio;

class Factory
{
  protected $context;

  protected $stdio;

  protected $commands = [];

  protected function addCommand($alias, $class)
  {
    $this->commands[$alias] = $class;
    return $this;
  }

  public function __construct(Context $context, Stdio $stdio)
  {
    $this->context = $context;
    $this->stdio   = $stdio;

    $this->addCommand(
      "update",
      "Formativ\Dot\Command\Update"
    );

    $this->addCommand(
      "pull",
      "Formativ\Dot\Command\Pull"
    );

    $this->addCommand(
      "stage",
      "Formativ\Dot\Command\Stage"
    );

    $this->addCommand(
      "commit",
      "Formativ\Dot\Command\Commit"
    );

    $this->addCommand(
      "push",
      "Formativ\Dot\Command\Push"
    );

    $this->addCommand(
      "install",
      "Formativ\Dot\Command\Install"
    );
  }

  public function create()
  {
    $getopt  = $this->context->getopt([]);
    $command = $getopt->get(1);

    if (isset($this->commands[$command])) {
      $class = $this->commands[$command];
      return new $class($this->context, $this->stdio);
    }

    $this->stdio->outln("Available commands:");

    foreach ($this->commands as $key => $value) {
      $instance = new $value($this->context, $this->stdio);
      $instance->help();
    }

    return null;
  }
}