#!/bin/bash
# Deploy Amatchless theme 3.21.0: new official phone number +91 92667 36111, the only number on the site.
# The phone (landing pages, /thank-you/, tel: links) and every WhatsApp button (wa.me/919266736111) now use it.
# Also finds the old numbers (+91 85869 29882, +91 90508 20042) in page content saved in WordPress
# (e.g. Privacy Policy, Terms) and offers to replace them, after a database backup. Builds on 3.20.0.
# Run from the repo root.
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-1qocvv
PREV=da70dca
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.21.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.21.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.21.0, stopping."; exit 1; }

# 1. Safety check: the live theme should be 3.20.0 (commit $PREV)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.20.0 (should be empty apart from ._ junk; if many differ, deploy 3.20.0 first):"
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

# 4. Old numbers saved in WordPress content (pages, widgets, settings): count, then replace if you agree
OLD=("+91 85869 29882" "+91-85869-29882" "85869 29882" "8586929882" "+91 90508 20042" "+91-90508-20042" "90508 20042" "9050820042")
NEW=("+91 92667 36111" "+91 92667 36111" "92667 36111" "9266736111" "+91 92667 36111" "+91 92667 36111" "92667 36111" "9266736111")
echo "== Old numbers in the WordPress database (dry run, nothing changed yet):"
for i in "${!OLD[@]}"; do
  n=$(ssh "$SRV" "cd ~/public_html && wp search-replace '${OLD[$i]}' '${NEW[$i]}' --skip-columns=guid --dry-run --format=count" 2>/dev/null || echo "?")
  echo "  ${OLD[$i]}: $n"
done
read -p "Replace them with +91 92667 36111 (a database backup is taken first)? (y/N) " ok
if [ "$ok" = y ]; then
  ssh "$SRV" "mkdir -p ~/db-backups && cd ~/public_html && wp db export ~/db-backups/amatchless-$STAMP.sql"
  echo "Database backup: ~/db-backups/amatchless-$STAMP.sql"
  for i in "${!OLD[@]}"; do
    ssh "$SRV" "cd ~/public_html && wp search-replace '${OLD[$i]}' '${NEW[$i]}' --skip-columns=guid --precise --format=count"
  done
fi

# 5. Clear the page cache
ssh "$SRV" "cd ~/public_html && (wp cache flush || true) && rm -rf wp-content/cache/supercache/*"

# 6. Verify
PAGES="/ /contact/ /about/ /services/ /work/ /blog/ /ai-automation/ /careers/ /thank-you/ /privacy-policy/ /terms/ /lp/influencer-marketing/ /lp/seo-check/"
for p in $PAGES; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== New WhatsApp link (expect 1 or more on each page):"
for p in / /contact/ /thank-you/ /lp/influencer-marketing/; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o 'wa.me/919266736111' | wc -l)"
done
echo "== New phone on the landing pages and /thank-you/ (expect 1 or more):"
for p in /thank-you/ /lp/influencer-marketing/ /lp/seo-check/; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o '92667 36111\|919266736111' | wc -l)"
done
echo "== Old numbers must be gone (expect 0 on each page):"
for p in $PAGES; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o '85869[ -]\?29882\|8586929882\|90508[ -]\?20042\|9050820042' | wc -l)"
done
echo
echo "Then tap the WhatsApp button on your phone: it should open a chat with +91 92667 36111."
echo "To roll back the theme: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
echo "To roll back the database (only if you replaced above): ssh $SRV \"cd ~/public_html && wp db import ~/db-backups/amatchless-$STAMP.sql\""
