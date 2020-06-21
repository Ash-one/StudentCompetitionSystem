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
	// Competitions Overview
	'competitions_overview' => [
		'competitions/overview/*',
		['controller' => 'Competitions', 'action' => 'search']
	],
	// Competitions Info
	'competitions_info' => [
		'competitions/info/*',
		['controller' => 'Competitions', 'action' => 'getInfo']
	],

	// Students Overview
	'students_overview' => [
		'students/overview/*',
		['controller' => 'Students', 'action' => 'search']
	],
	// Students Info
	'students_info' => [
		'students/info/*',
		['controller' => 'Students', 'action' => 'getInfo']
	],
	// Students Detail
	'students_detail' => [
		'students/detail/*',
		['controller' => 'Students', 'action' => 'getDetail']
	],

	// Schools Overview
	'schools_overview' => [
		'schools/overview/*',
		['controller' => 'Schools', 'action' => 'search']
	],
	// Schools Info
	'schools_info' => [
		'schools/info/*',
		['controller' => 'Schools', 'action' => 'getInfo']
	],
	// Schools Detail
	'schools_detail' => [
		'schools/detail/*',
		['controller' => 'Schools', 'action' => 'getDetail']
	],

	// Platform Overview
	'platform_overview' => [
		'platform/overview/*',
		['controller' => 'Platform', 'action' => 'search']
	]
];
