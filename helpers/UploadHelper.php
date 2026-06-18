<?php

function ensureDirectory(
    string $directory
): void
{
    if (!is_dir($directory)) {

        mkdir(
            $directory,
            0777,
            true
        );
    }
}