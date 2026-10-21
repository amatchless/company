#!/bin/bash
# Deploy Amatchless theme 3.8.0 (Remove the cartoon show names and quoted lines: team cards drop the "Alter ego inspired by" credit, new lines for Blossom, Dexter and Kim, Kim's contact bubble rewritten, "Dexter's lab" becomes "the lab" in the case studies). Run from the repo root ("Amatchless Website/company-repo")
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-xb075c
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.8.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.8.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.8.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match the previous version (3.7.0, commit caa7802)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive caa7802 wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.7.0 (should be empty apart from ._ junk):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
echo "== Files this deploy changes:"
git diff --stat caa7802 HEAD -- wp-content/themes/amatchless
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
echo "== About page should load 3.8.0 CSS:"
curl -s -A "$UA" "https://amatchless.com/about/?amx=$STAMP" | grep -o 'site.css?ver=3.8.0' | sort | uniq -c
echo "== Show names and quoted lines left on the site (expect 0 on every line):"
for p in / /about/ /contact/ /work/isola/ /work/haliburton-forest/; do
  n=$(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -o -i "Johnny Bravo\|Powerpuff\|Dexter&#039;s Laboratory\|Dexter's Laboratory\|Kim Possible\|Alter ego inspired\|beep me\|beep her\|Sugar, spice\|Dexter&#8217;s lab\|Dexter&#039;s lab" | wc -l)
  echo "$p $n"
done
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/\""
