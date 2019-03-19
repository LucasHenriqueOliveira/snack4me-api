<?php

namespace App\Http\Validators;

use Illuminate\Http\Request;

trait ValidatesEventRequests
{

    protected function validateNew(Request $request)
    {
        $this->validate($request, [
            'title'          => 'required|string|min:10',
            'starts_at'      => 'required|date',
            'ends_at'        => 'required|date|after:starts_at'
        ]);
    }

    protected function validateUpdate(Request $request)
    {
        $this->validate($request, [
            'id'            => 'required|exists:events,id',
            'title'          => 'required|string|min:10',
            'starts_at'      => 'required|date',
            'ends_at'        => 'required|date|after:starts_at'
        ]);
    }

}