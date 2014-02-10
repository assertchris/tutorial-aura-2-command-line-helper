<?php

namespace Formativ\Dot;

interface CommandInterface
{
  public function help();
  public function attach();
  public function handle();
}