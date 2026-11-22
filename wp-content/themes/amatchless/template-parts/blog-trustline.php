<?php // One-line client list under the blog heading. ?>
<p class="trustline"><span>Trusted by</span><?php foreach (amatchless_client_names() as $c) : ?><b><?php echo esc_html($c); ?></b><?php endforeach; ?></p>
