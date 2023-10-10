<?php


// Classe para exibição de mensagens SweetAlert
class SweetAlert {
    public function success($title, $text) {
        echo '<script>
            swal({
                title: "'.$title.'",
                text: "'.$text.'",
                icon: "success",
            });
        </script>';
    }

    public function error($title, $text) {
        // Lógica para exibir um SweetAlert de erro
        // Use a biblioteca SweetAlert aqui para criar e exibir a mensagem
    }

    // Adicione mais métodos conforme necessário para outros tipos de mensagens (warning, info, etc.)
}
