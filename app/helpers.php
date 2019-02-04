<?php

use App\Training;
use Carbon\Carbon;

function getEvents()
{
    $trainings = Training::orderBy('starts_at', 'ASC')->get()->filter(function ($training) {
        $now = Carbon::now();
        $starts_at = Carbon::createFromFormat('Y-m-d H:i:s', $training->starts_at);
        return $starts_at->gt($now);
    });
    return $trainings;
}