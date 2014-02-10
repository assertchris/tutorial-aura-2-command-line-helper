<?php

namespace Formativ\Dot\Command;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Formativ\Dot\CommandInterface;

class Pull
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
      "pull - Pulls the latest files from a remote branch."
    );

    return $this;
  }

  public function attach()
  {
    $this->getopt = $this->context->getopt([
      "h,help",
      "remote",
      "branch"
    ]);

    return $this;
  }

  public function handle()
  {
    if ($this->getopt->get("-h")) {
      return $this->help();
    }

    $remote = $this->getopt->get("remote", "origin");
    $branch = $this->getopt->get("remote", "master");

    $command = "git pull %s %s";

    $this->stdio->outln("Pulling files...");

    shell_exec(
      sprintf($command, $remote, $branch)
    );

    $this->stdio->outln("Pulled.");

    return $this;
  }
}