<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2017
 * Time: 20:48
 */

namespace App\Http\Controllers\Admin;

use App\Models\Noticia;
use App\Services\CreateNoticia;
use App\Services\UpdateNoticia;
use App\Validation\NoticiaValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NoticiaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $noticias = Noticia::orderBy('data_publicacao', 'desc')->orderBy('created_at', 'desc')->get();
        return view('admin.noticias.index', compact('noticias'));
    }

    public function new()
    {
        return view('admin.noticias.new.index');
    }

    public function view($id)
    {
        $noticia = Noticia::findOrFail($id);
        return view('admin.noticias.view.index', compact('noticia'));
    }

    public function store(Request $request)
    {
        if (CreateNoticia::handle($request)) {
            return redirect()->route('listNoticiasToAdmin')->with('successAlert', 'Notícia cadastrada com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    public function update(Request $request, $id)
    {
        if (UpdateNoticia::handle($request, $id)) {
            return redirect()->route('listNoticiasToAdmin')->with('successAlert', 'Notícia editada com sucesso');
        }
        return redirect()->back()->withInput()->withErrors(['Ocorreu um erro inesperado']);
    }

    /**
     * @param Request $request
     */
    public function validateNoticia(Request $request)
    {
        $this->validate($request, NoticiaValidation::getRules(), [], NoticiaValidation::getNiceNames());
    }


}
