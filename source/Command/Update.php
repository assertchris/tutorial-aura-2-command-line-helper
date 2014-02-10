<?php

namespace Formativ\Dot\Command;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Formativ\Dot\CommandInterface;

class Update
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
      "update - Updates installed package managers."
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

    $this->stdio->outln("Updating Homebrew...");
    shell_exec("brew update");
    shell_exec("brew upgrade");

    $this->stdio->outln("Updating Composer...");
    shell_exec("composer self-update");
    shell_exec("composer global update");

    $this->stdio->outln("Updated.");

    return $this;
  }
}