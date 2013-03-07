<?php
$root = "../downloads/";
$file = "";
$folder = "";

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

if (isset($_GET["folder"])) {
	$folder = stripParentDirectories($_GET["folder"]);
}
if (isset($_GET["file"])) {
	$file = basename($_GET["file"]);
}

if (!empty($file)) {
	$path = $root . $folder;
	if (substr($path, -1) !== '/') {
		$path .= "/";
	}
	pumpDownload($path . $file);
} else {
	listDirectory($root . $folder, empty($folder), $folder);
}

function stripParentDirectories($path) {
	$newPath = "";
	$parts = explode("/", $path);
	foreach ($parts as $folder) {
		if ($folder !== "..") {
			if (empty($newPath)) {
				$newPath = $folder;
			} else {
				$newPath .= "/" . $folder;
			}
		}
	}
	return $newPath;
}

function pumpDownload($path) {
	if (is_readable($path) && is_file($path)) {
		if (strstr($path, "/private/")) {
			header('HTTP/1.0 404 Not Found'); 
			echo "File not found!";
			exit;
		}
		$mime = mime_content_type($path);
		header("Content-Description: File Transfer");
		header("Content-Type: $mime");
		header("Content-Disposition: attachment; filename=".basename($path));
		header("Content-Transfer-Encoding: binary");
		header("Expires: 0");
		header("Cache-Control: must-revalidate");
		header("Pragma: public");
		header("Content-Length: " . filesize($path));
		ob_clean();
		flush();
		readfile($path);
		exit;
	} else {
		header('HTTP/1.0 404 Not Found'); 
		echo "File not found!";
		exit;
	}
}

function listDirectory($path, $isRootDir, $relativePath) {
	if (is_dir($path) && is_readable($path)) {
		if (strstr($path, "/private/")) {
			header('HTTP/1.0 404 Not Found'); 
			echo "Path not found!";
			exit;
		}
		$output = new stdClass();
		$output->directory = array();
		$output->rootDir = $isRootDir;
		$output->path = $relativePath;
		if (empty($relativePath)) {
			$parent = false;
		} else {
			$pos = strrpos($relativePath, "/");
			if (!$pos) {
				$parent = "";
			} else {
				$parent = substr($relativePath, 0, strrpos($relativePath, "/"));
			}
		}
		$output->parent = $parent;
		$dir = opendir($path);
		if (substr($path, -1) !== "/") {
			$path .= "/";
		}
		while($file = readdir($dir)) {
			if ($file === ".." || $file === ".") continue;
			$baseName = basename($file);
			if ($baseName == "private") continue;
			$entry = array();
			$entry["isFile"] = is_file($path . $file);
			$entry["name"] = $baseName;
			$output->directory[] = $entry;
		}
		closedir($dir);
		header("Content-Type: application/json");
		echo json_encode($output);
		exit;
	} else {
		header('HTTP/1.0 404 Not Found'); 
		echo "Path not found!";
		exit;
	}
}