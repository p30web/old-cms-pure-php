$( document ).ready(function() {
    // --start active menu
    var menus = $(".kt-menu__nav").children("li").each(function( index ) {
        var currentLI  = $(this);
        var elClass = $(this).attr("class").split(" "),
            elA = $(this).children("a"),
            pageURL = document.location.pathname.match(/[^\/]+$/)[0];

        if($(this).children().length > 1){
            // console.log($(this).children());

            $(this).children("div").children("ul").children("li").each(function( index ) {
                var child_iA = $(this).children("a"),
                    childLiClass =  $(this).attr("class").split(" ");
                if(jQuery.inArray("kt-menu__item--here", childLiClass) !== -1){
                    console.log( 1);
                    $(this).removeClass("kt-menu__item--here");
                }
                if(child_iA.attr('href') == pageURL){
                    console.log( 2);
                    $(this).addClass("kt-menu__item--here");
                    currentLI.addClass("kt-menu__item--here");
                }
            });
        }


        if(jQuery.inArray("kt-menu__item--here", elClass) !== -1){
            console.log( 1);
            $(this).removeClass("kt-menu__item--here");
        }
        if(elA.attr('href') == pageURL){
            console.log( 2);
            $(this).addClass("kt-menu__item--here");
        }
    });
    // --end active menu
});