#!/bin/bash
# Deploy Amatchless theme 3.4.0 (case study story pages at /work/{project}/, Work cards link to them). Run from the repo root ("Amatchless Website/company-repo")
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-17timh
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"
STORIES="isola aleuco baileys-blossoms moment haliburton-forest"

# 0. Get the 3.4.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.4.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.4.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match the previous version (3.3.0, commit a242621)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive a242621 wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.3.0 (should be empty apart from ._ junk):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
read -p "Continue with backup and deploy? (y/N) " ok; [ "$ok" = y ] || exit 1

# 2. Backup on the server
STAMP=$(date +%Y%m%d-%H%M%S)
ssh "$SRV" "mkdir -p ~/theme-backups && cp -a ~/$LIVE ~/theme-backups/amatchless-$STAMP"
echo "Backup: ~/theme-backups/amatchless-$STAMP"

# 3. Deploy
rsync -rlptvz --delete --exclude='.git' --exclude='._*' --exclude='.DS_Store' wp-content/themes/amatchless/ "$SRV:$LIVE/"

# 4. The first page load creates the five story pages under Work; then clear the page cache
curl -s -A "$UA" -o /dev/null "https://amatchless.com/?amx=$STAMP"
ssh "$SRV" "cd ~/public_html && (wp cache flush || true) && rm -rf wp-content/cache/supercache/*"
echo "== Story pages in WordPress:"
ssh "$SRV" "cd ~/public_html && wp post list --post_type=page --fields=ID,post_name,post_parent,post_status --format=table" | grep -E "post_name|work|isola|aleuco|baileys|moment|haliburton" || true

# 5. Verify
for p in / /about/ /services/ /work/ /blog/ /ai-automation/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
for s in $STORIES; do
  echo "/work/$s/ $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com/work/$s/")"
  echo "clients/$s.svg $(curl -s -A "$UA" -o /dev/null -w '%{http_code} %{content_type}' "https://amatchless.com/wp-content/themes/amatchless/assets/img/clients/$s.svg")"
done
echo "== Work cards should point at the story pages:"
curl -s -A "$UA" https://amatchless.com/work/ | grep -o 'href="https://amatchless.com/work/[a-z-]*/"' | sort -u
curl -s -A "$UA" https://amatchless.com/work/isola/ | grep -o 'site.css?ver=3.4.0\|class="chapter\|Visit their website' | sort -u
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/\""
echo "(The five story pages stay under Pages in wp-admin after a rollback; move them to Trash there if you roll back.)"
