@extends('index')
@section('content')
<div class="messages">
    <div class="alert alert-success" role="alert">
        <div class="alert-text"></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-danger" role="alert">
        <div class="alert-text"></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
<div class="content">
    <div class="box">
        <div class="logo">
        <img src="http://www.uello.com.br/assets/img/logo-uello-branco.png" />
        </div>
        <div class="div-buttons">
            <button class="btn-home" data-toggle="modal" data-target=".sendfile-modal"> Importar Arquivos </button>
            <button class="btn-home"> Arquivos Importados </button>
        </div>  
    </div>  
</div>

<div class="modal fade sendfile-modal" tabindex="-1" role="dialog" aria-labelledby="sendfile-modal" aria-hidden="true">
    <div class="modal-dialog modal-md">        
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Selecione o arquivo</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submitForm" action="#" method="post" enctype="multipart/form-data">
                    <div class="file-drop-area">
                        <span class="fake-btn">Selecione o arquivo</span>
                        <span class="file-msg">ou arraste até aqui</span>
                        <input class="file-input" type="file" />
                    </div>
                    <button type="submit" class="submit-file">Enviar</button>
                </form>
            </div>
        </div>
  </div>
</div>
@endsection