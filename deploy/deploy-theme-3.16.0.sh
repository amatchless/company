#!/bin/bash
# Deploy Amatchless theme 3.16.0: ad landing pages (/lp/influencer-marketing/, /lp/seo-check/), /thank-you/,
# the ad lead form (Google Sheet, email, Conversions API), Privacy Policy + Terms links in the footer and under the
# forms, and the Rohini address in the footer. Builds on 3.15.0 (live). Run from the repo root ("Amatchless Website/company-repo").
set -euo pipefail
SRV=hbiwnax0azbu@118.139.163.39
LIVE=public_html/wp-content/themes/amatchless
BRANCH=claude/project-thread-1u0r5q
PREV=fdd2b83
UA="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126 Safari/537.36"

# 0. Get the 3.16.0 code
git fetch origin "$BRANCH" && git checkout -B "$BRANCH" "origin/$BRANCH"
grep -q "Version: 3.16.0" wp-content/themes/amatchless/style.css || { echo "Not on 3.16.0, stopping."; exit 1; }

# 1. Safety check: the live theme should match 3.15.0 (main, commit fdd2b83)
rm -rf /tmp/amx-prev && mkdir -p /tmp/amx-prev && git archive "$PREV" wp-content/themes/amatchless | tar -x -C /tmp/amx-prev
echo "== Live files that differ from GitHub 3.15.0 (should be empty apart from ._ junk):"
rsync -rcn --delete --exclude='._*' --exclude='.DS_Store' -i "$SRV:$LIVE/" /tmp/amx-prev/wp-content/themes/amatchless/ | grep -v '^\.d' || true
echo "== Existing pages with the slugs this deploy creates (should be empty, or only privacy-policy/terms):"
ssh "$SRV" "cd ~/public_html && wp post list --post_type=page --post_status=any --post_name__in=lp,influencer-marketing,seo-check,thank-you --fields=ID,post_name,post_status,post_parent" || true
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

# 5. Verify (the first request creates the /lp/ and /thank-you/ pages)
for p in / /contact/ /about/ /services/ /work/ /blog/ /ai-automation/ /work/isola/ /privacy-policy/ /terms/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
sleep 2
echo "== New pages (expect 200, 200, 200, and 302 for /lp/):"
for p in /lp/influencer-marketing/ /lp/seo-check/ /thank-you/ /lp/; do
  echo "$p $(curl -s -A "$UA" -o /dev/null -w '%{http_code}' "https://amatchless.com$p")"
done
echo "== noindex on each new page (expect 1 each):"
for p in /lp/influencer-marketing/ /lp/seo-check/ /thank-you/; do
  echo "$p $(curl -s -A "$UA" "https://amatchless.com$p?amx=$STAMP" | grep -ci "<meta name=.robots. content=.noindex")"
done
echo "== New pages in the sitemap (expect 0):"
curl -s -A "$UA" "https://amatchless.com/page-sitemap.xml?amx=$STAMP" | grep -cE '/lp/|/thank-you/' || true
echo "== Footer Privacy Policy + Terms links on the home page (expect 2):"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -oE 'href="https://amatchless.com/(privacy-policy|terms)/">(Privacy Policy|Terms)<' | sort -u | wc -l
echo "== Home page loads 3.16.0 JS:"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -o 'site.js?ver=3.16.0' | sort | uniq -c || true
echo "== Domain verification tag still in the home page (expect 1):"
curl -s -A "$UA" "https://amatchless.com/?amx=$STAMP" | grep -c 'name="facebook-domain-verification" content="3qz4csx5tyaqf2irotm4jtqstmemi9"' || true
echo "== Lead form handler answers (expect a JSON error, nothing is saved):"
curl -s -A "$UA" -d 'action=amatchless_lp&lp=none' https://amatchless.com/wp-admin/admin-ajax.php; echo
echo "== CSP allows Turnstile and Calendly (expect 1):"
curl -s -A "$UA" -D - -o /dev/null "https://amatchless.com/thank-you/?amx=$STAMP" | grep -i '^content-security-policy' | grep -c 'challenges.cloudflare.com.*calendly' || true
echo
echo "Next: follow docs/ad-landing-pages-setup.md (Google Sheet, Turnstile, Pixel ID and token in wp-admin → Settings → Ad leads, GTM tags)."
echo "To roll back: ssh $SRV \"rsync -a --delete ~/theme-backups/amatchless-$STAMP/ ~/$LIVE/ && rm -rf ~/public_html/wp-content/cache/supercache/*\""
echo "(After a roll back, also move the new pages to the trash: wp post delete \$(wp post list --post_type=page --post_name__in=influencer-marketing,seo-check,thank-you,lp --format=ids) and wp option delete amatchless_lp_pages_created)"
