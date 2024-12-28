<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Video;
use Session;
use App\Models\CatePost;
use App\Models\Slider;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();
class VideoController extends Controller
{
	public function AuthLogin()
	{

		// if (Session::get('login_normal')) {

		// 	$admin_id = Session::get('admin_id');
		// } else {
		// 	$admin_id = Auth::id();
		// }
		// if ($admin_id) {
		// 	return Redirect::to('dashboard');
		// } else {
		// 	return Redirect::to('admin')->send();
		// }
	}
	public function video()
	{
		return view('admin.video.list_video');
	}
	public function insert_video(Request $request)
	{
		$data = $request->all();
		$video = new Video();
		$sub_link = substr($data['video_link'], 17);
		$video->video_title = $data['video_title'];
		$video->video_desc = $data['video_desc'];
		$video->video_link = $sub_link;
		$video->video_slug = $data['video_slug'];

		$get_image = $request->file('file');
		if ($get_image) {
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image));
			$new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
			$get_image->move('uploads/videos', $new_image);
			$video->video_image = $new_image;
		}
		$video->save();
	}
	public function delete_video(Request $request)
	{
		$data = $request->all();
		$video_id = $data['video_id'];

		$video = Video::find($video_id);

		unlink('uploads/videos/' . $video->video_image);

		$video->delete();
	}
	public function update_video(Request $request)
	{
		$data = $request->all();
		$video_id = $data['video_id'];
		$video_edit =  $data['video_edit'];
		$video_check =  $data['video_check'];
		$video = Video::find($video_id);

		if ($video_check == 'video_title') {

			$video->video_title = $video_edit;
		} elseif ($video_check == 'video_desc') {

			$video->video_desc = $video_edit;
		} elseif ($video_check == 'video_link') {

			$sub_link = substr($video_edit, 17);
			$video->video_link = $sub_link;
		} else {

			$video->video_slug = $video_edit;
		}
		$video->save();
	}
	public function update_video_image(Request $request)
	{
		$get_image = $request->file('file');
		$video_id = $request->video_id;
		if ($get_image) {
			$video = Video::find($video_id);
			unlink('uploads/videos/' . $video->video_image);
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image));
			$new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
			$get_image->move('uploads/videos', $new_image);
			$video->video_image = $new_image;
			$video->save();
		}
	}
	public function select_video(Request $request)
	{

		$video = Video::orderBy('video_id', 'DESC')->get();
		$video_count = $video->count();
		$output = ' <form>
    					' . csrf_field() . '
					  <table class="table table-striped b-t b-light">
					        <thead>
					          <tr>
					            <th>Thứ tự</th>
					            <th>Tên video</th>
					            <th>Slug video</th>
					            <th>Hình ảnh video</th>
					            <th>Link</th>
					            <th>Mô tả</th>
					            <th>Demo video</th>
					            <th style="width:30px;">Quản lý</th>
					          </tr>
					        </thead>
					        <tbody>

    	';
		if ($video_count > 0) {
			$i = 0;
			foreach ($video as $key => $vid) {
				$i++;
				$output .= '

    				 <tr>
    				 <td>' . $i . '</td>
			           <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_title" class="video_edit" id="video_title_' . $vid->video_id . '">' . $vid->video_title . '</td>

			           <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_slug" class="video_edit" id="video_slug_' . $vid->video_id . '">' . $vid->video_slug . '</td>

			      		<td>
			      		<img src="' . url('uploads/videos/' . $vid->video_image) . '" class="img-thumbnail" width="80" height="80">

			      		 <input type="file" class="file_img_video" data-video_id="' . $vid->video_id . '" id="file-video-' . $vid->video_id . '" name="file" accept="image/*" />

			      		</td>

			           <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_link" class="video_edit" id="video_link_' . $vid->video_id . '">https://youtu.be/' . $vid->video_link . '
			           </td>
			           <td contenteditable data-video_id="' . $vid->video_id . '" data-video_type="video_desc" class="video_edit" id="video_desc_' . $vid->video_id . '">' . $vid->video_desc . '</td>

			           <td><iframe width="200" height="200" src="https://www.youtube.com/embed/' . $vid->video_link . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></td>
			           <td><button type="button" data-video_id="' . $vid->video_id . '"  class="btn btn-xs btn-danger btn-delete-video">Xóa video</button></td>
			         </tr>
                                    



    			';
			}
		} else {
			$output .= '
    				 <tr>
                                        <td colspan="4">Chưa có video nào hết</td>
                                       
                                      </tr>


    			';
		}
		$output .= '
    				 </tbody>
    				 </table>
    				 </form>


    			';
		echo $output;
	}
	public function video_shop(Request $request)
	{
		//category post
		$category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();

		//slide
		$slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
		//seo 
		$meta_desc = "Video công ty TNHH một thành viên hiếushop";
		$meta_keywords = "thiết bị chơi game,thiet bi choi game";
		$meta_title = "Videos HiếuShop";
		$url_canonical = $request->url();
		//--seo

		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		// $all_product = DB::table('tbl_product')
		// ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
		// ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
		// ->orderby('tbl_product.product_id','desc')->get();

		$all_video = DB::table('tbl_videos')->paginate(6);

		return view('pages.video.video')->with('category', $cate_product)->with('brand', $brand_product)->with('all_video', $all_video)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post); //1
		// return view('pages.home')->with(compact('cate_product','brand_product','all_product')); //2

	}
	public function watch_video(Request $request)
	{
		$video_id = $request->video_id;
		$video = Video::find($video_id);
		$output['video_title'] = $video->video_title;
		$output['video_desc'] = $video->video_desc;

		// $output['video_link'] = '<iframe width="100%" height="400" src="https://www.youtube.com/embed/'.$video->video_link.'?rel=0&modestbranding=1&autohide=1&showinfo=0&controls=0" frameborder="0" allowfullscreen" frameborder="0" allowfullscreen></iframe>';

		$output['video_link'] = '<video id="my_yt_video" 
					       class="vlite-js" 
					       data-youtube-id="' . $video->video_link . '">
					</video>';


		echo json_encode($output);
	}
}
