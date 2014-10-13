function defaultLanguage() {
    var possible = ["nl", "en", "fr"];
    var index = possible.indexOf(navigator.language);
    var language = index !== -1 ? possible[index] : "nl"
    return language
}

function showLanguage(language) {
    $("div#text > div").each( function() {
        if ($(this).attr("class") !== language) {
            $(this).hide();
            $("div#select_language div." + $(this).attr("class")).removeClass("active");
        }
        else {
            if ($(this).is(':hidden')) {
                $(this).show();
            }
            $("div#select_language div." + language).addClass("active");
        }
    });
};

$(function() {

    $("div#select_language div a").each (function() {
        $(this).parent().html($(this).html());
        $(this).remove();  
    });

    showLanguage(defaultLanguage());

    $("div#select_language div").click(function(event){
        showLanguage($(this).attr("class"));
    })
})

