<?php
$out = [
    'flushInterval' => 1,
    'traceLevel' => YII_DEBUG ? 3 : 0,
];
if (YII_ENV_PROD) {
    $out['targets'] = [
        [
            'class' => 'jones\herokulogger\HerokuTarget',
            'levels' => ['error', 'warning', 'info'],
            'exportInterval' => 1,
            'logVars' => [],
        ],
    ];
} else {
    $out['targets'] = [
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning'],
        ],
    ];
}
return $out;
