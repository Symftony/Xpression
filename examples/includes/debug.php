<?php if (null !== $exception): ?>
    <div class="content error">
        <div class="exception">
            <span>throw <?php echo get_class($exception) . ' : ' . $exception->getMessage() ?></span>
            <?php if (null !== $previousException = $exception->getPrevious()): ?>
                <div class="exception">
                    <span>throw <?php echo get_class($previousException) . ' : ' . $previousException->getMessage() ?></span>
                </div>
            <?php endif ?>
        </div>
    </div>
<?php elseif ($expression): ?>
    <div class="content">
        <fieldset>
            <legend>Expression:</legend>
            <pre><code><?php print_r($expression); ?></code></pre>
        </fieldset>
    </div>
<?php endif ?>
