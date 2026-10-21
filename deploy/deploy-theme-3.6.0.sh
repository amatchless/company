#!/bin/bash
# Deploy Amatchless theme 3.6.0 (Testimonials section: client quotes with star ratings, shown only once each client approves). Run from the repo root ("Amatchless Website/company-repo")
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-em4ipx
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.6.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.6.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.6.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match the previous version (3.5.0, commit 470c99d)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive 470c99d wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.5.0 (should be empty apart from ._ junk):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
echo "== Files this deploy changes:"
git diff --stat 470c99d HEAD -- wp-content/themes/amatchless
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
for p in / /about/ /services/ /work/ /blog/ /ai-automation/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== Homepage should load 3.6.0 CSS. Testimonials stay hidden from visitors until one is approved (expect 0 tm-card while all are drafts):"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'site.css?ver=3.6.0' | sort | uniq -c
echo "tm-card count for visitors: $(curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'class="tm-card' | wc -l)"
echo "Log in to WordPress and open the homepage to preview the drafts (marked DRAFT)."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/\""
