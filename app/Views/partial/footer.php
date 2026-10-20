<?php

use Config\OSPOS;

?>

            </div>
        </main>

        <div id="footer">
            <div class="bg-body-tertiary p-4 push-spaces">
                <strong>
                    <?= lang('Common.copyrights', [date('Y')]) ?> ·
                    <a href="https://opensourcepos.org" target="_blank"><?= lang('Common.website') ?></a> ·
                    <?= esc(config('App')->application_version) ?> -
                    <a target="_blank" href="https://github.com/opensourcepos/opensourcepos/commit/<?= esc(config(OSPOS::class)->commit_sha1) ?>">
                        <?= esc(substr(config(OSPOS::class)->commit_sha1, 0, 6)); ?>
                    </a>
                </strong>.
            </div>
        </div>
    </body>
</html>
