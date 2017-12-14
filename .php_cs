<?php

return Symfony\CS\Config\Config::create()
    ->setUsingLinter(false)
    ->setUsingCache(true)
    ->fixers([
        /* 字符连接需要空格 */
        '-concat_without_spaces',
        'concat_with_spaces',

        /* 禁用-phpdoc需要以句号结尾 */
        '-phpdoc_short_description',
        /* 命名空间之前不需要空行 */
        // 'no_blank_lines_before_namespace',
        /* 等号对齐 */
        '-align_equals',
        /* 数组强制使用[] */
        'short_array_syntax',
    ])
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in(__DIR__)
    );