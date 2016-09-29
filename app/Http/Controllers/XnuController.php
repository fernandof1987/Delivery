<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class XnuController extends Controller
{
    public function listaXnu($file){
        $file = public_path() . '/xnu/' . $file;
        $xml = simplexml_load_file($file);
        return view('xnu.index',  ['xml' => $xml]);
    }

    public function upload(Request $request){
        $file = $request->file('file');
        $new_file = public_path() . '/xnu/' . $file->getClientOriginalName();
        $header =  "<?xml version='1.0' encoding='windows-1252'?>\n";

        $fp = fopen ($file, 'r');
        $file = $header;

        while (!feof ($fp)) {
            $line = fgets($fp, 4096);
            $file .= str_replace('&', '', $line);

            if (strpos($line, '<DocumentProperties>')){
                $file .= '<DataAtualizacao>' . date('Y-m-d') . '</DataAtualizacao>';
            }

        }
        fclose ($fp);

        $fp2 = fopen($new_file, 'w+');
        fwrite($fp2, $file);
        fclose($fp2);

        return redirect()->back();
    }

    public function listarArquivos(){
        $path = public_path() . '/xnu';
        $files = File::files($path);
        return view('xnu.arquivos', ['files' => $files]);
    }
}
