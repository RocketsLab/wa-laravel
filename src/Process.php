<?php

namespace RocketsLab\WALaravel;

class Process
{
    public static function run(string $command, \Closure $callback, string $cwd = null)
    {
        $cwd = $cwd ?? realpath('./');

        $descriptorspec = array(
            0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
            2 => array("pipe", "w")    // stderr is a pipe that the child will write to
        );

        flush();
        $process = proc_open($command, $descriptorspec, $pipes, $cwd, array());
        if (is_resource($process)) {
            while ($s = fgets($pipes[1])) {
                $callback($s);
                flush();
                sleep(0.5);
            }
        }
    }
}
