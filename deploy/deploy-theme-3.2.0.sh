#!/bin/bash
# Deploy Amatchless theme 3.2.0 (blog images, trust signals, contact form). Run from the repo root ("Amatchless Website/company-repo")
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-zr8mbw
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.2.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.2.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.2.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match the previous version (3.1.0, commit fd1e955)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive fd1e955 wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.1.0 (should be empty apart from ._ junk):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
read -p "Continue with backup and deploy? (y/N) " ok; [ "$ok" = y ] || exit 1

# 2. Backup on the server (theme files + the reading/category settings the theme will change)
STAMP=$(date +%Y%m%d-%H%M%S)
ssh "$SRV" "mkdir -p ~/theme-backups && cp -a ~/$LIVE ~/theme-backups/amatchless-$STAMP && cd ~/public_html && (wp option get show_on_front; wp option get page_on_front; wp option get page_for_posts; wp option get default_comment_status) > ~/theme-backups/options-$STAMP.txt 2>&1 || true"
echo "Backup: ~/theme-backups/amatchless-$STAMP"

# 3. Deploy
rsync -rlptvz --delete --exclude='.git' --exclude='._*' --exclude='.DS_Store' wp-content/themes/amatchless/ "$SRV:$LIVE/"

# 4. Clear page cache, then load the site once so the theme sets up /blog/ and the categories
ssh "$SRV" "cd ~/public_html && (wp cache flush || true) && rm -rf wp-content/cache/supercache/*"
curl -s -A "$UA" -o /dev/null https://amatchless.com/

# 5. Publish the three starter articles if they are not live yet (skips any that exist)
rsync -rz content/blog/ "$SRV:blog-drafts/"
ssh "$SRV" "cd ~/public_html && bash ~/blog-drafts/publish.sh ~/blog-drafts" || echo "(Starter posts skipped: WP-CLI not available)"
ssh "$SRV" "cd ~/public_html && bash ~/blog-drafts/covers/set-covers.sh ~/blog-drafts/covers && rm -rf wp-content/cache/supercache/*" || echo "(Cover images skipped: WP-CLI not available)"

# 6. Verify
for p in / /blog/ /services/ /work/ /about/ /ai-automation/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
curl -s -A "$UA" https://amatchless.com/blog/ | grep -o 'site.css?ver=3.2.0\|class="trustline"\|id="trust"\|id="leadForm"\|wp-post-image' | sort -u
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/\""
