(function($) {
    $(document).ready(function() {
        $('.color-field').wpColorPicker();
        $('#birthdayDate').datepicker({
                dateFormat : 'dd-mm-yyyy'
        });
        $(document).on("click", ".addpictureplayer", function(e) {
            e.preventDefault();
            var $parent = $(this).parent();
            var uploader = wp.media({
                title: "Ajouter une image de joueur",
                button : {
                    text: "Choisir un fichier"
                },
                multiple: false
            })
                .on("select", function() {
                    var selection = uploader.state().get('selection');
                    var attachment = selection.first().toJSON();
                    $('input', $parent).val(attachment.url);
                    $('img', $parent).attr("src",attachment.url);
                })
                .open();
        });
    });
})(jQuery);