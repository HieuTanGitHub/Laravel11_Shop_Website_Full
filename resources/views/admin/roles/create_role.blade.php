@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cấp vai trò User :{{$user->name}}
                        </header>
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/assign-role',$user->id)}}" method="post">
                                    {{ csrf_field() }}
                                @foreach($roles as $key => $role)   
                                    @if(isset($user_roles)) 
                                    <div class="radio">
                                      <label><input type="radio" {{$role->id==$user_roles->id ? 'checked' : ''}} name="role" value="{{$role->id}}">{{$role->name}}</label>
                                    </div>   
                                    @else
                                     <div class="radio">
                                      <label><input type="radio"  name="role" value="{{$role->id}}">{{$role->name}}</label>
                                    </div>  
                                    @endif
                                @endforeach
                                
                               <button type="submit" name="add_post_cate" class="btn btn-info">Cấp vai trò cho user</button>
                              
                            </div>


                              </form>
                        </div>
                    </section>

            </div>
@endsection