<?php

namespace Formativ\Dot\Command;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Formativ\Dot\CommandInterface;

class Commit
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
      "commit - Commits files in the current repository."
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

    $message = $this->getopt->get(2);

    if ($message == null) {
      $this->stdio->outln("Message required.");
      return;
    }

    $message = addslashes($message);

    $this->stdio->outln("Committing files...");
    shell_exec("git commit -a -m '" . $message . "'");

    $this->stdio->outln("Committed.");

    return $this;
  }
}