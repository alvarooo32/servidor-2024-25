<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CocheController extends Controller
{
    public function index () {
        $coches = [
            ["Mazda RX7"],
            ["Mercedes CLA"],
            ["Ford Mustang"],
            ["Peugeot 307 MS"],
            ["Fiat Multipla"],
            ["Citroën C15"],
            ["Mitsubichi Pajero"]
        ];

        return view('coches', ['coches' => $coches]);
    }
}
