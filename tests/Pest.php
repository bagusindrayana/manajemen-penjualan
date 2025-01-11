<?php
pest()->extend(Tests\TestCase::class)->in('Feature');

function actingAs($user, $guard = null)
{
    return test()->actingAs($user, $guard);
}