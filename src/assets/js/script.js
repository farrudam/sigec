$(document).ready(function () {
    
    $.extend( $.fn.dataTable.defaults, {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/pt-BR.json'
        },        
        searching: true,
        ordering:  false
    } );
    
    
    $('#tabela').DataTable({
        columnDefs: [
            {
                targets: [0]
            }
        ]
    });
});


//Primeira implementação
//$(document).ready(function () {
//    $("#busca").keyup(function () {
//        var busca = $(this).val();
//        if (busca.length > 0) {
//            $.ajax({
//                url: $('form').attr('data-url-busca'),
//                method: 'POST',
//                data: {
//                    busca: busca
//                },
//                dataType: 'json', // Define o tipo de dados esperado como JSON
//                success: function (resultado) {
//                    if (resultado.length > 0) {
//                        var htmlResult = '<div class="card"><div class="card-body"><ul class="list-group list-group-flush">';
//                        resultado.forEach(function(usuario) {
//                            htmlResult += '<li class="list-group-item text-black">' + usuario.nome + '</li>';
//                        });
//                        htmlResult += '</ul></div></div>';
//                        $('#buscaResultado').html(htmlResult);
//                    } else {
//                        $('#buscaResultado').html('<div class="alert alert-warning">Nenhum resultado encontrado!</div>');
//                    }
//                }
//            });
//            $('#buscaResultado').show();
//        } else {
//            $('#buscaResultado').hide();
//        }
//    });
//});
// Fim da Primeira implementação



//Segunda implementação
//$(document).ready(function () {
//    $("#busca").keyup(function () {
//        var busca = $(this).val();
//        if (busca.length > 0) {
//            $.ajax({
//                url: $('form').attr('data-url-busca'),
//                method: 'POST',
//                data: {
//                    busca: busca
//                },
//                dataType: 'json', // Define o tipo de dados esperado como JSON
//                success: function (resultado) {
//                    if (resultado.length > 0) {
//                        var htmlResult = '<div class="card"><div class="card-body"><ul class="list-group list-group-flush">';
//                        resultado.forEach(function(usuario) {
//                            htmlResult += '<li class="list-group-item text-black">' + usuario.nome + '</li>';
//                        });
//                        htmlResult += '</ul></div></div>';
//                        $('#buscaResultado').html(htmlResult);
//                        
//                        // Configurar evento de clique nos resultados
//                        $('.list-group-item').click(function() {
//                            var userId = $(this).data('user-id');
//                            $.ajax({
//                                url: '{{ base_url }}/detalhar_usuario/' + userId,
//                                method: 'GET',
//                                dataType: 'json',
//                                success: function (detalhes) {
//                                    // Exibir detalhes na div "Detalhes"
//                                    var detalhesHtml = '<h6>Detalhes</h6>';
//                                    detalhesHtml += '<p>Nome: ' + detalhes.nome + '</p>';
//                                    detalhesHtml += '<p>Email: ' + detalhes.email + '</p>';
//                                    // Adicione mais informações conforme necessário
//                                    $('#detalhesUsuario').html(detalhesHtml);
//                                }
//                            });
//                        });
//                    } else {
//                        $('#buscaResultado').html('<div class="alert alert-warning">Nenhum resultado encontrado!</div>');
//                    }
//                }
//            });
//            $('#buscaResultado').show();
//        } else {
//            $('#buscaResultado').hide();
//        }
//    });
//}); 
// Fim da Segunda implementação


//$(document).ready(function () {
//    $("#busca").keyup(function () {
//        var busca = $(this).val();
//        if (busca.length > 0) {
//            $.ajax({
//                url: $('form').attr('data-url-busca'),
//                method: 'POST',
//                data: {
//                    busca: busca
//                },
//                dataType: 'json',
//                success: function (resultado) {
//                    if (resultado.length > 0) {
//                        var htmlResult = '<div class="card"><div class="card-body"><ul class="list-group list-group-flush">';
//                        resultado.forEach(function(usuario) {
//                            htmlResult += '<li class="list-group-item text-black" data-user-matricula="' + usuario.matricula + '">' + usuario.matricula + '</li>';
//                        });
//                        htmlResult += '</ul></div></div>';
//                        $('#buscaResultado').html(htmlResult);
//                    } else {
//                        $('#buscaResultado').html('<div class="alert alert-warning">Nenhum resultado encontrado!</div>');
//                    }
//                }
//            });
//            $('#buscaResultado').show();
//        } else {
//            $('#buscaResultado').hide();
//        }
//    });
//});
//
//
//$(document).on('click', '.list-group-item', function() {
//        var userMatricula = $(this).data('user-matricula');
//        console.log(userMatricula);
//        $.ajax({
//        url: '/detalhar_usuario/' + userMatricula,
//        
//        method: 'GET',
//        dataType: 'json',
//        success: function (usuario) {
//                // Exibir detalhes na div "detalhesUsuario"
//                console.log(usuario);
//                var usuarioHtml =  '<p>Nome: ' + usuario.nome + '</p>' +
//                                   '<p>Matrícula: ' + usuario.matricula + '</p>' +
//                                   '<p>Email: ' + usuario.email + '</p>' +
//                                   '<p>Foto: <img src="' + usuario.url_foto + '" alt="Foto do Usuário"></p>';
//                $('#detalhesUsuario').html(usuarioHtml); 
//            }
//        });
//    });
    // Fim da Terceira implementação
    
    
//document.addEventListener("DOMContentLoaded", function() {
//    const buscaForm = document.getElementById("buscaForm");
//    const btnBusca = document.getElementById("btnBusca");
//    const buscaResultado = document.getElementById("buscaResultado");
//
//    btnBusca.addEventListener("click", function() {
//        const buscaInput = document.getElementById("busca").value;
//        const url = `https://sistemas.tiangua.ifce.edu.br/sigec/pesquisar`;
//
//        fetch(url, {
//            method: "POST",
//            headers: {
//                "Content-Type": "application/x-www-form-urlencoded",
//            },
//            body: `busca=${buscaInput}`
//        })
//        .then(response => response.json())
//        .then(data => {
//            buscaResultado.innerHTML = ""; // Limpa os resultados anteriores
//            if (data !== null) {
//                const listItem = document.createElement("li");
//                listItem.textContent = data.nome; // Use o atributo correto para o nome
//                buscaResultado.appendChild(listItem);
//            } else {
//                buscaResultado.innerHTML = "<p>Nenhum resultado encontrado.</p>";
//            }
//        })
//        .catch(error => {
//            console.error("Erro na requisição:", error);
//        });
//    });
//});