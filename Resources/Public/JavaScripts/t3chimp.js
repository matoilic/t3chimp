jQuery(function($) {
    function setStateSubscribe() {
        $('#subscription input, #subscription select, #subscription textarea').each(function() {
            $(this).parent('p').show();
        });
    }

    function setStateUnsubscribe() {
        $('#subscription input[type!=submit], #subscription select, #subscription textarea').each(function() {
            var input = $(this);
            var name = input.attr('name');
            if(name != 'EMAIL' && name != 'tx_t3chimp_subscription[action]') {
                input.parent('p').hide();
            }
        });
    }

    $('#cc').val($('meta[name=cc]').attr('content'));
    $('#action-subscribe').click(setStateSubscribe);
    $('#action-unsubscribe').click(setStateUnsubscribe);

    if($('#action-unsubscribe').attr('checked')) {
        setStateUnsubscribe();
    } else {
        setStateSubscribe();
    }
});