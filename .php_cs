<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->exclude('build/artifacts')
    ->exclude('vendor')
;

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        '-psr0',
        'symfony',
        'long_array_syntax',
        '-phpdoc_separation',
        'strict',
        'short_echo_tag',
        'phpdoc_order',
        'php_unit_strict',
        'php_unit_construct',
        'php4_constructor',
        'ordered_use',
        'newline_after_open_tag',
    ))
    ->finder($finder)
    ;