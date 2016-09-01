@extends('layouts.app4')

@section('htmlheader_title')
    Setting AD
@endsection

@section('subsidebar_title')
    广告数据管理
@endsection

@section('form_title')
    绑定账号信息
@endsection

@section('style')
@parent
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('form-content')
	

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">绑定账号信息</h3></div>
            <form class="form-horizontal">
            <div class="bod-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">编号</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->account->code }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">账号添加日期</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->account->code }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">用户名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->account->username }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">密码</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->account->password }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">生日</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->account->birthday }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">广告ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->account->idkey }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">广告备注</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->account->note }}" disabled="disable">
                    </div>
                </div>
            </div>
            </form>
            <div class="box-footer"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">绑定VPS信息</h3></div>
            <form class="form-horizontal">
            <div class="bod-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Vps Ip</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->vps->ip }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Vps 用户名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->vps->username }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Vps 密码</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->vps->password }}" disabled="disable">
                    </div>
                </div>
            </div>
            </form>
            <div class="box-footer"></div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">绑定网站信息</h3></div>
            <form class="form-horizontal">
            <div class="bod-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">网站Url</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->site->host }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">网站品牌</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->site->banner->name }}" disabled="disable">
                    </div>
                </div>
            </div>
            </form>
            <div class="box-footer"></div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">绑定时间</h3></div>
            <form class="form-horizontal">
            <div class="bod-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">绑定日期</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->created_at }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">最后更新日期</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $bind->updated_at }}" disabled="disable">
                    </div>
                </div>
            </div>
            </form>
            <div class="box-footer"></div>
        </div>
    </div>
</div>





@endsection

	
