<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS2.0' => true,
        '@PHP80Migration' => true,
        'octal_notation' => false,
        'single_line_empty_body' => false,
        'function_declaration' => ['closure_fn_spacing' => 'one'],
    ])
    ->setFinder($finder);
