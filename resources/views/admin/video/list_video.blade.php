@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê videos
    </div>
    <div class="row w3-res-tb">
     {{--  <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div> --}}
     
      <div class="col-sm-12">
        <div class="position-center">
                                <form>
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên video</label>
                                    <input type="text" name="video_title" class="form-control video_title" onkeyup="ChangeToSlug();" id="slug" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug video</label>
                                    <input type="text" name="video_slug" class="form-control video_slug" id="convert_slug" placeholder="Slug">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Link video</label>
                                    <input type="text" name="link_video" class="form-control video_link" id="convert_slug" placeholder="Slug">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả video</label>
                                    <textarea style="resize: none" rows="8" class="form-control video_desc" name="video_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục"></textarea>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputPassword1">Hình ảnh video</label>
                                     <input type="file" class="form-control" id="file_img_video" name="file" accept="image/*" >
                                </div>

                              {{--   <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                      <select name="brand_product_status" class="form-control input-sm m-bot15">
                                            <option value="0">Hiển thị</option>
                                            <option value="1">Ẩn</option>
                                            
                                    </select>
                                </div>
                                --}}
                                <button type="button" name="add_video" id="btn-add-video" class="btn btn-info">Thêm video</button>
                                </form>
                                <div id="notify"></div>
                            </div>
      </div>
    </div>
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>

   
         <div id="video_load"></div>



    </div>
  
  </div>

  <!-- Modal -->
  <div class="modal fade" id="video_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tên video</h5>
         {{--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> --}}
        </div>
        <div class="modal-body">
          Video here
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
         
        </div>
      </div>
    </div>
  </div>
</div>
@endsection