<?php

namespace Formativ\Dot\Command;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Formativ\Dot\CommandInterface;

class Push
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
      "push - Pushes the latest files to a remote branch."
    );

    return $this;
  }

  public function attach()
  {
    $this->getopt = $this->context->getopt([
      "h,help",
      "remote",
      "branch",
      "f,force",
      "u,upstream"
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

    $force = "";

    if ($this->getopt->get("force")) {
      $force = "-f";
    }

    $upstream = "";

    if ($this->getopt->get("upstream")) {
      $upstream = "-u";
    }

    $this->stdio->outln("Pushing files...");

    $command = "git push %s %s %s %s";

    shell_exec(
      sprintf($command, $remote, $branch, $force, $upstream)
    );

    $this->stdio->outln("Pushed.");

    return $this;
  }
}