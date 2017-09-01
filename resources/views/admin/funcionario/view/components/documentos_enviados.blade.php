@include('admin.components.uploader.default', [
'anexos'=>$funcionario->anexos()->orderBy('created_at', 'desc')->get(),
'idReferencia'=>$funcionario->id,
'referencia'=>$funcionario->getTable()
])