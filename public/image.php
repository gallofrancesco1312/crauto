<?php


namespace WEEEOpen\Crauto;

require '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Authentication::requireLogin();

if(isset($_GET['uid'])) {
	if(Authentication::isAdmin()) {
		$uid = $_GET['uid'];
	} else {
		http_response_code(403);
		header('Content-Type: text/plain; charset=utf-8');
		echo 'You are not an admin';
		exit;
	}
} else {
	$uid = $_SESSION['uid'];
}

$image = new Image($uid, null);

if($image->exists()) {
	$image->bumpAccessTime();
	$path = $image->getPath();
	$etag = filemtime($path) . md5($path);
	header('Content-type: image/jpeg');
	header("Etag: $etag");
	if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $etag) {
		http_response_code(304);
		exit;
	}
	header('Content-Length: ' . filesize($path));
//	if(ob_get_level() > 0) {
//		ob_end_clean();
//	}
	readfile($path);
} else {
	http_response_code(404);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'No such file';
}
