#!/bin/bash
# Deploy Amatchless theme 3.22.0: restyles the home page "Most agencies sell you a service" (problem -> fix)
# section so it matches the rest of the site: pink "SOUND FAMILIAR?" label, star and blob decoration,
# numbered pain cards with a coloured "THE FIX" band and the hard-shadow hover used elsewhere.
# Only front-page.php and assets/css/site.css change (plus version numbers). Builds on 3.21.0.
# Run from the repo root.
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-cz06ct
PREV=8ea6512
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.22.0 code (or run from main after the PR is merged)
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.22.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.22.0, stopping."; exit 1; }

# 1. Safety check: the live theme should be 3.21.0 (commit $PREV)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.21.0 (should be empty apart from ._ junk):"
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
for p in / /services/ /about/ /contact/ /careers/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== New section on the home page (expect 1, 6, 6):"
H=$(curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP")
echo "label $(echo "$H" | grep -c 'SOUND FAMILIAR?')"
echo "fix bands $(echo "$H" | grep -c 'class="pain-fix"')"
echo "css $(echo "$H" | grep -c 'site.css?ver=3.22.0' ) (expect 1)"
echo
echo "Then open https://amatchless.com/ and scroll to 'Most agencies sell you a service'."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
