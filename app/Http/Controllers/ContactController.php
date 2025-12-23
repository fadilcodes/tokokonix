<?php

namespace App\Http\Controllers;

use App\Models\barang; // 1. Import model Barang
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view ('contact');
    }
}
