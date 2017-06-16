<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Dashboard;

use App\Services\UpdateUsuario;
use App\Services\UploadAnexo;
use App\Validation\UsuarioValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UsuarioController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view()
    {
        $usuario = Auth::user();
        return view('dashboard.usuario.index', compact('usuario'));
    }

    public function update(Request $request)
    {
        $rules = ['nome' => 'required|max:191', 'senha' => 'nullable|confirmed'];

        $this->validate($request, $rules, [], UsuarioValidation::getNiceNames());
        if (UpdateUsuario::handle($request)) {
            return redirect()->route('editPerfil')->with('successAlert', 'Seus dados foram alterados com sucesso.');
        }
        return redirect()->back()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function uploadFoto(Request $request)
    {
        $rules = ['arquivo' => 'required|max:2048|image'];
        $this->validate($request, $rules, [], ['arquivo' => 'Foto']);
        if ($filename = UploadAnexo::handle($request, 'local', 'temp/')) {
            /** @var \Intervention\Image\Image $img */
            $img = Image::make(storage_path('app/temp/' . $filename));
            $base64 = (string)$img->fit(60, 60)->save(storage_path('app/temp/' . $filename))->encode('data-url');
            return response()->json(['filename' => $filename, 'url' => $base64]);
        }
        return response()->setStatusCode(500)->json(['Não foi possível fazer upload do arquivo']);
    }

}
