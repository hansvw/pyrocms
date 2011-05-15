/*
 * trullove.js
 */
    $(document).ready(function()
    {
        initialize();
    });

/**
  * Syntactic sugar for methods.
  */
    Function.prototype.method = function (name, func) 
    {
        this.prototype[name] = func;
        return this;
    };

    function initialize() 
    {
        $('.slideshow').cycle(
        {
            fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
        });

        $('#toprotator').toggle();
        
        $(function()
        {
            $('a.lightbox').lightBox(); // Select all links in object with gallery ID
        });

        $("ul.thumb li").hover(function()
        {
            $(this).css({'z-index' : '10'}); /*Add a higher z-index value so this image stays on top*/ 
            $(this).find('img').addClass("hover").stop() /* Add class of "hover", then stop animation queue buildup*/
            .animate({
                marginTop: '-110px', /* The next 4 lines will vertically align this image */ 
                marginLeft: '-110px',
                top: '50%',
                left: '50%',
                width: '174px', /* Set new width */
                height: '131px', /* Set new height */
                padding: '20px'
            }, 200); /* this value of "200" is the speed of how fast/slow this hover animates */
        } , function()
        {
            $(this).css({'z-index' : '0'}); /* Set z-index back to 0 */
            $(this).find('img').removeClass("hover").stop()  /* Remove the "hover" class , then stop animation queue buildup*/
                .animate({
                    marginTop: '0', /* Set alignment back to default */
                    marginLeft: '0',
                    top: '0',
                    left: '0',
                    width: '120px', /* Set width back to default */
                    height: '90px', /* Set height back to default */
                    padding: '5px'
        }, 400);
        });

    }
