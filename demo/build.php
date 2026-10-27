<?php
// Assemble the static demo site: page + a JSON bundle of src/ and vendor/ for the php-wasm virtual FS.
$out = rtrim(isset($argv[1]) ? $argv[1] : '_site', '/');
$root = dirname(__DIR__);

@mkdir($out, 0777, true);
foreach (array('index.html', 'run.php', 'products.csv') as $file) {
    copy(__DIR__ . '/' . $file, $out . '/' . $file);
}
file_put_contents($out . '/.nojekyll', '');

$files = array();
foreach (array('src', 'vendor') as $dir) {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root/$dir", FilesystemIterator::SKIP_DOTS));
    foreach ($it as $file) {
        $path = substr($file->getPathname(), strlen($root) + 1);
        $isPhp = substr($path, -4) === '.php' || $path === 'vendor/composer/installed.json';
        if ($file->isFile() && $isPhp && !preg_match('#^vendor/.+/(tests?|docs?|bin)/#i', $path)) {
            $files[$path] = file_get_contents($file->getPathname());
        }
    }
}
ksort($files);
file_put_contents($out . '/bundle.json', json_encode($files));
printf("Bundled %d files\n", count($files));
