<?php

/**
 * Return class math grid-cols dependent on $gap
 *
 * @param integer $gap
 * @return string
 */
function getGridGapClassName(int $gap): string
{
    if ($gap > 5) {
        $sm_gap = 5;
    } else {
        $sm_gap = $gap;
    }

    return "gap-{$sm_gap} md:gap-{$gap}";
}
