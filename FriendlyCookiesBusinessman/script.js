/**
 * Created by Don on 3/15/2015.
 */
mKnowledge.registerPlugin('pluginPageCtrl', function ($scope, $http) {
    $('title').text('饼干店 - Masochist-board');

    $http({
        method: 'POST',
        url: 'api/?plugin',
        data: $.param({
            'api': 'losses.friendly.cookies.businessman'
        }),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (response) {
        if (response.message) {
            if (response.code == 403) {
                $('.get').addClass('close')
                    .text('没开门');
            }
            publicWarning(response.message);
        } else {
            var reCAPTCHA = $('<div>').addClass('g-recaptcha')
                .attr('data-sitekey', response.site_key);

            $('#reCAPTCHA').append(reCAPTCHA);
        }
    });
});

function getCookie() {
    if ($('.get').hasClass('close')) {
        publicWarning('饼干店没开你敲个啥劲……');
        return;
    }

    $('#machine').ajaxSubmit(function (data) {
        try {
            var response = JSON.parse(data);
        } catch (e) {
            publicWarning(data);
        }

        if (response.message) {
            publicWarning(response.message);
            if (response.code == 200) {
                magicalLocation('#/');
            }
        } else {
            publicWarning(response);
        }
    });

    return false;
}