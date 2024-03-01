<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

// https://cs.symfony.com/doc/rules/
// https://cs.symfony.com/doc/ruleSets/
return (new Config())
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__ . '/.build/php-cs-fixer.cache.json')
    ->setFinder(
        (new Finder())
            ->append((new Finder())->in(__DIR__))
            ->append((new Finder())->in(__DIR__)->depth('< 1')->ignoreDotFiles(false)),
    )
    ->setRules([
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP81Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'increment_style' => ['style' => 'post'],
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'not_operator_with_successor_space' => true,
        'single_line_comment_style' => [
            'comment_types' => ['hash'],
        ],
        'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => null,
        ],
        // Environment not ready to use short functions.
        'use_arrow_functions' => false,
        'phpdoc_align' => ['align' => 'left'],
        // Make function invocation consistent, require all to be with leading `\`.
        'native_function_invocation' => ['include' => ['@all'], 'scope' => 'namespaced', 'strict' => true],
        'global_namespace_import' => ['import_classes' => true, 'import_functions' => true, 'import_constants' => true],
        // Force PSR-12 standard.
        'ordered_imports' => ['sort_algorithm' => 'alpha', 'imports_order' => ['class', 'function', 'const']],
        'blank_line_before_statement' => ['statements' => ['declare', 'include', 'include_once', 'require', 'require_once', 'return']],
        'php_unit_test_annotation' => ['style' => 'annotation'],
        'nullable_type_declaration_for_default_null_value' => true,
        'no_null_property_initialization' => false,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'nullable_type_declaration' => ['syntax' => 'union'],
    ]);
