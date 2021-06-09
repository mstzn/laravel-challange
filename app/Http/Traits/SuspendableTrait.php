<?php

namespace App\Http\Traits;

trait SuspendableTrait {

    public function suspend()
    {

        $this->suspended = true;
        $this->save();

    }

}
