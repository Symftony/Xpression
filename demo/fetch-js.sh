#!/bin/sh
# Download the pinned php-wasm npm packages into <out>/lib so the demo is standalone (no CDN at runtime).
# Usage: demo/fetch-js.sh [out-dir]
set -eu

OUT="${1:-_site}/lib"
VERSION=0.2.0
PHP=8.4
SHA512_PHP_WASM=c080f56be46ec88960938d7816804a339cfd519d2c0f8825f0bbb87eacb72bb77a91d6617e20bdbb5fecdf1268e48b3c79b8f754b882572a7d20dc997202eea0
SHA512_PHP_WASM_SQLITE=f34b9393b39f63a904ffed1a4a3a07b31d947313252255fd6804d9b1db38766e34026c7a426ba1b3354ae71875684a91119600d8322ea66b56d5ef83d27c73e9

fetch() { # <package> <sha512>
    tmp="$(mktemp -d)"
    curl -fsSL "https://registry.npmjs.org/$1/-/$1-$VERSION.tgz" -o "$tmp/pkg.tgz"
    echo "$2  $tmp/pkg.tgz" | sha512sum -c - >/dev/null
    mkdir -p "$OUT/$1"
    tar -xzf "$tmp/pkg.tgz" -C "$OUT/$1" --strip-components=1
    rm -rf "$tmp"
}

rm -rf "$OUT"
fetch php-wasm "$SHA512_PHP_WASM"
fetch php-wasm-sqlite "$SHA512_PHP_WASM_SQLITE"

# Keep only what the browser needs for one PHP version.
cd "$OUT/php-wasm"
keep="$(grep -o '[0-9a-f]\{40\}\.wasm' "php$PHP-web.mjs" | sort -u)"
for f in *.wasm; do
    case "$keep" in *"$f"*) ;; *) rm -f "$f" ;; esac
done
for f in php[0-9]*; do
    case "$f" in "php$PHP-web.mjs") ;; *) rm -f "$f" ;; esac
done
rm -f *.js *.cts *.d.mts *.d.ts php-tags* PhpNode.mjs PhpWebview.mjs PhpWorker.mjs

cd "../php-wasm-sqlite"
for f in php[0-9]*.so; do
    case "$f" in php$PHP-*) ;; *) rm -f "$f" ;; esac
done
rm -rf test *.d.ts static.mak
