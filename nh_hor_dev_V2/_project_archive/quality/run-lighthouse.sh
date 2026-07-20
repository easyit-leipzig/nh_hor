#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
php -S 127.0.0.1:8080 -t "$ROOT/nh_hor" >/tmp/easyit-lighthouse-php.log 2>&1 &
PID=$!
trap 'kill $PID 2>/dev/null || true' EXIT
sleep 2
npx --yes @lhci/cli autorun --config="$ROOT/_project_archive/quality/lighthouse.config.js"
