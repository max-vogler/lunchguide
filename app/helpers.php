<?php

function readable_price($price) {
    return sprintf('%.2f €', 0.01 * $price);
}

function readable_date(\Carbon\Carbon $date) {
    return $date->isToday() ? 'Heute' : $date->formatLocalized('%A, %d.%m.');
}

// from https://gist.github.com/mudge/5948769
function retry($f, $delay = 10, $retries = 3) {
    try {
        return $f();
    } catch (Exception $e) {
        if ($retries > 0) {
            sleep($delay);
            return retry($f, $delay, $retries - 1);
        } else {
            throw $e;
        }
    }
}

function url_date($date) {
    return str_replace('-', '/', $date->toDateString());
}

function str_contains_insensitive($haystack, $needle) {
    return stristr($haystack, $needle) !== false;
}

function obfuscate($text, $hiddenClass = 'h0', $visibleClass = 'v0') {
    $realChars = str_split($text);
    $fakeChars = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ");

    return implode('', array_map(function ($realChar) use ($hiddenClass, $visibleClass, $fakeChars) {
        return sprintf(
            '<span class="%1$s">%3$s</span><span class="%2$s">%4$s</span>',
            $visibleClass,
            $hiddenClass,
            $realChar,
            $fakeChars[rand(0, count($fakeChars) - 1)]
        );
    }, $realChars));
}

Form::macro('csrf', function () {
    return Form::hidden('_token', csrf_token());
});
