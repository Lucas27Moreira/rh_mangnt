<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($url)
    {
        echo "Confirming account with URL: " . $url;
    }
}
