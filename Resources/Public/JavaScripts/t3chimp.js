;(function($) {
    var $doc = $(document);

    function onFormSubmit(event) {
        event.preventDefault();
        var $form = $(this);

        $form.addClass('t3chimp-loading');

        $form.ajaxSubmit({
            success: function(data) { onResponse(data, $form) },
            iframe: true,
            dataType: 'json'
        });
    }

    function onResponse(data, $form) {
        $form.parent().html(data.html);
    }

    function prop(name) {
        return $('meta[name="t3chimp:' + name + '"]').attr('content');
    }

    function setStateSubscribe(form) {
        $(form || this).parents('form').find('p').show();
    }

    function setStateUnsubscribe(form) {
        $(form || this).parents('form').find('p:not(.t3chimp-always)').hide();
    }

    $doc.on('click', '.t3chimp-field-FORM_ACTION input[value="subscribe"]', setStateSubscribe);
    $doc.on('click', '.t3chimp-field-FORM_ACTION input[value="unsubscribe"]', setStateUnsubscribe);
    $doc.on('submit', '.t3chimp-form', onFormSubmit);

    $(function() {
        $('.t3chimp-form').each(function() {
            if($(this).find('.t3chimp-field-FORM_ACTION input[value="unsubscribe"]').attr('checked')) {
                setStateUnsubscribe(this);
            } else {
                setStateSubscribe(this);
            }
        });
    });
})(window.t3chimpJQuery || window.jQuery);
