
    // Alert Modal Type
        $(document).on('click', '#success', function(e) {
                swal(
                        'Success',
                        'You clicked the <b style="color:green;">Success</b> button!',
                        'success'
                )
        });

        $(document).on('click', '#error', function(e) {
                swal(
                        'Error!',
                        'You clicked the <b style="color:red;">error</b> button!',
                        'error'
                )
        });

        $(document).on('click', '#warning', function(e) {
                swal(
                        'Warning!',
                        'You clicked the <b style="color:coral;">warning</b> button!',
                        'warning'
                )
        });

        $(document).on('click', '#info', function(e) {
                swal(
                        'Info!',
                        'You clicked the <b style="color:cornflowerblue;">info</b> button!',
                        'info'
                )
        });

        $(document).on('click', '#question', function(e) {
                swal(
                        'Question!',
                        'You clicked the <b style="color:grey;">question</b> button!',
                        'question'
                )
        });

    // Alert With Custom Icon and Background Image
        $(document).on('click', '#icon', function(event) {
                swal({
                        title: 'Custom icon!',
                        text: 'Alert with a custom image.',
                        imageUrl: 'https://image.shutterstock.com/z/stock-vector--exclamation-mark-exclamation-mark-hazard-warning-symbol-flat-design-style-vector-eps-444778462.jpg',
                        imageWidth: 200,
                        imageHeight: 200,
                        imageAlt: 'Custom image',
                        animation: false
                })
        });

        $(document).on('click', '#image', function(event) {
                swal({
                        title: 'Custom background image, width and padding.',
                        width: 700,
                        padding: 150,
                        background: '#fff url(https://image.shutterstock.com/z/stock-vector--exclamation-mark-exclamation-mark-hazard-warning-symbol-flat-design-style-vector-eps-444778462.jpg)'
                })
        });

    // Alert With Input Type
        $(document).on('click', '#subscribe', function(e) {
                swal({
                  title: 'Submit email to subscribe',
                  input: 'email',
                  inputPlaceholder: 'Example@email.xxx',
                  showCancelButton: true,
                  confirmButtonText: 'Submit',
                  showLoaderOnConfirm: true,
                  preConfirm: (email) => {
                    return new Promise((resolve) => {
                      setTimeout(() => {
                        if (email === 'example@email.com') {
                          swal.showValidationError(
                            'This email is already taken.'
                          )
                        }
                        resolve()
                      }, 2000)
                    })
                  },
                  allowOutsideClick: false
                }).then((result) => {
                  if (result.value) {
                    swal({
                      type: 'success',
                      title: 'Thank you for subscribe!',
                      html: 'Submitted email: ' + result.value
                    })
                  }
                })
        });

    // Alert Redirect to Another Link
        $(document).on('click', '#link', function(e) {
            swal({
                        title: "Are you sure?", 
                        text: "You will be redirected to https://utopian.io", 
                        type: "warning",
                        confirmButtonText: "Yes, visit link!",
                        showCancelButton: true
            })
                .then((result) => {
                                if (result.value) {
                                    window.location = 'https://utopian.io';
                                } else if (result.dismiss === 'cancel') {
                                    swal(
                                      'Cancelled',
                                      'Your stay here :)',
                                      'error'
                                    )
                                }
                        })
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