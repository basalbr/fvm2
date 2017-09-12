<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Noticia extends Model
{

    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'data_publicacao'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'noticia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'titulo_destaque', 'slug', 'subtitulo', 'capa', 'data_publicacao', 'conteudo'];

    public function setDataPublicacaoAttribute($value)
    {
        $this->attributes['data_publicacao'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getCapaUrl($type){
        return asset(public_path().'storage/noticias/'.($type=='destaque' ? '' : 'thumb/').$this->capa);
    }

    public static function storeCapa($file){
        $filename = md5(random_bytes(5)) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('noticias/', $filename, 'public');
        $filePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().'noticias/'.$filename;
        $img = Image::make($filePath);
        $img->resize(null, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save();
        $thumb = Image::make($filePath);
        $thumb->resize(null, 250, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::disk('public')->put('noticias/thumb/'.$filename, (string)$thumb->encode('jpg'));
        return $filename;
    }

}
