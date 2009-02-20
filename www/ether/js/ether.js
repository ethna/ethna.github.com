/*
$(function()
{

    var buttonOutline = document.createElement('ul');
    $(buttonOutline).attr('id', 'ethna-debug-switch-outline');
    $('html > body').append(buttonOutline);

    var buttonEthna = document.createElement('li');
    $(buttonEthna).attr('id', 'ethna-debug-switch-Ethna');
    $(buttonEthna).attr('class', 'ethna-debug-switch');
    $(buttonEthna).text("Ethna");
    $(buttonOutline).append(buttonEthna);

    var state = {};

    $('.ethna-debug').each(function()
    {
        var name = $(this).children('div.ethna-debug-title').text();
        //var stateName = ^

        var showMessage = ' ' + name;
        var hideMessage = ' ' + name;
        state[name] = false;

        var targetId = $(this).attr('id');
        var buttonId = 'ethna-debug-switch-' + name;
        var button = document.createElement('li');
        $(button).attr('id', buttonId);
        $(button).attr('class', 'ethna-debug-switch');
        $(button).text(showMessage);

        $(button).click(function()
        {
            $('.ethna-debug').each(function()
            {
                $(this).hide();
                var local_name = $(this).children('div.ethna-debug-title').text();

                if (name != local_name) {
                    state[local_name] = false;
                    $.cookie(local_name, 0);
                }
            });

            if (!state[name]) {
                $(this).text(hideMessage);
                //$('#ethna-debug-logwindow').show();
                $('#' + targetId).show();
                $.cookie(name, 1);
                state[name] = true;
            }
            else {
                $(this).text(showMessage);
                //$('#ethna-debug-logwindow').hide();
                $('#' + targetId).hide();
                $.cookie(name, 0);
                state[name] = false;
            }
        });


        $(button).hover(function()
        {
            $(this).css('cursor', 'pointer');
        },
        function()
        {
            $(this).css('cursor', 'default');
        });

        $(buttonOutline).append(button);

        if ($.cookie(name) == 1) {
            $('#' + targetId).show();
            state[name] = true;
        }

        // log window coloring
        if($('#' + targetId)
            .is(":has('.ethna-debug-log-EMERG,.ethna-debug-log-ALERM,.ethna-debug-log-CRIT,.ethna-debug-log-ERR,.ethna-debug-log-WARNING,.ethna-debug-log-NOTICE')"))
        {
            $(button).css('background-color', "#f00")
                .css('color', "#fff");
        }
    });


    // close button
    var closeButtonEthna = document.createElement('li');
    $(closeButtonEthna).attr('id', 'ethna-debug-switch-EthnaClose');
    $(closeButtonEthna).attr('class', 'ethna-debug-switch');
    $(closeButtonEthna).text("close");
    $(closeButtonEthna).click(function(e) {
        $(buttonOutline).hide();
        return false;
    });
    $(buttonOutline).append(closeButtonEthna);

});
*/
