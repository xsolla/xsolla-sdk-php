<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->exclude('build/artifacts')
    ->exclude('vendor')
;

return Symfony\CS\Config\Config::create()
    ->fixers(array('-psr0', 'symfony', 'long_array_syntax', '-phpdoc_separation'))
    ->finder($finder)
    ;