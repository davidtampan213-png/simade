<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
if (!$user) { echo "No user found\n"; exit; }
Auth::login($user);
session()->put("active_role", "mahasiswa");

$request = Illuminate\Http\Request::create("/dashboard/mahasiswa", "GET");
$request->setLaravelSession(session());
$response = $app->make(Illuminate\Contracts\Http\Kernel::class)->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() >= 400) { echo $response->getContent(); }
else { echo "Success\n"; }

