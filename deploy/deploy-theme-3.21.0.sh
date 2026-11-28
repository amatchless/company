#!/bin/bash
# Deploy Amatchless theme 3.21.0: new company phone and WhatsApp number +91 92667 36111 (replaces +91 85869 29882)
# on every WhatsApp button and link, the floating WhatsApp button, the ad landing pages' Call buttons and /thank-you/.
# Builds on 3.20.0. Run from the repo root.
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-mfpe9w
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

# 4. Clear the page cache
ssh "$SRV" "cd ~/public_html && (wp cache flush || true) && rm -rf wp-content/cache/supercache/*"

# 5. Verify
for p in / /contact/ /about/ /services/ /work/ /blog/ /ai-automation/ /work/isola/ /thank-you/ /careers/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== Number check on every main page (old should be 0, new should be 1 or more):"
for p in / /contact/ /about/ /services/ /work/ /blog/ /careers/ /thank-you/ /privacy-policy/ /terms/; do
  h=$(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP")
  echo "$p old=$(echo "$h" | grep -o '8586929882\|85869 29882\|9050820042\|90508 20042' | wc -l) new=$(echo "$h" | grep -o '9266736111\|92667 36111' | wc -l)"
done
echo
echo "Then open https://amatchless.com/ on your phone and tap the green WhatsApp button: it should open a chat with +91 92667 36111."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
