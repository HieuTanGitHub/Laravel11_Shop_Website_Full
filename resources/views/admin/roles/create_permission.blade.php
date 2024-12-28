@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cấp quyền User : {{$user->name}} 
                           @if(isset($name_roles))
                           - {{$name_roles}}
                           @endif
                        </header>
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">

                           
                           <form role="form" action="{{URL::to('/assign-permission',$user->id)}}" method="post">
                                  
                            <div class="position-center">
                               
                                    {{ csrf_field() }}
                              
                                @foreach($permission as $key => $per)
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" 
                                  @foreach($pers_role as $key => $get)

                                    @if($get->id == $per->id)
                                    checked 
                                    @endif
                                  @endforeach

                                  name="permission[]"  value="{{$per->id}}" id="{{$per->id}}">
                                  <label class="form-check-label" for="{{$per->id}}">
                                    {{$per->name}}
                                  </label>
                                </div>
                                @endforeach
                              
                                <button type="submit" name="add_post_cate" class="btn btn-info">Cấp quyền cho user</button>
                            </div>
                            
                            </form>
                        </div>
                    </section>

            </div>
@endsection