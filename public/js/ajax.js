var Rbac = window.Rbac || {};

/**
 * 常用AJAX
 * @module Rbac.common
 */
(function (Rbac) {

    Rbac.ajax = {

        request: function (params) {
            var params = params || {},
                _type = params.type || 'POST',
                _data = params.data || {},
				_headers = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                _successFnc = params.successFnc || function () {
                        window.location.reload();
                    },
                _successTitle = params.successTitle || '操作成功',
                _errorFnc = params.errorFnc || function () {
                        console.log('操作失败');
                    };
            $.ajax({
                url: params.href, type: _type, data: _data , headers: _headers,
            }).done(function(data){
                if(data == undefined || data.status == undefined) return _errorFnc();
                if (data.status == 1) {
                    swal({
                        title: _successTitle,
                        type: 'success',
                        confirmButtonColor: '#8CD4F5',
                    }).then(function () {
                        _successFnc(data);
                    }, function(dismiss){});
                } else if (data.status == -1) {
                    swal(data.msg, '', 'error');
                } else {
                    window.location.reload();
                }
            });
            
        },

        delete: function (params) {
            var params = params || {},
                _confirmTitle = params.confirmTitle || '确定删除该记录吗?',
                _successFnc = params.successFnc || function () {
                        window.location.reload();
                    },
                _successTitle = params.successTitle || '删除成功',
                _errorFnc = params.errorFnc || function () {
                        swal('删除失败', 'error');
                    }, _this = this;
            swal({
                title: _confirmTitle,
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true
            }).then(function(){
                if (params.type == undefined) {
                    params.type = 'DELETE';
                }
                _this.request(params);
            }, function(dismiss){});
        },

        deleteAll: function (params) {
            var ids = [];
            $(".selectall-item").each(function (e) {
                if ($(this).prop('checked')) {
                    ids.push($(this).val());
                }
            });

            if (ids.length == 0) {
                swal('请选择需要删除的记录', '', 'warning');
                return false;
            }
            params.data = {ids: ids};
            params.type = 'POST';
            this.delete(params);
        }
    };
})(Rbac);
