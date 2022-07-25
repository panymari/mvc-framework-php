<?php

namespace App\Controllers;

use App\Middleware\UserMiddleware;
use App\Models\File;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class FileController
{
    private FilesystemLoader $loader;
    protected Environment $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('./views/file');
        $this->twig = new Environment($this->loader);

        //Middlewares
        UserMiddleware::isAuthorized('email');
    }

    /**
     * Realise the logic of uploading file.
     *
     * @return void
     */

    public function index()
    {
        $files = File::all();

        echo $this->twig->render('index.twig', [
            'files' => $files,
        ]);
    }

    public function create()
    {
        $message = 'Success';

        if (isset($_POST['upload'])) {
            $file = uniqid() . "-" . $_FILES['file']['name']; //give a unique name to each file
            $fileLoc = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileType = $_FILES['file']['type'];
            $folder = 'upload/';

            $newSize = $fileSize / 1024; // convert file size in KB
            $newFileName = strtolower($file);

            $finalFileName = str_replace('', '-', $newFileName);

            if (!!File::isFormatValid($finalFileName)) {
                $message = 'The format of the file is not valid.';
                File::writeLogFile($message, $finalFileName, $fileType, $newSize);
                echo $this->twig->render('create.twig', [
                    'error' => $message,
                ]);
                die;
            }

            createFolder($folder);

            if (!disk_free_space(UPLOAD_FOLDER)) {
                $message = 'Is not enough space in storage.';
                File::writeLogFile($message, $finalFileName, $fileType, $newSize);
                echo $this->twig->render('create.twig', [
                    'error' => $message,
                ]);
                die;
            }


            if (move_uploaded_file($fileLoc, $folder . $finalFileName)) {
                File::create($finalFileName, $fileType, $newSize);
            } else {
                $message = 'Something went wrong, file is not uploaded.';
            }
            File::writeLogFile($message, $finalFileName, $fileType, $newSize);

            redirect(301, ROOT_REF_FILE);
        }

        echo $this->twig->render('create.twig', [
            'error' => $message,
        ]);
    }
}
