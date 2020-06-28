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
	// Login
	'Login' => [
		'login',
		['controller' => 'Account', 'action' => 'login']
	],
	// Alter
	'Alter' => [
		'alter',
		['controller' => 'Account', 'action' => 'alter']
	],
	// Competitions Overview
	'competitions_overview' => [
		'competitions/overview',
		['controller' => 'Competitions', 'action' => 'getOverview']
	],
	// Competitions Info
	'competitions_info' => [
		'competitions/info/*',
		['controller' => 'Competitions', 'action' => 'getInfo']
	],
	// Competitions Detail
	'competitions_detail' => [
		'competitions/detail/*',
		['controller' => 'Competitions', 'action' => 'getDetail']
	],
	// Competitions ContestantOverview
	'competitions_contestantOverview' => [
		'competitions/contestant/*',
		['controller' => 'Competitions', 'action' => 'getContestantOverview']
	],

	// upload Excel
	'upload_Excel' => [
		'upload',
		['controller' => 'Competitions', 'action' => 'uploadExcelData']
	],

	// Students Overview
	'students_overview' => [
		'students/overview',
		['controller' => 'Students', 'action' => 'getOverview']
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
		'schools/overview',
		['controller' => 'Schools', 'action' => 'getOverview']
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
		'platform/overview',
		['controller' => 'Platform', 'action' => 'getOverview']
	]
];
