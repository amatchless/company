#!/bin/bash
# Deploy Amatchless theme 3.9.0 (Quick wins: cookie consent banner wired to Google Consent Mode, with "Cookie settings" in the footer; friendlier WhatsApp pre-filled message; FAQPage structured data on the services page). Run from the repo root ("Amatchless Website/company-repo")
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-9h1r79
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.9.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.9.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.9.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match the previous version (3.8.0, commit a6b9d91)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive a6b9d91 wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.8.0 (should be empty apart from ._ junk):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
echo "== Files this deploy changes:"
git diff --stat a6b9d91 HEAD -- wp-content/themes/amatchless
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
echo "== Home page should load 3.9.0 CSS:"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'site.css?ver=3.9.0' | sort | uniq -c || true
echo "== Cookie banner and consent defaults on every page (expect 2 on every line):"
for p in / /services/ /contact/ /about/ /blog/; do
  n=$(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o "id=\"cookieBanner\"\|gtag('consent','default'" | wc -l || true)
  echo "$p $n"
done
echo "== WhatsApp message (expect the new text, and 0 old ones):"
curl -s -A "$UA" "https://amatchless.com/contact/?amx=$STAMP" | grep -o 'text=Hi%20Amatchless%2C%20I%27d%20like%20to%20discuss%20a%20project%20with%20you.' | sort | uniq -c || true
curl -s -A "$UA" "https://amatchless.com/contact/?amx=$STAMP" | grep -c 'digital%20marketing%20needs' || true
echo "== FAQ schema (expect 1 on /services/, 0 on / and /contact/):"
for p in /services/ / /contact/; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o '"@type":"FAQPage"' | wc -l || true)"
done
echo "Check the services page in Google's Rich Results Test: https://search.google.com/test/rich-results?url=https%3A%2F%2Famatchless.com%2Fservices%2F"
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/\""
