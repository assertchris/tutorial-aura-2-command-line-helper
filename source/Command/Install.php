<?php

namespace Formativ\Dot\Command;

use Aura\Cli\Context;
use Aura\Cli\Stdio;
use Formativ\Dot\CommandInterface;

class Install
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
      "install - Installs this command-line helper."
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

    $dir = dirname(dirname(__DIR__));

    $source = $dir . "/dot";
    $target = "/usr/local/bin/dot";

    $command = "ln -s %s %s";

    $this->stdio->outln("Installing...");

    shell_exec(
      sprintf($command, $source, $target)
    );

    shell_exec("chmod +x " . $target);

    $this->stdio->outln("Installed.");

    return $this;
  }
}