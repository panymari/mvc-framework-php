<?php

namespace App\Controllers;

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
    }

    /**
     * Realise the logic of uploading file.
     *
     * @return void
     */

    public function index()
    {
        $message = 'hello';
        $files = File::all();

        echo $this->twig->render('index.twig', [
            'files' => $files,
        ]);
    }

    public function create()
    {
        $message = 'Success';

        if (isset($_POST['upload'])) {
            $file = $_FILES['file']['name']; //give a unique name to each file
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder = 'upload/';

            $new_size = $file_size / 1024; // convert file size in KB
            $new_file_name = strtolower($file);

            $final_file_name = str_replace('', '-', $new_file_name);

            if (!!File::isFormatValid($final_file_name)) {
                $message = 'The format of the file is not valid.';
                File::writeLogFile($message, $final_file_name, $file_type, $new_size);
                echo $this->twig->render('create.twig', [
                    'error' => $message,
                ]);
                die;
            }

            File::createFolder($folder);

            if (!disk_free_space(UPLOAD_FOLDER)) {
                $message = 'Is not enough space in storage.';
                File::writeLogFile($message, $final_file_name, $file_type, $new_size);
                echo $this->twig->render('create.twig', [
                    'error' => $message,
                ]);
                die;
            }

            File::writeLogFile($message, $final_file_name, $file_type, $new_size);

            if (move_uploaded_file($file_loc, $folder.$final_file_name)) {
                File::create($final_file_name, $file_type, $new_size);
            }

            redirect(301, ROOT_REF_FILE);
        }

        echo $this->twig->render('create.twig', [
            'error' => $message,
        ]);
    }
}
