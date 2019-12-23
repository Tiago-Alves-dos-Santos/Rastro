<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//pagina inicial do sistema
Route::get('/', function () {
    return view('index');
})->name("inicio");
//rotas da views, contem controle Views, que sao responsaveis por algumas consultas
Route::prefix("/view")->group(function(){

    //views de administrador e usuario
    Route::prefix("/duo")->group(function(){

        //view da home usuario
        Route::get('/home/usu', "ViewsC@homeUsuario")->name("user.home");
        ////******* Views do usuario *******\\\\
        //view da home admin
        Route::get('/home', "ViewsC@homeAdmin")->name("admin.home");
    });

    Route::prefix("/cadastro")->group(function(){
        //rotas de views de cadastros
        Route::get("/agendar-viagem","ViewsC@agendarViagem")->name("agendar");
        Route::get('/cadastrar_cliente',"ViewsC@cadastrarCliente")->name("create.cliente");
        Route::get('/cadastrar_motorista',"ViewsC@cadastrarMotorista")->name("create.motorista");
        Route::get('/cadastrar_usuario',"ViewsC@cadastrarUsuario")->name("create.usuario");
        Route::get('/cadastrar_veiculo',"ViewsC@cadastrarVeiculo")->name("create.veiculo");
        Route::get('/cadastrar-fornecedor',"ViewsC@cadastrarFornecedor")->name("create.fornecedor");
        Route::get('/cadastrar-despesas', "ViewsC@cadastrarDespesa")->name('create.despesa');
    });

    Route::prefix("/consulta")->group(function(){
        //rotas de views de consultas
        Route::get('/cosultar-cliente',"ViewsC@consultarCliente")->name("read.cliente");
        Route::get('/consultar-usuario',"ViewsC@consultarUsuario")->name("read.usuario");
        Route::get("/consultar-motorista","ViewsC@consultarMotorista")->name("read.motorista");
        Route::get('/consultar-veiculo', "ViewsC@consultarVeiculo")->name("read.veiculo");
        Route::get('/consultar-fornecedor', "ViewsC@consultarFornecedor")->name("read.fornecedor");
        Route::get('/consultar-viagem', "ViewsC@consultarViagem")->name("read.viagem");
        Route::get('/consultar-despesas/{id}', "ViewsC@consultarDespesa")->where('id', '[0-9]+')->name('read.despesa');
        Route::get('/buscar-viagem-unica/{id}','ViagemC@viewViagemUnica')->where('id', '[0-9]+')->name('viagem.search');
    });

    Route::prefix("/alteracao")->group(function(){
        //rotas de alteraçoes
        Route::get('/alterar-usuario/{id}', "ViewsC@alterarUsuario")->where('id', '[0-9]+')->name("alter.usuario");
        Route::get('/alterar-cliente/{id}', "ViewsC@alterarCliente")->where('id', '[0-9]+')->name("alter.cliente");
        Route::get('/alterar-fornecedor/{id}', "ViewsC@alterarFornecedor")->where('id', '[0-9]+')->name("alter.fornecedor");
        Route::get('/alterar-veiculo/{id}',"ViewsC@alterarVeiculo")->where('id', '[0-9]+')->name("alter.veiculo");
        Route::get('/alterar-motorista/{id}',"ViewsC@alterarMotorista")->where('id', '[0-9]+')->name("alter.motorista");
        Route::get('/alterar-despesa/{id_despesa}/{id_motorista}',"ViewsC@alterarDespesa")->where('id', '[0-9]+')->name("alter.despesa");
        Route::get('/alterar-viagem/{id}','ViewsC@alterarViagem')->where('id', '[0-9]+')->name('alter.viagem');
    });
});

//rotas destinadas as atividades de um usuario do tipo usuario
Route::prefix("/usuario")->group(function(){
    Route::post('/login', "UsuarioC@login")->name("user.login");
    Route::get('/logout', "UsuarioC@logout")->name("user.logout");
    Route::post('/cadastrar-cliente', "ClienteC@cadastrar")->name("user.create.cliente");
    //rotina de viagens
    Route::get('/rotina-viagens','ViagemC@rotinaViagens')->name('user.rotina.viagem');
    //rotas de alteraçoes
    Route::post('/alterar-cliente', "ClienteC@alterar")->name("user.alter.cliente");
    //rotas de filtros de buscas
    Route::any('/filtrar-cliente','ClienteC@filtrar')->name('user.filter.cliente');
    Route::get('/sobre-chronos3',function (){return view('usuario.sobre');})->name('user.sobre');
});


//rotas destinadas as atividades de um usuario do tipo admisnistrador
Route::prefix("/admin")->group(function(){
    Route::post('/cadastrar-motorista',"MotoristaC@cadastrar")->name("admin.create.motorista");
    Route::post('/cadastrar-usuario',"UsuarioC@cadastrar")->name("admin.create.usuario");
    Route::post('/cadastrar-veiculo',"VeiculoC@cadastrar")->name("admin.create.veiculo");
    Route::post('/cadastrar-fornecedor', "FornecedorC@cadastrar")->name("admin.create.fornecedor");
    Route::post('/cadastrar-despesa',"DespesasC@cadastrar")->name("admin.create.despesa");
    Route::post('/agendar-viagem', "ViagemC@agendar")->name('admin.agendar.viagem');
    //rotas de alteraçoes
    Route::post('/alterar-usuario',"UsuarioC@alterar")->name("admin.alter.usuario");
    Route::post("/alterar-fornecedor","FornecedorC@alterar")->name("admin.alter.fornecedor");
    Route::post('/alterar-veiuculo', "VeiculoC@alterar")->name("admin.alter.veiculo");
    Route::post('/alterar-motorista', "MotoristaC@alterar")->name("admin.alter.motorista");
    Route::post('/alterar-despesa-motorista', "DespesasC@alterar")->name('admin.alter.despesa');
    Route::post('/alterar-viagem','ViagemC@alterar')->name('admin.viagem.alter');
    //exeção para rota de exclusao de despesa
    Route::post('/excluir-despesa', "DespesasC@excluir")->name('admin.excluir.despesa');
    Route::any('/cancelar-viagem/','ViagemC@cancelar')->name('admin.cancelar.viagem');
    //rota de buscas
    Route::any('/buscar-viagem-unica','ViagemC@viagemUnica')->name('admin.viagem.search');
    //rotas de filtros de buscas
    Route::any('/filtrar-veiculo', 'VeiculoC@filtrar')->name('admin.filter.veiculo');
    Route::any('/filtrar-usuario', 'UsuarioC@filtrar')->name('admin.filter.usuario');
    Route::any('/filtrar-motorista', 'MotoristaC@filtrar')->name('admin.filter.motorista');
    Route::any('/filtrar-fornecedor', 'FornecedorC@filtrar')->name('admin.filter.fornecedor');
    Route::any('/filtrar-despesa', 'DespesasC@filtrar')->name('admin.filter.despesa');
    Route::any('/filtrar-viagem', 'ViagemC@filtrar')->name('admin.filter.viagem');
    //rotas emissoes de relatorios
    Route::get('/ordem-servico-print/{id}','ViagemC@printPdf')->name('admin.pdf');
    Route::post('/salario-motorista','MotoristaVViagemC@salarioPdf')->name('admin.salario');



});

