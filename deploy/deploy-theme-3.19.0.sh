#!/bin/bash
# Deploy Amatchless theme 3.19.0: new /careers/ page (why work with us, current openings, speculative applications).
# The theme creates the Careers page on the first page load after deploy (pages option bumped to 3), adds a
# "Careers" footer link and a "Careers / joining the team" option to the enquiry form. Applications sent through
# the form fire careers_application instead of generate_lead, so they don't count as Meta Pixel leads.
# Builds on 3.18.0. Run from the repo root.
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-4wrxd4
PREV=8cc21d2
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.19.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.19.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.19.0, stopping."; exit 1; }

# 1. Safety check: the live theme should be 3.18.0 (commit $PREV)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.18.0 (should be empty apart from ._ junk; if many differ, deploy 3.18.0 first):"
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
for p in / /contact/ /about/ /services/ /work/ /blog/ /ai-automation/ /work/isola/ /thank-you/ /careers/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== Careers page (expect 200, then 1 or more):"
curl -s -A "$UA" -o /dev/null "https://amatchless.com/?amx=$STAMP"   # first load creates the page
echo "/careers/ $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com/careers/?amx=$STAMP")"
echo "/careers/ 'No open roles' $(curl -s -A "$UA" "https://amatchless.com/careers/?amx=$STAMP" | grep -oi 'No open roles' | wc -l)"
echo "/ footer Careers link $(curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'href="https://amatchless.com/careers/"' | wc -l)"
echo
echo "Then open https://amatchless.com/careers/ on desktop and phone, and check the page title in the browser tab."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
