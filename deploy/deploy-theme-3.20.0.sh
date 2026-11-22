#!/bin/bash
# Deploy Amatchless theme 3.20.0: job listings on /careers/. Five roles (Social Media Intern x2, Social Media
# Manager, Graphic Designer, Video Editor, Video Editor Intern x2), each with openings, type, office address,
# a short description, a full job description and Apply buttons (email with the role in the subject, or the
# contact form with the role filled in via ?role=). Adds JobPosting schema for Google. Builds on 3.19.0.
# Run from the repo root.
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-jpq3g5
PREV=6346c39
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.20.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.20.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.20.0, stopping."; exit 1; }

# 1. Safety check: the live theme should be 3.19.0 (commit $PREV)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.19.0 (should be empty apart from ._ junk; if many differ, deploy 3.19.0 first):"
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
echo "== Careers page:"
echo "/careers/ $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com/careers/?amx=$STAMP")"
echo "/careers/ role cards (expect 5) $(curl -s -A "$UA" "https://amatchless.com/careers/?amx=$STAMP" | grep -o 'class="cr-role reveal"' | wc -l)"
echo "/careers/ JobPosting schema (expect 5) $(curl -s -A "$UA" "https://amatchless.com/careers/?amx=$STAMP" | grep -o '"@type":"JobPosting"' | wc -l)"
echo "/careers/ 'No open roles' (expect 0) $(curl -s -A "$UA" "https://amatchless.com/careers/?amx=$STAMP" | grep -oi 'No open roles' | wc -l)"
echo
echo "Then open https://amatchless.com/careers/ on desktop and phone, open a full job description, and try one \"Apply with the form\" button:"
echo "the contact form should show \"Careers / joining the team\" and a message starting with the role. Paste /careers/ into Google's Rich Results Test to check the job listings."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
