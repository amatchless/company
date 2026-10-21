#!/usr/bin/env bash
# Sets the cover images in this folder as featured images on the starter posts, with WP-CLI.
# Run from the WordPress root, with this folder's path as the first argument. Posts that already
# have a featured image are left alone, so it is safe to re-run.
set -euo pipefail
DIR="${1:?path to this folder}"
for f in "$DIR"/*.jpg; do
  slug=$(basename "$f" .jpg)
  id=$(wp post list --post_type=post --name="$slug" --post_status=publish --field=ID)
  [ -n "$id" ] || { echo "skip (no post): $slug"; continue; }
  if [ -n "$(wp post meta get "$id" _thumbnail_id 2>/dev/null || true)" ]; then echo "skip (has image): $slug"; continue; fi
  title=$(wp post get "$id" --field=post_title)
  wp media import "$f" --post_id="$id" --title="$title" --alt="$title" --featured_image --porcelain >/dev/null
  echo "cover set: $slug"
done
