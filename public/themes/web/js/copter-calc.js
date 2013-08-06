$(function() {

// --- API -------------------------------------------------------------------------------------------------------------
    CalcApi.initWithForm($('#calc-form'));

    CalcApi.beforeRequest = function() {
        CopterInterface.showProgress();
    };
    CalcApi.completeRequest = function() {
        CopterInterface.hideProgress();
    };

    CalcApi.successRequest = function(data) {
        CopterInterface.removeErrors();
        CopterInterface.fillResults(data.result);
        if (data.calcUrl) {
            CopterInterface.showCalcUrl(data.calcUrl);
        }
    };

    CalcApi.failRequest = function(data) {
        CopterInterface.removeErrors();

        if (data !== undefined) {
            CopterInterface.showErrors(data.errors);
            CopterInterface.showWarnings(data.warnings);
        }
    };


    CopterInterface.calcButtonClicked = function() {
        CalcApi.request();
    };
    CopterInterface.valueInFieldChanged = function() {
        CalcApi.request();
    };
    CopterInterface.regenerateUrlButtonClicked = function() {
        $('.calc-hash').val('');
        CalcApi.request();
    };
    CopterInterface.saveInMyListButtonClicked = function () {
        CalcApi.request({saveInMyCopters : 1}, null, function(data) {
            console.log(data);
            window.location = data.calcUrl;
        });
    };

    CopterInterface.initWithForm($('#calc-form'));
});
