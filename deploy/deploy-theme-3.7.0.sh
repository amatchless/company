#!/bin/bash
# Deploy Amatchless theme 3.7.0 (Contact page: hero with Kim on the hotline, four contact channels, the discovery-call form with a three-step "what happens next", Contact in the nav and footer). Run from the repo root ("Amatchless Website/company-repo")
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-nod0ru
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.7.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.7.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.7.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match the previous version (3.6.0, commit a4f7e8e)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive a4f7e8e wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.6.0 (should be empty apart from ._ junk):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
echo "== Files this deploy changes:"
git diff --stat a4f7e8e HEAD -- wp-content/themes/amatchless
read -p "Continue with backup and deploy? (y/N) " ok; [ "$ok" = y ] || exit 1

# 2. Backup on the server
STAMP=$(date +%Y%m%d-%H%M%S)
ssh "$SRV" "mkdir -p ~/theme-backups && cp -a ~/$LIVE ~/theme-backups/amatchless-$STAMP"
echo "Backup: ~/theme-backups/amatchless-$STAMP"

# 3. Deploy
rsync -rlptvz --delete --exclude='.git' --exclude='._*' --exclude='.DS_Store' wp-content/themes/amatchless/ "$SRV:$LIVE/"

# 4. Clear the page cache
ssh "$SRV" "cd ~/public_html && (wp cache flush || true) && rm -rf wp-content/cache/supercache/*"

# 5. Verify. The first request to / makes the theme create the Contact page (published, slug "contact").
for p in / /contact/ /about/ /services/ /work/ /blog/ /ai-automation/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== Contact page should load 3.7.0 CSS and show the new sections (expect 4 ct-card, 3 ct-step and 1 leadForm):"
curl -s -A "$UA" "https://amatchless.com/contact/?amx=$STAMP" | grep -o 'site.css?ver=3.7.0\|class="sx-card ct-card\|class="ct-step \|id="leadForm' | sort | uniq -c
echo "== Nav should link to /contact/ (expect 3: desktop nav, mobile menu, footer):"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'href="https://amatchless.com/contact/"' | wc -l
echo "Send a test enquiry from https://amatchless.com/contact/ and check it arrives at info@amatchless.com and in wp-admin → Leads."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/\""
