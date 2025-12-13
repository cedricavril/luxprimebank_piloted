<?php
function capture_output(callable $callback): string {
    ob_start();
    $callback();
    return ob_get_clean();
}
