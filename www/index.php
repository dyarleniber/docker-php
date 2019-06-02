<?php

try {
    echo 'Current PHP version: ' . phpversion();
} catch (\Throwable $t) {
    echo 'Error: ' . $t->getMessage();
}
