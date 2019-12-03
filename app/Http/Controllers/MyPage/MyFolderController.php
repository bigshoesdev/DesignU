<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MyFolder;
use App\MyFile;
use Sentinel;

class MyFolderController extends Controller
{
    public function getFilesInfo(Request $req)
    {
        $data = array();
        $data['success'] = true;
        if ($req->get('folderID') > 0) {
            $data['files'] = Sentinel::getUser()->getFiles($req->get('folderID'));
            $data['folders'] = array();
        } else {
            $data['files'] = Sentinel::getUser()->getFiles(0);
            $data['folders'] = Sentinel::getUser()->getFolders()->get();
        }

        return json_encode($data);
    }

    public function addFile(Request $req)
    {
        $data = array();
        $user = Sentinel::getUser();

        if ($req->file('file')) {
            $index = 0;

            $errors = array();

            foreach ($req->file('file') as $file) {
                if (!empty($file)) {
                    $name = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());

                    $sameFile = MyFile::where(['user_id' => Sentinel::getUser()->id, 'name' => $name])->first();

                    if (!empty($sameFile)) {
                        array_push($errors, "The file that has name with " . $name . " already exists");
                        continue;
                    }

                    $fileName = time() . '-' . $index++ . '.' . $file->getClientOriginalExtension();

                    $destPath = './uploads/myfile/' . $user->id;
                    if (!\File::exists($destPath)) {
                        \File::makeDirectory($destPath);
                    }

                    try {
                        $file->move($destPath, $fileName);
                    } catch (Exception $e) {
                    }

                    $file = new MyFile();
                    if ($req->get('folderID'))
                        $file->folder_id = $req->get('folderID');
                    $file->user_id = Sentinel::getUser()->id;
                    $file->name = $name;
                    $file->downloadable = 0;
                    $file->folder_id = 0;
                    $file->url = "uploads/myfile/" . $user->id . "/" . $fileName;
                    $file->save();
                }
            }

            $data['success'] = true;
            $data['folders'] = Sentinel::getUser()->getFolders()->get();
            $data['files'] = Sentinel::getUser()->getFiles(0);
            $data['errors'] = $errors;

            return json_encode($data);
        }

        $data['success'] = false;

        return json_encode($data);
    }

    public function createFolder(Request $req)
    {
        $data = array();

        $sameFolder = MyFolder::where(['user_id' => Sentinel::getUser()->id, 'name' => $req->get('name')])->first();
        if (empty($sameFolder)) {
            $folder = new MyFolder;

            $folder->name = $req->get('name');
            $folder->user_id = Sentinel::getUser()->id;
            $folder->downloadable = 0;                          // not allowed;

            $folder->save();

            $data['success'] = true;
            $data['folders'] = Sentinel::getUser()->getFolders()->get();
            $data['files'] = Sentinel::getUser()->getFiles(0);
        } else {
            $data['success'] = false;
            $data['error'] = "The folder with same name exists.";
        }

        return json_encode($data);
    }

    public function changeName(Request $req)
    {
        if ($req->get('type') == "folder") {
            $item = MyFolder::where(['user_id' => Sentinel::getUser()->id, 'id' => $req->get('id')])->first();
        } else {
            $item = MyFile::where(['user_id' => Sentinel::getUser()->id, 'id' => $req->get('id')])->first();
        }
        $item->name = $req->get('name');
        $item->save();

        $data['success'] = true;

        if ($req->get('curFolderID') > 0) {
            $data['files'] = Sentinel::getUser()->getFiles($req->get('curFolderID'));
            $data['folders'] = array();
        } else {
            $data['files'] = Sentinel::getUser()->getFiles($req->get('curFolderID'));
            $data['folders'] = Sentinel::getUser()->getFolders()->get();
        }
        return json_encode($data);
    }

    public function moveFile(Request $req)
    {
        if ($req->get('fileList')) {
            foreach ($req->get('fileList') as $fileID) {
                $file = MyFile::find($fileID);
                $file->folder_id = $req->get('destFolderID');
                $file->save();
            }
        }
        $data['success'] = true;

        if ($req->get('destFolderID') > 0) {
            $data['files'] = Sentinel::getUser()->getFiles($req->get('destFolderID'));
            $data['folders'] = array();
        } else {
            $data['files'] = Sentinel::getUser()->getFiles($req->get('destFolderID'));
            $data['folders'] = Sentinel::getUser()->getFolders()->get();
        }
        return json_encode($data);
    }

    public function removeFile(Request $req)
    {
        if ($req->get('itemList')) {
            foreach ($req->get('itemList') as $item) {
                if ($item['type'] == 'folder') {
                    $folder = MyFolder::find($item['id']);

                    $files = $folder->getFiles()->get();

                    foreach ($files as $file) {
                        unlink($file->url);
                        $file->delete();
                    }

                    $folder->delete();
                } else {
                    $file = MyFile::find($item['id']);
                    unlink($file->url);
                    $file->delete();
                }
            }
        }

        $data['success'] = true;

        if ($req->get('curFolderID') > 0) {
            $data['files'] = Sentinel::getUser()->getFiles($req->get('curFolderID'));
            $data['folders'] = array();
        } else {
            $data['files'] = Sentinel::getUser()->getFiles($req->get('curFolderID'));
            $data['folders'] = Sentinel::getUser()->getFolders()->get();
        }

        return json_encode($data);
    }

    public function downloadFile(Request $req)
    {
        if ($req->get('type') == 'file') {
            $myFile = MyFile::find($req->get('id'));
            $headers = array(
                'Content-Type' => 'application/octet-stream',
            );
            $response = response()->download($myFile->url, null, $headers);

            ob_end_clean();

            return $response;
        } else {
            $myFolder = MyFolder::find($req->get('id'));
            $files = $myFolder->getFiles()->get();

            $zipName = './uploads/tmp/' . $myFolder->name . '.zip';

            $zipFile = new \ZipArchive;
            $zipFile->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            foreach ($files as $fileItem) {
                $zipFile->addFile($fileItem->url, basename($fileItem->url));
            }

            $zipFile->close();

            if(file_exists($zipName)) {
                $response = response()->download($zipName)->deleteFileAfterSend(true);
                ob_end_clean();
                return $response;
            }else {
                $response = response()->download('uploads/download.zip');
                ob_end_clean();
                return $response;
            }
        }

    }
}