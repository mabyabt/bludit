<?php defined('BLUDIT') or die('Bludit CMS.');

// ============================================================================
// Check role
// ============================================================================

if ($Login->role()!=='admin') {
	Alert::set($Language->g('You do not have sufficient permissions'));
	Redirect::page('dashboard');
}

// ============================================================================
// Functions
// ============================================================================

// ============================================================================
// Main after POST
// ============================================================================

// ============================================================================
// POST Method
// ============================================================================

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	editSettings($_POST);
	Redirect::page('settings-advanced');
}

// ============================================================================
// Main after POST
// ============================================================================
$allPages = buildAllpages($publishedPages=true, $staticPages=true, $draftPages=false, $scheduledPages=false);

// Generate $pagesByParentByKey and pagesByParent
$pagesByParent = array(PARENT=>array());
$pagesByParentByKey = array(PARENT=>array());
buildPagesByParent(true, true);

// Homepage select options
$homepageOptions = array(' '=>'- '.$L->g('Default').' -');
foreach ($allPages as $key=>$page) {
	$parentKey = $page->parentKey();
	if ($parentKey) {
		$homepageOptions[$key] = $pagesByParentByKey[PARENT][$parentKey]->title() .'->'. $page->title();
	} else {
		$homepageOptions[$key] = $page->title();
	}

	ksort($homepageOptions);
}

// Title of the page
$layout['title'] .= ' - '.$Language->g('Advanced Settings');