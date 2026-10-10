#!/usr/bin/env bash
# Publishes the three journal posts with WP-CLI. Run from the WordPress root, with this
# folder's path as the first argument. Safe to re-run: a post whose slug already exists is skipped.
set -euo pipefail
DIR="${1:?path to this folder}"
AUTHOR="${2:-1}"

publish() { # file slug category title excerpt
  local file="$1" slug="$2" cat="$3" title="$4" excerpt="$5"
  if [ -n "$(wp post list --post_type=post --name="$slug" --post_status=any --field=ID)" ]; then
    echo "skip (exists): $slug"; return
  fi
  wp term create category "$cat" --slug="$(echo "$cat" | tr 'A-Z ' 'a-z-')" >/dev/null 2>&1 || true
  local id
  id=$(wp post create "$DIR/$file" --porcelain --post_type=post --post_status=publish \
        --post_name="$slug" --post_title="$title" --post_excerpt="$excerpt" --post_author="$AUTHOR")
  wp post term set "$id" category "$cat" >/dev/null
  echo "published: $slug (ID $id) → $(wp post url "$id")"
}

publish first-profitable-ad.html first-profitable-ad "Paid Ads" \
  "The creator's guide to your first profitable ad" \
  "From break-even maths to offer, audience and creative: a beginner-friendly walkthrough for your first paid campaign."
publish brand-feels-forgettable.html why-your-brand-feels-forgettable "Branding" \
  "Why your brand feels forgettable (and how to fix it)" \
  "A simple framework to make your business instantly recognisable, in five steps and two quick tests."
publish automate-marketing-tasks.html marketing-tasks-to-automate "Automation" \
  "5 marketing tasks you should automate this month" \
  "The quick wins that free up hours every week without losing the human touch."
