var CalcApi = function () {
    var options = {
            beforeRequest  :function () {},
            successRequest :function () {},
            failRequest    :function () {},
            completeRequest:function () {}
        },
        _$form;

    return {
        beforeRequest :options.beforeRequest,
        successRequest:options.successRequest,
        failRequest   :options.failRequest,
        completeRequest:options.completeRequest,

        initWithForm  : function($form) {
            _$form = $form;
        },
        request       :function (params, beforeRequest, successRequest, failRequest, completeRequest) {
            if (typeof  params == 'object') {
                params = '?' + jQuery.param(params);
            } else {
                params = '';
            }

            if (typeof beforeRequest == 'function') {
                beforeRequest();
            }
            CalcApi.beforeRequest();
            $.ajax({
                url  : '/calc/calc'+params,
                type : 'POST',
                data : _$form.serialize(),
                dataType : 'json'
            }).done(function(resp) {
                if (resp.result == 'error') {
                    if (typeof failRequest == 'function') {
                        failRequest(resp.data);
                    }
                    CalcApi.failRequest(resp.data);
                } else {
                    if (typeof successRequest == 'function') {
                        successRequest(resp.data);
                    }
                    CalcApi.successRequest(resp.data);
                }
            })
            .fail(function() {
                if (typeof failRequest == 'function') {
                    failRequest();
                }
                CalcApi.failRequest();
            })
            .always(function() {
                if (typeof completeRequest == 'function') {
                    completeRequest();
                }
                CalcApi.completeRequest();
            });
        }
    }
}();
