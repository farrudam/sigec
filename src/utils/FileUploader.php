<?php

namespace sigec\utils;

class FileUploader
{
    private $uploadDirectory;

    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function upload($uploadedFile, $nomeArquivo)
    {
        // Verificar se o arquivo foi enviado com sucesso
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            // Montar o caminho de destino
            $caminhoDestino = $this->uploadDirectory . DIRECTORY_SEPARATOR . $nomeArquivo;

            // Movendo o arquivo para o destino
            $uploadedFile->moveTo($caminhoDestino);

            return $caminhoDestino;
        }

        return false;
    }
}
