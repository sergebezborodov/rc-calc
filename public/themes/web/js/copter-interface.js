var CopterInterface = function () {
    var options = {
            valueInFieldChanged       :function () {},
            calcButtonClicked         :function () {},
            regenerateUrlButtonClicked:function () {},
            saveInMyListButtonClicked :function () {}
        },
        doNotSetValuesForMotors = false,
        _$form,
        _$motorManufacterSelect,
        _$motorSelect,
        loadMotorsByManufacter = function (manufacterId, success) {
            if (_motorCache.objectExist(manufacterId)) {
                success(_motorCache.get(manufacterId));
                return;
            }

            $.getJSON('/motor/loadMotorsByManufacter', {id : manufacterId}, function(resp) {
                if (!isSuccessResponce(resp)) {
                    return;
                }

                _motorCache.set(manufacterId, resp.data.motors);
                success(resp.data.motors);
            });
        },
        setValuesInGroup = function($elem, values) {
            if (typeof values == 'undefined') {
                return;
            }

            $elem.find(':input').each(function() {
                var fname = $(this).data('name');
                if (!fname) {
                    return;
                }
                if (typeof values[fname] == 'undefined') {
                    return;
                }
                var fvalue = values[fname];

                if ($(this).is(':radio')) {
                    if ($(this).val() == fvalue) {
                        $(this).attr('checked', 'checked');
                    } else {
                        $(this).removeAttr('checked');
                    }
                } else {
                    if (fvalue != null && typeof fvalue == 'object') {
                        fvalue = fvalue.join(', ');
                    }
                    $(this).val(fvalue);
                }
            });
        },
        initErrorTooltips = function () {
            _$form.on('mouseover', ':input', function() {
                if (!$(this).hasClass('error')) {
                    $(this).tooltip('destroy');
                    return;
                }
                var text = $(this).closest('div').find('.error-message').text();
                $(this).tooltip({title: text, placement: 'bottom'}).tooltip('show');
            });
        },

        // motors
        populateMotors = function (motors) {
            var html = '',
                title;
            $.each(motors, function(id, motorData) {
                if (motorData.model) {
                    title = motorData.model;
                    if (motorData.model.search(motorData.kw) == -1) {
                        title += ' - ' + motorData.kw + ' kv';
                    }
                    html += '<option value="'+id+'">'+title+'</option>';
                } else {
                    html = '<option value="'+id+'">'+motorData+'</option>' + html;
                }
            });
            _$motorSelect.html(html).trigger("chosen:updated");
        },
        initMotorManufacter = function () {
            _$motorManufacterSelect/*.chosen()*/.change(function() {
                loadMotorsByManufacter($(this).val(), function(motors) {
                    populateMotors(motors);
                    _$motorManufacterSelect.trigger('loadingDidComplete');
                });
            });
        },

        // motor model
        initMotorModel = function() {
            _$motorSelect./*chosen().*/change(function() {
                var manufacterId = _$motorManufacterSelect.val();
                var motors = _motorCache.get(manufacterId);
                if (!doNotSetValuesForMotors) {
                    setValuesInGroup($('.motor-row', _$form), motors[$(this).val()]);
                }
                _$motorSelect.trigger('valueDidSelected');
            });
        },

        initOtherLists = function() {
            $('.esc-select', _$form).chosen().change(function() {
                setValuesInGroup($('.esc-row', _$form), _escCache.get($(this).val()));
            });
            $('.battery-select', _$form).chosen().change(function() {
                setValuesInGroup($('.battery-row', _$form), _batteryCache.get($(this).val()));
            });
            $('.prop-select', _$form).chosen().change(function() {
                setValuesInGroup($('.prop-row', _$form), _propCache.get($(this).val()));
            });
        };

    return {
        valueInFieldChanged       :options.valueInFieldChanged,
        calcButtonClicked         :options.calcButtonClicked,
        regenerateUrlButtonClicked:options.regenerateUrlButtonClicked,
        saveInMyListButtonClicked :options.saveInMyListButtonClicked,

        initWithForm : function ($form) {
            _$form = $form;
            _$motorManufacterSelect = _$form.find('.motor-manufacter-select');
            _$motorSelect = _$form.find('.motor-model-select');

            initErrorTooltips();
            initMotorManufacter();
            initMotorModel();
            initOtherLists();

            _$form.find(':input').change(function() {
                CopterInterface.valueInFieldChanged($(this));
            });
            _$form.find('.regenerate-link').click(function() {
                CopterInterface.regenerateUrlButtonClicked();
                return false;
            });
            _$form.find('.calc-form-button').click(function(){
                CopterInterface.calcButtonClicked();
                return false;
            });
            _$form.find('.save-in-my-copters').click(function() {
                CopterInterface.saveInMyListButtonClicked();
                return false;
            });
            _$form.submit(function() {
                return false;
            });

            if (_$motorSelect.data('ex-id')) {
                loadMotorsByManufacter(_$motorManufacterSelect.data('ex-id'), function(motors) {
                    doNotSetValuesForMotors = true;
                    populateMotors(motors);
                    _$motorSelect.val(_$motorSelect.data('ex-id')).trigger("chosen:updated").change();
                    doNotSetValuesForMotors = false;

                    if (!$('.is-new', _$form).val()) {
                        CopterInterface.calcButtonClicked();
                    }
                });
            } else {
                if (!$('.is-new', _$form).val()) {
                    CopterInterface.calcButtonClicked();
                }
            }

            _$form.find('.calc-title.placeholder').click(function() {
                $(this).addClass('hidden');
                _$form
                    .find('.calc-title-edit')
                    .removeClass('hidden')
                    .focus();
            });
            _$form
                .find('.calc-title-edit')
                .focus(function() {
                    $(this).data('old-val', $(this).val());
                })
                .keyup(function(e) {
                    if (e.keyCode == 13 || e.keyCode == 27) {
                        if (e.keyCode == 27) {
                            $(this).val($(this).data('old-val'));
                        }
                        $(this).addClass('hidden');
                        _$form.find('.calc-title').removeClass('hidden');
                        if ($(this).val()) {
                            _$form.find('.calc-title').text($(this).val());
                        }
                    }
                });
        },

        // errors
        removeErrors: function () {
            $('.error', _$form).removeClass('error');
        },
        showErrors: function(errors) {
            $.each(errors, function(elem, error) {
                $('#'+elem)
                    .addClass('error')
                    .closest('div')
                        .find('.error-message')
                        .text(error.join(', '));
            });
        },

        showWarnings: function(warnings) {
            if (warnings === undefined) {
                return;
            }

            var $messages = $('.calc-result', _$form);
            $messages.empty().removeClass('has-error');

            if (warnings.length > 0) {
                var html = '';
                $.each(warnings, function (index, message) {
                    html += '<li>' + message + '</li>';
                });
                $messages.html(html).addClass('has-error');
            }
        },

        fillResults: function(data) {
            setValuesInGroup($('.result-row', _$form), data);
            CopterInterface.showWarnings(data.warnings);
        },
        showCalcUrl : function (url) {
            $('.calc-link-group', _$form).removeClass('hidden');
            $('.calc-link', _$form).val(url);
        },
        showProgress : function () {
            $('.calc-form-button', _$form).hide();
            $('.processing-button', _$form).show();
        },
        hideProgress : function () {
            $('.calc-form-button', _$form).show();
            $('.processing-button', _$form).hide();
        }
    }
}();
