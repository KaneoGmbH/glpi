/**
 * Tabs
 */
$(document).ready(function () {

    $('[data-toggle="tabajax"]').click(function (e) {

        e.preventDefault();

        var $this = $(this),
            loadurl = $this.attr('href'),
            target = $this.attr('data-target');

        $.get(loadurl, function (data) {
            $(target).html(data);
        });

        $this.tab('show');

        return false;

    });

    $('[data-toggle="tabajax"]').first().trigger('click');

});