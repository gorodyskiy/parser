<?php

use App\Workers\WorkerOlx;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::call(new WorkerOlx)->everyMinute();
