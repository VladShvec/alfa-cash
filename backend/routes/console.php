<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:fetch-sheepy-currencies-command')->daily();
Schedule::command('app:fetch-binance-currencies-command')->daily();
