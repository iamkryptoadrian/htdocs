<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Output\BufferedOutput;


class ArtisanCommandController extends Controller
{
    public function showCommandPage()
    {
        return view('admin.command');
    }

    public function runCommand(Request $request)
    {
        $this->validate($request, [
            'command' => 'required|string',
        ]);

        $command = $request->input('command');

        $output = new BufferedOutput();
        try {
            Artisan::call($command, [], $output);
            $result = $output->fetch();
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return response()->json(['output' => $result]);
    }

}
