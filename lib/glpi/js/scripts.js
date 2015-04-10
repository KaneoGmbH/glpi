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
    var $currentActive = $('.nav').find('li.active');
    if(!$currentActive){
        $('[data-toggle="tabajax"]').first().trigger('click');
    }else{
        $currentActive.find('a').trigger('click');
    }
});