

	
<form class="form-horizontal" id="swal-form" data-url="{{ route($path .'.store') }}" data-type="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-3" >姓名</label>
        <div class="col-sm-9"><input name="name" type="text" placeholder="姓名" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" >登录名</label>
        <div class="col-sm-9"><input name="username" type="text" placeholder="登录名" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" >密码</label>
        <div class="col-sm-9"><input name="password" type="password" placeholder="输入密码" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" >确认</label>
        <div class="col-sm-9"><input name="password_confirmation" type="password" placeholder="确认密码" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3">角色名</label>
        <div class="col-sm-9">
            <select class="form-control" multiple="multiple" name="roles[]">
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
            </select>
        </div>
    </div>


</form>
   
