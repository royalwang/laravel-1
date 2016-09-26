
    
<form class="form-horizontal" id="swal-form" name="form" data-url="{{ route($path .'.store') }}" data-type="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-3" >角色名称</label>
        <div class="col-sm-9"><input name="name" type="text" placeholder="角色名称" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" >角色ID(唯一)</label>
        <div class="col-sm-9"><input name="code" type="text" placeholder="Id Key" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3">拥有权限</label>
        <div class="col-sm-9">
            <select class="form-control" multiple="multiple" name="permissions[]">
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" >默认页面</label>
        <div class="col-sm-9"><input name="default_page" placeholder="默认页面" type="text" class="form-control" autocomplete="off"></div>
    </div>
</form>
    

