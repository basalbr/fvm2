<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 19:12
 */

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Flysystem\FilesystemInterface;

class RemoveAnexo
{

    public static function handle(Request $request, FilesystemInterface $disk, $target)
    {
        DB::beginTransaction();
        try {
            $disk->delete($target . $request->get('arquivo'));
            return true;
        } catch (\Exception $e) {
            Log::critical($e);
            return false;
        }
    }
}