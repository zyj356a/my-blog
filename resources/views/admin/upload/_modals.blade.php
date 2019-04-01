{{-- 创建目录 --}}
<div class="modal fade" id="modal-folder-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/upload/folder" method="POST", class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="folder" value="{{ $folder }}">
                <div class="modal-header">
                    <h4 class="modal-header">创建目录</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        x
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="new_folder_name" class="col-sm-3 col-form-label">
                            目录名
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="new_folder_name" name="new_folder" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        创建新目录
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 删除文件 --}}
<div class="modal fade" id="modal-file-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">请确认</h4>
                <button type="button" class="close" data-dismiss="modal">
                    x
                </button>
            </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确认要删除
                        <kbd><span id="delete-file-name1">file</span></kbd>
                        这个文件吗？
                    </p>
                </div>
                <div class="modal-footer">
                    <form action="/admin/upload/file" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="del_file" id="delete-file-name2">
                        <input type="hidden" name="folder" value="{{ $folder }}">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            取消
                        </button>
                        <button type="submit" class="btn btn-danger">
                            删除文件
                        </button>
                    </form>
                </div>
        </div>
    </div>
</div>

{{-- 删除目录--}}
<div class="modal fade" id="modal-folder-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">请确认</h4>
                <button type="button" class="close" data-dismiss="modal">
                    x
                </button>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>
                    确认要删除
                    <kbd><span id="delete-file-name1">file</span></kbd>
                    这个目录吗？
                </p>
            </div>
            <div class="modal-footer">
                <form action="/admin/upload/folder" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="del_folder" id="delete-folder-name2">
                    <input type="hidden" name="folder" value="{{ $folder }}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-danger">
                        删除目录
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{--上传文件--}}
<div class="modal fade" id="modal-file-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/upload/file" method="POST", enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="folder" value="{{ $folder }}">
                <div class="modal-header">
                    <h4 class="modal-header">上传新文件</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        x
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="file" class="col-sm-3 col-form-label">
                            文件
                        </label>
                        <div class="col-sm-8">
                            <input type="file" id="file" name="file">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="file" class="col-sm-3 col-form-label">
                            文件名（可选）
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="file_name" name="file_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        上传文件
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--浏览图片--}}
<div class="modal fade" id="modal-image-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">图片预览</h4>
                <button type="button" class="close" data-dismiss="modal">
                    x
                </button>
            </div>
            <div class="modal-body">
                <img src="x" alt="图片预览" class="img-responsive" id="preview-image">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    取消
                </button>
            </div>
        </div>
    </div>
</div>