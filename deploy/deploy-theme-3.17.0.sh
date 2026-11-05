#!/bin/bash
# Deploy Amatchless theme 3.17.0: Calendly booking (https://calendly.com/amatchless).
# "Book a call" in the header, the home page hero, services and contact CTAs, and the /contact/ hero and first card
# now open Calendly as a popup. The enquiry form stays, and its thank-you message offers a time slot too.
# Builds on 3.16.0: deploy 3.16.0 first (deploy-theme-3.16.0.sh). Run from the repo root.
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-6tn7ug
PREV=66892d8
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.17.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.17.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.17.0, stopping."; exit 1; }

# 1. Safety check: the live theme should be 3.16.0 (commit $PREV)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.16.0 (should be empty apart from ._ junk; if many differ, deploy 3.16.0 first):"
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
echo "== Calendly booking links (expect 3 or more on /, 4 or more on /contact/):"
for p in / /contact/; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o 'data-calendly' | wc -l)"
done
echo "== Home page loads 3.17.0 JS:"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'site.js?ver=3.17.0' | sort | uniq -c || true
echo
echo "Then open https://amatchless.com/ in a browser, click \"Book a call\" and check the Calendly popup opens."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
