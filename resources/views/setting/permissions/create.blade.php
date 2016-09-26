
<form class="form-horizontal" id="swal-form"  name="form" data-url="{{ route($path .'.store') }}" data-type="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-3" >权限名称</label>
        <div class="col-sm-9"><input name="name" type="text" class="form-control" placeholder="name" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" >权限ID（唯一）</label>
        <div class="col-sm-9"><input name="code" type="text" class="form-control" placeholder="ID Key" autocomplete="off"></div>
    </div>
</form>
   

