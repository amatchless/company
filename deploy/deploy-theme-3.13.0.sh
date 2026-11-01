#!/bin/bash
# Deploy Amatchless theme 3.13.0 (new WhatsApp number +91 85869 29882; office address removed from the footer, the contact page and the schema). Run from the repo root ("Amatchless Website/company-repo")
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-gqtgs8
PREV=50d3088
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.13.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.13.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.13.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match the previous version (3.12.0, commit 50d3088)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.12.0 (should be empty apart from ._ junk):"
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
for p in / /contact/ /about/ /services/ /work/ /blog/ /ai-automation/ /work/isola/ /work/haliburton-forest/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== Home page should load 3.13.0 CSS:"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'site.css?ver=3.13.0' | sort | uniq -c || true
echo "== New WhatsApp number (expect 1 or more on each page):"
for p in / /contact/ /about/; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o 'wa.me/918586929882' | wc -l)"
done
echo "== Old number and address must be gone (expect 0 on each page):"
for p in / /contact/ /about/; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o '919050820042\|Sachdeva Tower\|110085\|Based in Rohini' | wc -l)"
done
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
