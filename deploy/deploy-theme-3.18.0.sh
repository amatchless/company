#!/bin/bash
# Deploy Amatchless theme 3.18.0: three new clients (Khilonaa, Suman Didi, Vihan Sales).
# The client list now lives in one place, amatchless_clients() in functions.php. It feeds the home page ticker,
# the blog "Trusted by" line and the ad landing page brand strip; /work/ gets an "Also working with" row.
# Builds on 3.17.0. Run from the repo root.
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-ip6wy5
PREV=d639e29
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.18.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.18.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.18.0, stopping."; exit 1; }

# 1. Safety check: the live theme should be 3.17.0 (commit $PREV)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.17.0 (should be empty apart from ._ junk; if many differ, deploy 3.17.0 first):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
echo "== Files this deploy changes:"
git diff --stat "$PREV" HEAD -- wp-content/themes/amatchless
read -p "Continue with backup and deploy? (y/N) " ok; [ "$ok" = y ] || exit 1

# 2. Backup on the server
STAMP=$(date +%Y%m%d-%H%M%S)
ssh "$SRV" "mkdir -p ~/theme-backups && cp -a ~/$LIVE ~/theme-backups/amatchless-$STAMP"
echo "Backup: ~/theme-backups/amatchless-$STAMP"

# 3. Deploy
rsync -rlptvz --delete --exclude='.git' --exclude='._*' --exclude='.DS_Store' wp-content/themes/amatchless/ "$SRV:$LIVE/"

# 4. Clear the page cache
ssh "$SRV" "cd ~/public_html && (wp cache flush || true) && rm -rf wp-content/cache/supercache/*"

# 5. Verify
for p in / /contact/ /about/ /services/ /work/ /blog/ /ai-automation/ /work/isola/ /thank-you/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== New clients (expect 1 or more each on / and /work/):"
for p in / /work/; do
  page=$(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP")
  for c in Khilonaa "Suman Didi" "Vihan Sales"; do echo "$p $c $(echo "$page" | grep -oi "$c" | wc -l)"; done
done
echo
echo "Then open https://amatchless.com/work/ and check the \"Also working with\" row under Selected Work."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
