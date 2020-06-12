<?php
/**
 * yaf 路由同统一配置
 * 自定义路由 按以下格式配置
 * 'name' => [
 *      'match',
 *		['module' => 'model name', 'controller' => 'controller name', 'action' => 'action name'],
 * ]
 *
 */

return [
	'index' => [
		'/:name',
		['controller' => 'Index', 'action' => 'index']
	],
];
