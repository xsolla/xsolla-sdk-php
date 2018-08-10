<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('build/artifacts')
    ->exclude('vendor')
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'phpdoc_separation' => false,
        'strict_comparison' => true,
        'phpdoc_order' => true,
        'php_unit_strict' => true,
        'php_unit_construct' => true,
        'no_php4_constructor' => true,
        'ordered_imports' => true,
        'no_short_echo_tag' => true,
    ])
    ->setFinder($finder)
    ;