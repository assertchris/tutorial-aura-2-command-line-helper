<?php

namespace Formativ\Dot\Command;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Formativ\Dot\CommandInterface;

class Stage
implements CommandInterface
{
  protected $context;

  protected $stdio;

  protected $getopt;

  public function __construct(Context $context, Stdio $stdio)
  {
    $this->context = $context;
    $this->stdio   = $stdio;
  }

  public function help()
  {
    $this->stdio->outln(
      "stage - Stages files in the current repository."
    );

    return $this;
  }

  public function attach()
  {
    $this->getopt = $this->context->getopt([
      "h,help"
    ]);

    return $this;
  }

  public function handle()
  {
    if ($this->getopt->get("-h")) {
      return $this->help();
    }

    $this->stdio->outln("Staging files...");
    shell_exec("git add -A");

    $this->stdio->outln("Staged.");

    return $this;
  }
}