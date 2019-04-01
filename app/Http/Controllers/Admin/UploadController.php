<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UploadsManager;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    /*
     * 展示目录文件
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('admin.upload.index',$data);
    }

    /*
     * 创建新目录
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder').'/'.$new_folder;

        $result = $this->manager->createDirectory($folder);

        if($result === true)
        {
            return redirect()->back()->with('success','目录「'.$new_folder.'」创建成功.');
        }

        $error = $result ?: "创建目录出错.";
        return redirect()->back()->withErrors([$error]);
    }

    /*
     * 删除目录
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder').'/'.$del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if($result === true)
        {
            return redirect()->back()->with('success','目录「'.$del_folder.'」已经删除.');
        }

        $error = $result ?: "删除目录出错.";
        return redirect()->back()->withErrors([$error]);
    }

    /*
     * 删除文件
     */
    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder').'/'.$del_file;

        $result = $this->manager->deleteFile($path);

        if($result === true)
        {
            return redirect()->back()->with('success','文件「'.$del_file.'」已经删除.');
        }

        $error = $result ?: "删除文件出错.";
        return redirect()->back()->withErrors([$error]);
    }

    /*
     * 上传文件
     */

    public function uploadFile(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file['name'];
        $path = str_finish($request->get('folder'),'/'). $fileName;
        $content = File::get($file['tmp_name']);

        $result = $this->manager->saveFile($path, $content);

        if($result === true)
        {
            return redirect()->back()->with('success','目录「'.$fileName.'」上传成功.');
        }

        $error = $result ?: "上传文件出错.";
        return redirect()->back()->withErrors([$error]);
    }
}
